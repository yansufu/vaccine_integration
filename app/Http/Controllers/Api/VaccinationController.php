<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Vaccinations;
use App\Models\Providers;
use App\Models\Children;
use App\Http\Controllers\Controller;
use App\Http\Resources\VaccinationResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class VaccinationController extends Controller
{
    public function index(){
        $vaccination = Vaccinations::with(['vaccine', 'provider.organization', 'child'])->get(); 
        if($vaccination->count() > 0)
        {
            return VaccinationResource::collection($vaccination);
        }   
        else
        {
            return response()->json(['message' => 'No Data'], 200);
        }
    }

    public function show(Vaccinations $vaccination){
        return new VaccinationResource($vaccination);
    }

    public function destroy(Vaccinations $vaccination){
        $vaccination->delete();
        return response()->json(['message' => 'delete vaccination'], 200);
    }

    public function updateAfterScan(Request $request, $child_id)
    {
        $data = $request->all();
        if (!is_array($data)) {
            return response()->json(['error' => 'Invalid payload format. Expected an array.'], 400);
        }
        foreach ($data as $entry) {
            $validator = Validator::make($entry, [
                'vaccine_id' => 'required|integer',
                'prov_id' => 'required|integer',
                'lot_id' => 'required|string|max:255',
                'notes' => 'nullable|string|max:255',
            ]);

            if($validator->fails()){
                return response()->json(
                ['message' => 'invalid data format', 'errors' => $validator->errors()], 422);
            };

            $validated = $validator->validated();

            $vaccination = Vaccinations::where('child_id', $child_id)
                ->where('vaccine_id', $validated['vaccine_id'])
                ->firstOrFail();

            $provider = Providers::findOrFail($validated['prov_id']);

            $vaccination->update([
                'is_completed' => true,
                'lot_id' => $entry['lot_id'],
                'prov_id' => $entry['prov_id'],
                'notes' => $entry['notes'] ?? null,
                //'location' => $request['location'] ?? null,
            ]);
            $updated[] = $vaccination;

        }

        return response()->json([
            'message' => 'Vaccination(s) updated successfully',
            'data' => $updated
        ], 200);
    }


    public function getChildVaccinations($child_id)
    {
        $vaccination = Vaccinations::with(['vaccine', 'provider.organization'])->where('child_id', $child_id)->get();
        return response()->json($vaccination);
    }

    public function getProviderVaccinations($providerId)
    {
        $vaccinations = Vaccinations::with(['vaccine', 'child', 'provider.organization'])->where('prov_id', $providerId)->get();

        return response()->json($vaccinations);
    }


}
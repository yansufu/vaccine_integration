<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Vaccinations;
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
        $validation = $request->validate([
            'vaccine_id' => 'required|exists:vaccine,id',
            'prov_id' => 'required|exists:provider,id',
            'lot_id' => 'required|string',
            'location' => 'nullable|string', 
            'note' => 'nullable|string',
        ]);

        $vaccination = Vaccinations::where('child_id', $child_id)
            ->where('vaccine_id', $validation['vaccine_id'])
            ->firstOrFail();

        $provider = Provider::findOrFail($validation['prov_id']);

        $vaccination->update([
            'is_completed' => true,
            'lot_id' => $validation['lot_id'],
            'prov_id' => $validation['prov_id'],
            'location' => $validation['location'] ?? null,
            'note' => $validation['note'] ?? null,
        ]);

        return response()->json($vaccination, 200);
    }


    public function getChildVaccinations($child_id)
    {
        $vaccination = Vaccinations::with(['vaccine', 'provider.organization'])->where('child_id', $child_id)->get();
        return response()->json($vaccination);
    }


}
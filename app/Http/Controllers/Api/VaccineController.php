<?php

namespace App\Http\Controllers\Api;

use App\Models\Vaccines;
use App\Models\Children;
use App\Models\Vaccinations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\VaccineResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VaccineController extends Controller
{
    public function index(){
        $vaccine = Vaccines::get();
        if($vaccine->count() > 0)
        {
            return VaccineResource::collection($vaccine);
        }
        else
        {
            return response()->json(['message' => 'No Data'], 200);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'period' => 'required|integer|max:10'
        ]);

        if($validator->fails()){
            return response()->json(
            ['message' => 'invalid data format'], 422);
        };

        $vaccine = Vaccines::create([
            'name' => $request->name,
            'category' => $request->category,
            'period' => $request->period
        ]);

        return response()->json(
            ['message' => 'data created successfully',
            'Data' => new VaccineResource($vaccine)], 200
        );
    }

    public function show(Vaccines $vaccine){
        return new VaccineResource($vaccine);
    }

    public function destroy(Vaccines $vaccine){
        $vaccine->delete();
        return response()->json(['message' => 'delete vaccine'], 200);
    }

    public function getVaccineByCat($cat_id)
    {
        $vaccine = Vaccines::where('cat_id', $cat_id)->get();

        if ($vaccine->isEmpty()) {
            return response()->json(['message' => 'No vaccine found'], 200);
        }

        return response()->json([
            'message' => 'vaccine fetched successfully',
            'data' => VaccineResource::collection($vaccine)
        ], 200);
    }

    public function getRecommendedVaccinePeriod($child_id, $category)
    {
        // 1. Get child's date of birth and calculate age in full months
        $child = Children::findOrFail($child_id);
        $dob = Carbon::parse($child->dob);
        $ageInMonths = $dob->diffInMonths(Carbon::now());

        // 2. Get vaccines by category, ordered by period
        $vaccines = Vaccines::where('cat_id', $category)
            ->orderBy('period')
            ->get();

        if ($vaccines->isEmpty()) {
            return response()->json(['message' => 'No vaccines found for this category.'], 404);
        }

        // 3. Fetch completed vaccinations for this child
        $completedVaccineIds = Vaccinations::where('child_id', $child_id)
            ->where('is_completed', true)
            ->whereHas('vaccine', function ($query) use ($category) {
                $query->where('cat_id', $category);
            })
            ->pluck('vaccine_id')
            ->toArray();

        // 4. Try to find the lowest uncompleted period ≤ age
        foreach ($vaccines as $vaccine) {
            if ($vaccine->period <= $ageInMonths && !in_array($vaccine->id, $completedVaccineIds)) {
                return response()->json(['id' => $vaccine->id, 'period' => $vaccine->period]);
            }
        }

        // 5. If all ≤ age vaccines are completed, find the next period > age
        foreach ($vaccines as $vaccine) {
            if ($vaccine->period > $ageInMonths && !in_array($vaccine->id, $completedVaccineIds)) {
                return response()->json(['vaccine_id' => $vaccine->id, 'period' => $vaccine->period]);
            }
        }

        // 6. If all are completed
        return response()->json(['message' => 'All vaccines in this category are completed.'], 404);
    }

}

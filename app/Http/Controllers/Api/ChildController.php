<?php
namespace App\Http\Controllers\Api;

use App\Models\Children;
use App\Models\Vaccinations;
use App\Models\Vaccines;
use App\Models\Organizations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ChildResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChildController extends Controller
{
    public function index(){
        $child = Children::get();
        if($child->count() > 0)
        {
            return ChildResource::collection($child);
        }
        else
        {
            return response()->json(['message' => 'No Data'], 200);
        }
    }

    public function store(Request $request, $parent_id){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'NIK' => 'string|max:16',
            'weight' => 'numeric',
            'height' => 'numeric',
            'medical_history' => 'string|max:500',
            'allergy' => 'string|max:500',
            'org_id' => 'integer|max:500',
        ]);

        if($validator->fails()){
            return response()->json(
            ['message' => 'invalid data format'], 422);
        };

        $child = Children::create([
            'parent_id' => $parent_id,
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'NIK' => $request->NIK,
            'weight' => $request->weight,
            'height' => $request->height,
            'medical_history' => $request->medical_history,
            'allergy' => $request->allergy,
            'org_id' => $request->org_id,
        ]);

        // Populate vaccination table for each children creation
        $vaccines = Vaccines::all();

        foreach ($vaccines as $vaccine) {
            Vaccinations::create([
                'child_id' => $child->childID,
                'vaccine_id' => $vaccine->id,
                //will be added after scan
                'status' => null,
                'lot_id' => null,
                'prov_id' => null,
            ]);
        }

        return response()->json(
            ['message' => 'data created successfully',
            'Data' => new ChildResource($child)], 200
        );

        return response()->json($child->load('vaccination'), 201);        
    }

    public function show($child_id)
    {
        $child = Children::with('organization')->find($child_id);

        if (!$child) {
            return response()->json(['error' => 'Child not found'], 404);
        }

        return response()->json($child);
    }

    public function update(Request $request, Children $child){
        $validator = Validator::make($request->all(),[
            'name' => 'string|max:255',
            'date_of_birth' => 'date',
            'NIK' => 'string|max:255',
            'gender' => 'string|max:255',
            'weight' => 'numeric',
            'height' => 'numeric',
            'medical_history' => 'string|max:500',
            'allergy' => 'string|max:500',
            'org_id' => 'integer|max:500',
        ]);

        if($validator->fails()){
            return response()->json(
            ['message' => 'invalid data format'], 422);
        };

        $child->update($request->only([
            'name',
            'date_of_birth',
            'NIK',
            'gender',
            'weight',
            'height',
            'medical_history',
            'allergy',
            'org_id'
        ]));    

        return response()->json(new ChildResource($child), 200);

    }

    public function destroy(Children $child){
        $child->delete();
        return response()->json(['message' => 'delete child'], 200);
    }

    public function getByParent($parent_id)
    {
        $children = Children::where('parent_id', $parent_id)->get();

        if ($children->isEmpty()) {
            return response()->json(['message' => 'No children found for this parent'], 200);
        }

        return response()->json([
            'message' => 'Children fetched successfully',
            'data' => ChildResource::collection($children)
        ], 200);
    }

    public function getVaccinePeriod($child_id){
        $child = Children::findOrFail($child_id);
        $dob = new \Carbon\Carbon($child->date_of_birth);
        $now = now();
        $ageInMonths  = $dob->diffInMonths($now);
        $ageInDays  = $dob->diffInDays($now) % 30 ; //because we dont wanna get the child from birth, we just wanna know the remaining days from 30 days

        $ageString = "$ageInMonths months, $ageInDays days";

        $vaccineThisMonth = Vaccines::where('period', $ageInMonths)->get();

        $vaccinationStatus = [];
        foreach ($vaccineThisMonth as $vaccine){
            $vaccination = $child
            ->vaccination() //table name vaccination
            ->where ("vaccine_id", $vaccine->id)
            ->first();

            $status = false;
            if($vaccination){
                $status = $vaccination->is_completed;
            }

            $vaccinationStatus[] = [
                'name' => $vaccine->name,
                'status' => $status,
            ];
            
        }
        return response()->json($vaccinationStatus, 200);

    }

    public function getVaccineNextPeriod($child_id){
        $child = Children::findOrFail($child_id);
        $dob = new \Carbon\Carbon($child->date_of_birth);
        $now = now();
        $ageInMonths  = ($dob->diffInMonths($now)) + 1;

        $vaccineThisMonth = Vaccines::where('period', $ageInMonths)->get();

        $vaccinationStatus = [];
        foreach ($vaccineThisMonth as $vaccine){
            $vaccination = $child
            ->vaccination() //table name vaccination
            ->where ("vaccine_id", $vaccine->id)
            ->first();

            $status = false;
            if($vaccination){
                $status = $vaccination->is_completed;
            }

            $vaccinationStatus[] = [
                'name' => $vaccine->name,
                'status' => $status,
            ];
            
        }
        return response()->json($vaccinationStatus, 200);

    }
    

}
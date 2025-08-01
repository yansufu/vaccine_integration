<?php
namespace App\Http\Controllers\Api;

use App\Models\Organizations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OrganizationResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OrganizationController extends Controller
{
    public function index(){
        $organization = Organizations::get();
        if($organization->count() > 0)
        {
            return OrganizationResource::collection($organization);
        }
        else
        {
            return response()->json(['message' => 'No Data'], 200);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'org_name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(
            ['message' => 'invalid data format'], 422);
        };

        $organization = Organizations::create([
            'org_name' => $request->org_name,
            'alamat' => $request->alamat,
        ]);

        return response()->json(
            ['message' => 'data created successfully',
            'Data' => new OrganizationResource($organization)], 200
        );
    }

    public function show(Organizations $organization){
        return new OrganizationResource($organization);
    }

    public function destroy(Organizations $organization){
        $organization->delete();
        return response()->json(['message' => 'delete organization'], 200);
    }
}
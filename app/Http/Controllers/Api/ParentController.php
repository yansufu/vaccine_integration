<?php
namespace App\Http\Controllers\Api;

use App\Models\Parents;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ParentResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    
    public function index(){
        $parent = Parents::get();
        if($parent->count() > 0)
        {
            return ParentResource::collection($parent);
        }
        else
        {
            return response()->json(['message' => 'No Data'], 200);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'NIK' => 'required|string|max:255|unique:parent,NIK',
            'phone' => 'required|digits_between:10,15',
            'password' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(
            ['message' => 'invalid data format'], 422);
        };

        $parent = Parents::create([
            'name' => $request->name,
            'NIK' => $request->NIK,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(
            ['message' => 'data created successfully',
            'Data' => new ParentResource($parent)], 200
        );
    }

    public function show(Parents $parent){
        return new ParentResource($parent);
    }

    public function update(Request $request, Parents $parent){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(
            ['message' => 'invalid data format'], 422);
        };

        $parent->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(
            ['message' => 'data updated successfully',
            'Data' => new ParentResource($parent)], 200
        );

    }

    public function destroy(Parents $parent){
        $parent->delete();
        return response()->json(['message' => 'delete parent'], 200);
    }
}
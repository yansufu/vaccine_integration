<?php

namespace App\Http\Controllers\Api;

use App\Models\Providers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProviderResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProviderController extends Controller
{
    public function index(){
        $provider = Providers::get();
        if($provider->count() > 0)
        {
            return ProviderResource::collection($provider);
        }
        else
        {
            return response()->json(['message' => 'No Data'], 200);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'org_id' => 'required|integer|max:255',
            'email' => 'required|email|unique:provider,email',
            'password' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(
            ['message' => 'invalid data format'], 422);
        };

        $provider = Providers::create([
            'name' => $request->name,
            'org_id' => $request->org_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(
            ['message' => 'data created successfully',
            'Data' => new ProviderResource($provider)], 200
        );
    }

    public function show($prov_id)
    {
        $prov = Providers::with('organization')->find($prov_id);

        if (!$prov) {
            return response()->json(['error' => 'Organization not found'], 404);
        }

        return response()->json($prov);
    }


    public function update(Request $request, Providers $provider){
        $validator = Validator::make($request->all(),[
            'name' => 'string|max:255',
            'org_id' => 'integer|max:255',
        ]);

        if($validator->fails()){
            return response()->json(
            ['message' => 'invalid data format'], 422);
        };

        $provider->update([
            'name' => $request->name,
            'org_id' => $request->org_id,
        ]);

        return response()->json(
            ['message' => 'data updated successfully',
            'Data' => new ProviderResource($provider)], 200
        );

    }

    public function destroy(Providers $provider){
        $provider->delete();
        return response()->json(['message' => 'delete provider'], 200);
    }
}
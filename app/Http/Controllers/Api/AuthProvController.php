<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Providers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class AuthProvController extends Controller
{
    public function loginProv(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $provider = Providers::where('email', $request->email)->first();

            if (!$provider || !Hash::check($request->password, $provider->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            return response()->json([
                'message' => 'Login successful',
                'provider_id' => $provider->id,
            ], 200);
        }
}

<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Parents;
use App\Models\Children;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $parent = Parents::where('email', $request->email)->first();

            if (!$parent || !Hash::check($request->password, $parent->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $firstChild = Children::where('parent_id', $parent->id)->orderBy('childID')->first();

            return response()->json([
                'message' => 'Login successful',
                'parent_id' => $parent->id,
                'child_id' => $firstChild ? $firstChild->childID : null
            ], 200);
        }

}

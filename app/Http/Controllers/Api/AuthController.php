<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Parents;
use App\Models\ParentAuth;
use App\Models\Children;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
        {
            $request->validate([
                'NIK' => 'required|string',
                'password' => 'required',
            ]);

            $parent = Parents::where('NIK', $request->NIK)->first();

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

        public function showForgotPasswordForm()
    {
        return view('auth.passwords.NIK');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NIK' => 'required|NIK|exists:parent,NIK',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Unregistered NIK address. Please register first'], 422);
        }

        $status = Password::broker('parents')->sendResetLink(
            $request->only('NIK')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent to your NIK.'], 200);
        } else {
            return response()->json(['message' => __($status)], 500);
        }
    }


    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'NIK' => $request->NIK]);
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'NIK' => 'required|NIK',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('NIK', 'password', 'password_confirmation', 'token'),
            function ($parent, $password) {
                $parent->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($parent));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['NIK' => [__($status)]]);
    }

}

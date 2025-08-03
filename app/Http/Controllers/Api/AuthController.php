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

        public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:parent,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid email address.'], 422);
        }

        $status = Password::broker('parents')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent to your email.'], 200);
        } else {
            return response()->json(['message' => __($status)], 500);
        }
    }


    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($parent, $password) {
                $parent->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($parent));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

}

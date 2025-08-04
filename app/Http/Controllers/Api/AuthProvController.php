<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Providers;
use App\Models\ProviderAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


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

        public function sendResetLinkEmailProv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:provider,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Unregistered email address. Please register first'], 422);
        }

        $status = Password::broker('provider_user')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset link sent to your email.'], 200);
        } else {
            return response()->json(['message' => __($status)], 500);
        }
    }


    public function showResetFormProv(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }
    
    public function resetPasswordProv(Request $request)
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

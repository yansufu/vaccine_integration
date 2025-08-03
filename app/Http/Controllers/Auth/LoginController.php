<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('check.results');
    }

    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); 
            return redirect()->intended('/check-health-status')->with("success", "Login success"); 
        }
        return redirect(route('login'))->with("error", "Login failed");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Send reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Return with success or error message
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
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
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }


    public function register(Request $request)
    {        
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'NIK'=> 'required|string|max:16',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'NIK' => $request->NIK,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'NIK' => 'required|string|max:255|unique:users,NIK',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json(
            ['message' => 'invalid data format'], 422);
        };

        $user = User::create([
            'name' => $request->name,
            'NIK' => $request->NIK,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->intended('/check-health-status');
    }
}

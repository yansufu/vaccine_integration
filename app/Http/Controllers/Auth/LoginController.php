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
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
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

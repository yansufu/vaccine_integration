<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class forgotPasswordController extends Controller
{
    function forgetPassword(){
        return view("resetPassword");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class registerController extends Controller
{
    // register function
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/',
            ],
        ], ['password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one symbol.',]);

        
        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->email_verified_at = now();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // return to login page
        return redirect('/login')->with('success', 'You have successfully registered');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Registration method
    public function register(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'username' => 'required|string|max:255|unique:registers,username',
            'email' => 'required|string|email|max:255|unique:registers,email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        // Create a new user and hash the password
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Automatically log the user in after registration
        Auth::login($user);

        // Redirect to the home page or dashboard after successful registration
        return redirect()->route('home');
    }

    // Login method
    public function login(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->route('home'); // Redirect after successful login
        }

        // If login fails, redirect back with an error message
        return back()->withErrors(['username' => 'Invalid credentials']);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomRegisterController extends Controller
{
    public function register(Request $request)
{
    // Flash to keep form shown
    $request->session()->flash('form_type', 'registers');

    // Validate inputs
    $request->validate([
        'username' => 'required|unique:registers,username',
        'email' => 'required|email|unique:registers,email|regex:/@gmail\.com$/',  // Only Gmail validation
        'password' => 'required|confirmed|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/', // Strong password validation
    ]);

    // Create user
    User::create([
        'username' => $request->username,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect()->route('login')->with('success', 'Account created. Please login.');
    return back()->withErrors($validator)->withInput()->with('form', 'register');
}

}


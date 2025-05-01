<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register'); 
    }

    public function register(Request $request)
    {
        // Flash to keep form shown
        $request->session()->flash('form_type', 'registers');
    
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:registers,username',
            'email' => 'required|email|unique:registers,email|regex:/@gmail\.com$/',  // Only Gmail validation
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',                  // At least one uppercase
                'regex:/[a-z]/',                  // At least one lowercase
                'regex:/[0-9]/',                  // At least one digit
                'regex:/[!@#$%^&*(),.?":{}|<>]/'  // At least one special character
            ],
            'firstname' => 'required|string|max:255', // Validation for firstname
            'lastname'  => 'required|string|max:255', // Validation for lastname
        ]);
    
        // If validation fails, return back with errors and old input
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('form', 'register');
        }
    
        // Create user if validation passes
        User::create([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        // Flash username and password to the session
        $request->session()->flash('username', $request->username);
        $request->session()->flash('password', $request->password);

        // Redirect to login with success message
        return redirect()->route('register.form')->with('success', 'Account created successfully!')->withInput([]);
    }
    
}


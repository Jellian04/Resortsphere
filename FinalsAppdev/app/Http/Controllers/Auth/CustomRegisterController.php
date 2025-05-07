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
        $request->session()->flash('form_type', 'registers');
    
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:registers,username',
            'email' => 'required|email|unique:registers,email|regex:/@gmail\.com$/',  // Only Gmail validation
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',                  
                'regex:/[a-z]/',                  
                'regex:/[0-9]/',                  
                'regex:/[!@#$%^&*(),.?":{}|<>]/'  
            ],
            'firstname' => 'required|string|max:255', 
            'lastname'  => 'required|string|max:255', 
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('form', 'register');
        }
    
        User::create([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        $request->session()->flash('username', $request->username);
        $request->session()->flash('password', $request->password);
        return redirect()->route('register.form')->with('success', 'Account created successfully!')->withInput([]);
    }
}


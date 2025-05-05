<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResortOwner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
        {
            $request->session()->flash('form_type', 'login');
        
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',  
            ]);
        
            $adminUsername = 'Admin';
            $adminPassword = 'Admin246_>@';

            Log::info('Admin check started with:', [
                'submitted_username' => $request->username,
                'submitted_password' => $request->password,
            ]);

            if (strtolower($request->username) === strtolower($adminUsername) && $request->password === $adminPassword) {
                Log::info('Admin login successful.');
                return redirect()->route('admin.dashboard');
        }

            $owner = ResortOwner::where('username', $request->username)->first();
    
        if (!$owner) {
            Log::info('Username not found: ' . $request->username);
            return redirect()->back()->withErrors([
                'username' => 'Username not found.',
            ])->withInput()->with('form', 'login');
        }
    
        if (!Hash::check($request->password, $owner->password)) {
            Log::info('Incorrect password for username: ' . $request->username);
            return redirect()->back()->withErrors([
                'password' => 'Incorrect password.',
            ])->withInput()->with('form', 'login');
        }
    
        Auth::login($owner);
        Log::info('User logged in:', ['user' => Auth::user()]);
        return redirect()->route('resort.owner');
    }
    
    public function username()
    {
        return 'username';
    }
}

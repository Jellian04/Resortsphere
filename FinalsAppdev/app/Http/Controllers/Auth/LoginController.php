<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResortOwner; // model connected to 'registers' table
use Illuminate\Support\Facades\Hash;  // Import the Hash facade
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->session()->flash('form_type', 'login');
    
        // Validate input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        // Admin credentials (hardcoded)
        $adminUsername = 'Admin';
        $adminPassword = 'Admin246';
    
        if (
            $request->username === $adminUsername &&
            $request->password === $adminPassword
        ) {
            return redirect()->route('admin.dashboard');
        }
    
        // Resort owner login via database
        $owner = ResortOwner::where('username', $request->username)->first();
    
        if (!$owner) {
            // Username not found
            return redirect()->back()->withErrors([
                'username' => 'Username not found.',
            ])->withInput()->with('form', 'login');
        }
    
        if (!Hash::check($request->password, $owner->password)) {
            // Password incorrect
            return redirect()->back()->withErrors([
                'password' => 'Incorrect password.',
            ])->withInput()->with('form', 'login');
        }
    
        Auth::login($owner);
    
        // Now you can log the user details
        Log::info('User in:', ['user' => Auth::user()]);
    
        return redirect()->route('resort.owner');
    }
    


    public function username()
    {
        return 'username';
    }
}

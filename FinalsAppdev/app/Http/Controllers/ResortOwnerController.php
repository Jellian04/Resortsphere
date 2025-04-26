<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingOwner;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResortOwnerController extends Controller
{
    // Show the registration form
    public function create()
    {
        return view('register-resort');
    }

    // Store the form data
    public function store(Request $request)
    {
        // Check if the email exists in either table
        $emailExists = PendingOwner::where('email', $request->email)->exists() ||
                       Owner::where('email', $request->email)->exists();
    
        $usernameExists = PendingOwner::where('username', $request->username)->exists() ||
                          Owner::where('username', $request->username)->exists();
    
        if ($emailExists || $usernameExists) {
            return back()->with('error', 'You have already registered a resort. Only one registration is allowed.');
        }
    
        // Validate input
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'zipcode' => 'nullable|string|max:20',
            'resortname' => 'nullable|string|max:255',
            'resorts_address' => 'nullable|string|max:255',
            'type_of_accommodation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'resort_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('resort_img')) {
            try {
                $imagePath = $request->file('resort_img')->store('images/resorts', 'public');
                \Log::info('File uploaded successfully:', ['path' => $imagePath]);
            } catch (\Exception $e) {
                \Log::error('File upload failed:', ['error' => $e->getMessage()]);
                return back()->with('error', 'There was an error uploading your image. Please try again.');
            }
        } else {
            \Log::warning('No file uploaded.');
        }
    
        // Create pending owner
        PendingOwner::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->has('password') ? Hash::make($request->password) : null,
            'zipcode' => $request->zipcode,
            'resortname' => $request->resortname,
            'resorts_address' => $request->resorts_address,
            'type_of_accommodation' => $request->type_of_accommodation,
            'description' => $request->description,
            'resort_img' => $imagePath,
            'status' => 'pending',
        ]);
    
        // Redirect to the dashboard with a success message
        return redirect()->route('resort.owner')->with('success', 'Registration submitted. Waiting for admin approval.');
    }

    // Show registration form or dashboard based on user registration status
    public function showRegistrationForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $user = Auth::user();

        // Check if the user has already registered or is in pending approval
        $alreadyRegistered = PendingOwner::where('email', $user->email)->exists() ||
                            Owner::where('email', $user->email)->exists();

        // Get the registration status for the user
        $status = PendingOwner::where('email', $user->email)->value('status') ?? 
                Owner::where('email', $user->email)->value('status') ?? 
                'not_registered';  // If no status found, assume 'not_registered'

        // Return the view with the status and registration status flag
        return view('resortowner', compact('status', 'alreadyRegistered'));
    }

    // Admin approves owner registration
    public function approveOwner($ownerId)
    {
        $pendingOwner = PendingOwner::find($ownerId);

        if ($pendingOwner) {
            Owner::create([
                'firstname' => $pendingOwner->firstname,
                'lastname' => $pendingOwner->lastname,
                'email' => $pendingOwner->email,
                'username' => $pendingOwner->username,
                'zipcode' => $pendingOwner->zipcode,
                'resortname' => $pendingOwner->resortname,
                'resorts_address' => $pendingOwner->resorts_address,
                'type_of_accommodation' => $pendingOwner->type_of_accommodation,
                'description' => $pendingOwner->description,
                'resort_img' => $pendingOwner->resort_img,
                'status' => 'approved',
            ]);

            $pendingOwner->delete();

            return redirect()->back()->with('approval_message', 'Registration approved successfully.');
        }

        return redirect()->back()->with('error', 'Owner not found.');
    }

    // Dashboard for resort owners to view registration status
    public function resortDashboard()
    {
        $user = Auth::user();

        // Check if the user is in pending_owners
        $pending = PendingOwner::where('user_id', $user->id)->first();

        if ($pending) {
            $status = 'pending';
        } else {
            // Check if the user is already in the approved owners table
            $owner = Owner::where('user_id', $user->id)->first();

            if ($owner) {
                $status = 'approved';
            } else {
                $status = 'not_registered';
            }
        }

        return view('resort-owner.dashboard', [
            'status' => $status,
            'alreadyRegistered' => $status !== 'not_registered'
        ]);
    }
    
    // Check registration status and return the appropriate view
    public function index()
    {
        $user = Auth::user();
    
        // Get the pending or approved owner record
        $pendingOwner = PendingOwner::where('email', $user->email)->orWhere('username', $user->username)->first();
        $owner = Owner::where('email', $user->email)->orWhere('username', $user->username)->first();
    
        // Determine status and data
        if ($owner) {
            $status = 'approved';
            $ownerData = $owner;
        } elseif ($pendingOwner) {
            $status = 'pending';
            $ownerData = $pendingOwner;
        } else {
            $status = 'not_registered';
            $ownerData = null;
        }
    
        $alreadyRegistered = $status !== 'not_registered';
    
        return view('resortowner', compact('status', 'alreadyRegistered', 'ownerData'));
    }
    
}   
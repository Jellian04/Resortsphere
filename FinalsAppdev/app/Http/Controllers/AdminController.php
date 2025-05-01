<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingOwner;
use App\Models\Owner;
use App\Models\User; 
class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingOwners = PendingOwner::all();  
        $totalResorts = Owner::count();         // Count all resorts
        $totalOwners = Owner::distinct('email')->count();  // Count unique owners by email
        $totalUsers = User::count();            // Count registered users
        $users = User::all();                   // Get all users
        $owners = PendingOwner::where('status', 'pending')->get();

        // Fetch all owners and pass to the view
        // $owners = Owner::all(); // Make sure you're querying the Owner model
    
        // Now pass all the data to the view
        return view('admindashboard', compact(
            'pendingOwners',
            'totalResorts',
            'totalOwners',
            'totalUsers',
            'users',
            'owners'  // Ensure 'owners' is passed correctly
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $pendingOwner = PendingOwner::find($id);
        
        if (!$pendingOwner) {
            return redirect()->back()->with('error', 'Pending owner not found.');
        }
    
        $status = $request->input('status');
    
        // Handle the 'approved' status
        if ($status === 'approved') {
            // Check if the email already exists in the owners table
            $existingOwner = Owner::where('email', $pendingOwner->email)->first();
    
            if ($existingOwner) {
                // If the email exists, only update the resort-related fields
                $existingOwner->update([
                    'zipcode' => $pendingOwner->zipcode, 
                    'resortname' => $pendingOwner->resortname,
                    'resorts_address' => $pendingOwner->resorts_address,
                    'type_of_accommodation' => $pendingOwner->type_of_accommodation,
                    'description' => $pendingOwner->description,
                    'resort_img' => $pendingOwner->resort_img,
                    'status' => 'approved',
                    'user_id' => $pendingOwner->user_id, // Ensure correct user_id
                ]);
            } else {
                // If the email does not exist, create a new entry in the owners table
                $owner = Owner::create([
                    'firstname' => $pendingOwner->firstname,
                    'lastname' => $pendingOwner->lastname,
                    'email' => $pendingOwner->email,
                    'username' => $pendingOwner->username,
                    'password' => $pendingOwner->password,
                    'zipcode' => $pendingOwner->zipcode,
                    'resortname' => $pendingOwner->resortname,
                    'resorts_address' => $pendingOwner->resorts_address,
                    'type_of_accommodation' => $pendingOwner->type_of_accommodation,
                    'description' => $pendingOwner->description,
                    'resort_img' => $pendingOwner->resort_img,
                    'status' => 'approved',
                    'user_id' => $pendingOwner->user_id, // Correct user_id passed here
                ]);
            }
    
            // Optionally, update the status of the pending owner to 'approved' after moving the data
            $pendingOwner->status = 'approved';
            $pendingOwner->save();  // Save the change in PendingOwner
    
            // After approving, delete the pending owner record
            $pendingOwner->delete();
    
            return redirect()->back()->with('approval_message', 'Registration approved successfully.');
        }
    
        // Handle other statuses like 'rejected' or 'undo' as before...
    }
    
    public function listOwners()
    {
        // Fetch all owners
        $owners = Owner::all();
    
        // Get the total number of resorts (assuming you have a Resort model)
        $totalResorts = Owner::count();
    
        // Get other necessary variables
        $totalOwners = Owner::count();
        $totalUsers = User::count();
    
        // Pass the variables to the view
        return view('adminowner', compact('owners', 'totalResorts', 'totalOwners', 'totalUsers'));
    }
    
    public function deleteOwner($id)
    {
        // Find the owner by ID
        $owner = Owner::findOrFail($id);

        // Delete the owner
        $owner->delete();

        // Redirect back with a success message
        return redirect()->route('adminowners')->with('success', 'Owner deleted successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function showUsers()
    {
        $users = User::all();
        $totalUsers = $users->count();
        $totalResorts = Owner::count();  // Get the total number of resorts
        $totalOwners = Owner::distinct('email')->count();  // Get the total number of unique owners by email
        
        return view('adminuser', compact('users', 'totalUsers', 'totalResorts', 'totalOwners'));  // Pass totalOwners to the view
    }
    
}   

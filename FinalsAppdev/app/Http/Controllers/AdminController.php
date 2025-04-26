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
        $pendingOwners = PendingOwner::all();                      // For pending approvals
        $totalResorts = Owner::count();                            // Count all resorts
        $totalOwners = Owner::distinct('email')->count();          // Count unique owners by email
        $totalUsers = User::count();                               // Count registered users
        $users = User::all(); // Add this line to get all registered users
        return view('admindashboard', compact(
            'pendingOwners',
            'totalResorts',
            'totalOwners',
            'totalUsers',
            'users'
        ));
        
    }

    public function updateStatus(Request $request, $id)
    {
        $pendingOwner = PendingOwner::find($id);

        if (!$pendingOwner) {
            return redirect()->back()->with('error', 'Pending owner not found.');
        }

        $status = $request->input('status');

        if ($status === 'approved') {
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
        } else {
            $pendingOwner->status = $status;
            $pendingOwner->save();

            return redirect()->back()->with('success', 'Status updated successfully.');
        }
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

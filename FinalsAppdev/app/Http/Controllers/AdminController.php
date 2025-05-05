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
        
        $pendingOwners = PendingOwner::where('status', 'pending')->get();
        $approvedOwners = Owner::all();
        $rejectedOwners = PendingOwner::where('status', 'rejected')->get(); 
        $totalResorts = Owner::count();
        $totalOwners = Owner::distinct('email')->count();
        $totalUsers = User::count();
        $rejectedMessage = session('rejected_message'); 
        $users = User::all();
        
        return view('admindashboard', [
            'approvedOwners' => $approvedOwners,
            'pendingOwners' => $pendingOwners,
            'rejectedOwners' => $rejectedOwners,
            'totalResorts' => $totalResorts,
            'totalOwners' => $totalOwners,
            'totalUsers' => $totalUsers,
            'users' => $users,
        ]);
        
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status');
    
        if ($status == 'approved') {
            // Approve: move from pending_owners to owners
            $pending = PendingOwner::findOrFail($id);
    
            $owner = new Owner();
            $owner->firstname = $pending->firstname;
            $owner->lastname = $pending->lastname;
            $owner->email = $pending->email;
            $owner->username = $pending->username;
            $owner->zipcode = $pending->zipcode;
            $owner->resortname = $pending->resortname;
            $owner->type_of_accommodation = $pending->type_of_accommodation;
            $owner->resort_img = $pending->resort_img;
            $owner->status = 'approved';
            $owner->save();
    
            // Delete from pending_owners
            $pending->delete();
    
            return redirect()->back()->with('success', 'Owner approved and moved to owners table.');
        }
    
        if ($status == 'undo') {
            // Undo: move from owners back to pending_owners
            $owner = Owner::findOrFail($id);
    
            $pending = new PendingOwner();
            $pending->firstname = $owner->firstname;
            $pending->lastname = $owner->lastname;
            $pending->email = $owner->email;
            $pending->username = $owner->username;
            $pending->zipcode = $owner->zipcode;
            $pending->resortname = $owner->resortname;
            $pending->type_of_accommodation = $owner->type_of_accommodation;
            $pending->resort_img = $owner->resort_img;
            $pending->status = 'pending';
            $pending->save();
    
            // Delete from owners
            $owner->delete();
    
            return redirect()->back()->with('undo', 'Owner moved back to pending.');
        }
    
        elseif ($status == 'rejected') {
            $pending = PendingOwner::findOrFail($id);
            $pending->status = 'rejected'; // Just change the status
            $pending->save();
        
            return redirect()->back()->with('rejected', 'Owner has been rejected.');
        }
    
        return redirect()->back()->with('error', 'Invalid status selected.');
    }
    
    public function listOwners()
    {
        $pendingOwners = PendingOwner::where('status', 'pending')->get();
        $rejectedOwners = PendingOwner::where('status', 'rejected')->get();
        
        // Get all approved owners
        $approvedOwners = Owner::all();
        
        // Calculate totals
        $totalResorts = Owner::count(); // Count of resorts
        $totalOwners = Owner::count();  // Count of approved owners
        $totalUsers = User::count();    // Count of total users
        
        return view('admindashboard', compact(
            'approvedOwners', 'pendingOwners', 'rejectedOwners',
            'totalResorts', 'totalOwners', 'totalUsers', 'users'
        ));
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

    public function undoApproval($id)
    {
        $owner = Owner::findOrFail($id);

        // Insert the data back to the pending_owners table
        DB::table('pending_owners')->insert([
            'firstname' => $owner->firstname,
            'lastname' => $owner->lastname,
            'email' => $owner->email,
            'username' => $owner->username,
            'zipcode' => $owner->zipcode,
            'resortname' => $owner->resortname,
            'type_of_accommodation' => $owner->type_of_accommodation,
            'resort_img' => $owner->resort_img,
            'status' => 'pending', // Status set to pending
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Delete the approved owner from the 'owners' table
        $owner->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Approval undone, owner moved back to pending.');
    }


    public function undoReject($id)
    {
        // Find the pending owner by ID
        $pendingOwner = PendingOwner::find($id);
    
        if ($pendingOwner) {
            // Change status to 'pending' or update as necessary
            $pendingOwner->status = 'pending';
    
            // Save the owner back to the pending_owners table (if necessary)
            // Or simply update the status without moving back
            $pendingOwner->save();
        }
    
        return redirect()->route('admin.dashboard')->with('success', 'Rejection undone, owner is now in pending list.');
    }
    
    
    public function deleteRejectedOwner($id)
    {
        // Find and delete the rejected owner from the rejected_owners table
        $rejectedOwner = PendingOwner::find($id);
    
        if ($rejectedOwner) {
            // Also delete from pending_owners table if it exists
            PendingOwner::where('id', $id)->delete();
    
            // Delete the rejected owner
            $rejectedOwner->delete();
        }
    
        return redirect()->route('admin.dashboard')->with('success', 'Rejected owner deleted permanently.');
    }
    
    
    
}

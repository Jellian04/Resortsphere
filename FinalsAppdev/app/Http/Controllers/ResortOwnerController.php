<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingOwner;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResortOwnerController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:pending_owners,email',
            'username' => 'required|string|max:255|unique:pending_owners,username',
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
                $imagePath = $request->file('resort_img')->store('images/', 'public');
                \Log::info('File uploaded successfully:', ['path' => $imagePath]);
            } catch (\Exception $e) {
                \Log::error('File upload failed:', ['error' => $e->getMessage()]);
                return back()->with('error', 'There was an error uploading your image. Please try again.');
            }
        }
    
        // Check if an entry already exists for this email
        $existingOwner = PendingOwner::where('email', $request->email)->first();
    
        if ($existingOwner) {
            // Concatenate new resort-related data with commas
            $existingOwner->update([
                'zipcode' => $this->concatField($existingOwner->zipcode, $request->zipcode),
                'resortname' => $this->concatField($existingOwner->resortname, $request->resortname),
                'resorts_address' => $this->concatField($existingOwner->resorts_address, $request->resorts_address),
                'type_of_accommodation' => $this->concatField($existingOwner->type_of_accommodation, $request->type_of_accommodation),
                'description' => $this->concatField($existingOwner->description, $request->description),
                'resort_img' => $request->hasFile('resort_img')
                    ? $this->concatField($existingOwner->resort_img, $imagePath)
                    : $existingOwner->resort_img,
                'status' => 'pending',
            ]);
    
            return redirect()->route('resort.owner')
                ->with('success', 'Your resort information was added and is awaiting admin approval.');
        }
    
        // Create new pending owner entry
        PendingOwner::create([
            'user_id' => Auth::id(),
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->has('password') ? Hash::make($request->password) : null, // Only hash password if provided
            'zipcode' => $request->zipcode,
            'resortname' => $request->resortname,
            'resorts_address' => $request->resorts_address,
            'type_of_accommodation' => $request->type_of_accommodation,
            'description' => $request->description,
            'resort_img' => $imagePath,
            'status' => 'pending',
        ]);
    
        return redirect()->route('resort.owner')->with('success', 'Registration submitted. Waiting for admin approval.');
    }
    
    private function concatField($existing, $new)
    {
        return $new ? ($existing ? $existing . ', ' . $new : $new) : $existing;
    }
    
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
    
    public function index()
    {
        $user = Auth::user();
    
        // Filter resorts for the logged-in user
        $pendingResorts = PendingOwner::where('email', $user->email)
                                      ->orWhere('username', $user->username)
                                      ->get();
    
        $approvedResorts = Owner::where('email', $user->email)
                                ->orWhere('username', $user->username)
                                ->get();
    
        $pendingOwner = $pendingResorts->first();
        $owner = $approvedResorts->first();
    
        if ($owner) {
            $status = 'approved';
            $statusMessage = 'Your resort has been approved! You can re-register.';
        } elseif ($pendingOwner && $pendingOwner->status == 'pending') {
            $status = 'pending';
            $statusMessage = 'Your request is still pending. You can re-submit your registration if necessary.';
        } elseif ($pendingOwner && $pendingOwner->status == 'rejected') {
            $status = 'rejected';
            $rejectionReason = 'Your resort did not meet the required standards or the submitted information was incomplete.';
            $statusMessage = "Your request was rejected. Reason: $rejectionReason. You can re-submit your registration if necessary.";        } else {
            $status = 'not_registered';
            $statusMessage = 'You have not registered yet. Please fill out the registration form.';
        }
        
    
        $alreadyRegistered = $status !== 'not_registered';
    
        return view('resortowner', compact(
            'pendingResorts',
            'approvedResorts',
            'status',
            'statusMessage',
            'alreadyRegistered'
        ));
    }
    
    public function viewResorts()
    {
        $userId = Auth::id(); // Get the logged-in user ID
    
        // Fetch resorts from both the 'owners' and 'pending_owners' tables for the logged-in user
        $approvedResorts = Owner::where('user_id', $userId)->get();  // Approved resorts
        $pendingResorts = PendingOwner::where('user_id', $userId)->get();  // Pending resorts
    
        // Pass both approved and pending resorts to the view
        return view('resortownerview', compact('approvedResorts', 'pendingResorts'));
    }
    
    public function showResorts()
    {
        $approvedResorts = DB::table('owners')->where('status', 'approved')->get();
        $pendingResorts = DB::table('owners')->where('status', 'pending')->get();
    
        return view('resort.owner_dashboard', compact('approvedResorts', 'pendingResorts'));
    }
    
    public function edit($id)
    {
        $resort = Owner::findOrFail($id);
        return view('editresort', compact('resort'));
    }

    public function update(Request $request, $id)
    {
        $resort = Owner::findOrFail($id);

        $request->validate([
            'resortname' => 'required|string|max:255',
            'resorts_address' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $resort->update($request->only(['resortname', 'resorts_address', 'description']));

        return redirect()->route('resortownerview')->with('success', 'Resort updated successfully.');
    }

    public function destroy($id)
    {
        $resort = Owner::findOrFail($id);
        $resort->delete();

        return redirect()->route('resortownerview')->with('success', 'Resort deleted successfully.');
    }

    public function registerResort(Request $request)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first!');
        }
    
        // Validate input
        $validatedData = $request->validate([
            'zipcode' => 'required|string|max:10',
            'resortname' => 'required|string|max:255',
            'resorts_address' => 'required|string|max:255',
            'type_of_accommodation' => 'required|string',
            'description' => 'required|string',
            'resort_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Get the current logged-in user's ID
        $userId = Auth::id();
    
        // If userId is null, it means the user is not logged in
        if ($userId === null) {
            return redirect()->route('login')->with('error', 'You must be logged in to register a resort.');
        }
    
        // Check if the user has already registered a resort (based on user_id)
        $existingResort = PendingOwner::where('user_id', $userId)->first();
    
        if ($existingResort) {
            // If the user has already registered a resort, update only the resort-specific fields
            $existingResort->update([
                'zipcode' => $request->zipcode,
                'resortname' => $request->resortname,
                'resorts_address' => $request->resorts_address,
                'type_of_accommodation' => $request->type_of_accommodation,
                'description' => $request->description,
                'resort_img' => $request->hasFile('resort_img') ? $request->file('resort_img')->store('resorts_images') : $existingResort->resort_img, // Update image if provided
                'status' => 'pending',  // Status stays 'pending' until approval
                'updated_at' => now(),
            ]);
        } else {
            // If the user has not registered a resort, create a new entry (with all the required fields)
            PendingOwner::create([
                'user_id' => $userId,  // Link to the current logged-in user
                'firstname' => Auth::user()->firstname, // Preserve the user's first name
                'lastname' => Auth::user()->lastname,   // Preserve the user's last name
                'email' => Auth::user()->email,         // Preserve the user's email
                'username' => Auth::user()->username,   // Preserve the user's username
                'password' => Auth::user()->password,   // Preserve the user's password
                'zipcode' => $request->zipcode,
                'resortname' => $request->resortname,
                'resorts_address' => $request->resorts_address,
                'type_of_accommodation' => $request->type_of_accommodation,
                'description' => $request->description,
                'resort_img' => $request->hasFile('resort_img') ? $request->file('resort_img')->store('resorts_images') : null,
                'status' => 'pending',  // Default status is 'pending' before admin approval
                'user_id' => $userId,  // Make sure the user_id is assigned
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        // Return the response or redirect
        return redirect()->route('resortowner')->with('statusMessage', 'Resort registration submitted for approval.');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('resort_img')) {
            $file = $request->file('resort_img');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/resort_images', $filename);
    
            return response()->json(['success' => true, 'filename' => $filename]);
        }
    
        return response()->json(['success' => false], 400);
    }

    public function delete(Request $request)
    {
        $filename = $request->filename;

        // Delete the file from storage
        $path = public_path('uploads/' . $filename);
        if (file_exists($path)) {
            unlink($path);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

}

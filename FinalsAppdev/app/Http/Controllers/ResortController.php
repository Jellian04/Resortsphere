<?php

namespace App\Http\Controllers;

use App\Models\Resort;
use App\Models\ResortImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResortController extends Controller
{
    public function index()
    {
        $resorts = Resort::where('registers_id', auth()->id())->get();
        return view('resortowner', compact('resorts')); // Make sure the view file is named resortowner.index
    }

    public function dashboard()
    {
        $resorts = Resort::where('registers_id', auth()->id())->get();
        return view('resortowner'); // This should match your Blade file: resources/views/resortowner.blade.php
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'accommodation_type' => 'required|string',
            'other_accommodation' => 'required_if:accommodation_type,other',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'images' => 'required|array|min:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $accommodationType = $request->accommodation_type === 'other' && $request->filled('other_accommodation')
            ? $request->other_accommodation
            : $request->accommodation_type;

        // Create the resort
        $resort = Resort::create([
            'registers_id' => Auth::id(),
            'resort_name' => $request->name,
            'resort_address' => $request->address,
            'accommodation_type' => $accommodationType, 
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'pending',
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('resort_images', 'public');
                
                ResortImage::create([
                    'resort_id' => $resort->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Resort submitted for approval',
            'redirect' => route('resortowner.dashboard')
        ]);
    }

    public function show($id)
    {
        $resort = Resort::with('images')->findOrFail($id);
        return view('resorts.show', compact('resort'));
    }

    public function ownerView()
    {
        $userId = Auth::id();
        
        // Get resorts of the logged-in user, grouped by status, with the resort images
        $resortsByStatus = Resort::with('resortImages') // Changed to resortImages (plural)
                                ->where('registers_id', $userId)
                                ->get()
                                ->groupBy('status');  // Group resorts by status
        
        return view('resortownerview', compact('resortsByStatus'));
    }

    public function showResorts()
    {
        $resorts = Resort::with('resortImages')
                    ->where('registers_id', auth()->id()) // Only show resorts for logged in owner
                    ->get();
        
        // Group by status
        $resortsByStatus = $resorts->groupBy('status');
        
        return view('resortownerview', compact('resortsByStatus'));
    }
    
    
    
}


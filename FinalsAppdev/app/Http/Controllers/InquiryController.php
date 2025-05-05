<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function showForm()
    {
        return view('inquiry-form');
    }

    public function sendEmail(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'inquiryType' => 'required|string|in:booking,pricing,services,availability,amenities,events,others',  
            'otherInquiry' => 'nullable|string|max:100', // validate only if "others" is selected
            'name' => 'required|string|max:100',  
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'message' => 'required|string|max:1000',  
        ]);

        // Compose the email content
        $emailMessage = "Inquiry Type: {$request->inquiryType}\n";
        $emailMessage = "Specified Inquiry Type: {$request->otherInquiry}\n";
        $emailMessage .= "Name: {$request->name}\n";
        $emailMessage .= "Email: {$request->email}\n";
        $emailMessage .= "Message:\n{$request->message}";

        try {
            Mail::raw($emailMessage, function ($mail) use ($request) {
                $mail->to('jellianzilmar422@gmail.com') 
                     ->subject('New Inquiry');
            });

            // If email is sent successfully, return success message
            return back()->with('success', 'Inquiry sent successfully!');
        } catch (\Exception $e) {
            // If email sending fails, return error message
            return back()->with('error', 'Failed to send inquiry. Please try again.');
        }
    }
}

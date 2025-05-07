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

        \Log::info('Inquiry submission started', $request->all());
    
        // Add this debug line
        \Log::info('Mail Configuration:', [
            'driver' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
        ]);

        // Validate incoming request
        $request->validate([
            'inquiryType' => 'required|string|in:booking,pricing,services,availability,amenities,events,others',  
            'otherInquiry' => 'nullable|string|max:100',
            'name' => 'required|string|max:100',  
            'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\- ]+$/'],
            'message' => 'required|string|max:1000',
            'contactMethod' => 'required|in:email,phone'
        ]);

        // Compose the email content
        $emailMessage = "New Inquiry Received\n\n";
        $emailMessage .= "Inquiry Type: {$request->inquiryType}\n";
        if ($request->inquiryType === 'others' && $request->otherInquiry) {
            $emailMessage .= "Specified Inquiry: {$request->otherInquiry}\n";
        }
        $emailMessage .= "Name: {$request->name}\n";
        $emailMessage .= "Contact Method: {$request->contactMethod}\n";
        $emailMessage .= $request->contactMethod === 'email' 
            ? "Email: {$request->email}\n"
            : "Phone: {$request->phone}\n";
        $emailMessage .= "\nMessage:\n{$request->message}\n";

        try {
            Mail::raw($emailMessage, function ($mail) use ($request) {
                $mail->to('jellianzilmar422@gmail.com')
                     ->subject("New Inquiry: {$request->inquiryType}");
            });

            return back()->with('success', 'Inquiry sent successfully!');
        } catch (\Exception $e) {
            \Log::error("Email sending failed: " . $e->getMessage());
            return back()->with('error', 'Failed to send inquiry. Please try again.');
        }
    }
}
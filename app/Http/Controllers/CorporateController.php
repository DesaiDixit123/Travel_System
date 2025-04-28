<?php

namespace App\Http\Controllers;

use App\Models\Corporate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CorporateRegistrationMail;

class CorporateController extends Controller
{
  
    public function showForm()
    {
        
        return view('session.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'contact_person' => 'required',
            'designation' => 'required',
            'contact_number' => 'required',
            'email' => 'required|email|unique:corporates',
            'password'=> 'required',
            'address' => 'required',
            'department' => 'required',
            'agreement' => 'accepted',
        ]);
    
        // Generate a secure random password
        // $password = Str::random(12); // Increased length for security
    
        $corporate = Corporate::create([
            'company_name' => $request->company_name,
            'contact_person' => $request->contact_person,
            'designation' => $request->designation,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'address' => $request->address,
            'department' => $request->department,
            'password' => $request->password, // Store the plain password
        ]);
    
        // // Send the password to the user's email
        // Mail::to($corporate->email)->send(new CorporateRegistrationMail($corporate, $password));
    
        // Redirect with success message
        return redirect()->route('login')->with('success', 'Registration successful! Check your email.');
    }
    


    public function index()
    {

        $corporates = Corporate::paginate(10);
        // $corporates = Corporate::all(); // Get all records
        return view('Pages.Corporate', compact('corporates')); // Corrected view path
    }
    

}

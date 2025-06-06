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
        
        return view('Pages.Corporates.AddCorporate');
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
            'password' => $request->password, // Store the plain password
        ]);
    
        // // Send the password to the user's email
        // Mail::to($corporate->email)->send(new CorporateRegistrationMail($corporate, $password));
    
        // Redirect with success message
        return redirect()->route('corporates.index')->with('success', 'Registration successful! Check your email.');
    }
    


    public function index()
    {
        $corporates = Corporate::orderBy('created_at', 'desc')->paginate(10);
        return view('Pages.Corporates.Corporate', compact('corporates'));
    }
    

     // 🔧 EDIT corporate form
     public function edit($id)
     {
         $corporate = Corporate::findOrFail($id);
         return view('Pages.Corporates.EditCorporate', compact('corporate'));
     }
 
     // 🔄 UPDATE corporate record
     public function update(Request $request, $id)
     {
         $request->validate([
             'company_name' => 'required',
             'contact_person' => 'required',
             'designation' => 'required',
             'contact_number' => 'required',
             'email' => 'required|email|unique:corporates,email,' . $id,
             'address' => 'required',
         ]);
 
         $corporate = Corporate::findOrFail($id);
 
         $corporate->update([
             'company_name' => $request->company_name,
             'contact_person' => $request->contact_person,
             'designation' => $request->designation,
             'contact_number' => $request->contact_number,
             'email' => $request->email,
             'address' => $request->address,
         ]);
 
         return redirect()->route('corporates.index')->with('success', 'Corporate updated successfully.');
     }
 
    public function destroy($id)
    {
        $corporate = Corporate::findOrFail($id);
        $corporate->delete();

        return redirect()->route('corporates.index')->with('success', 'Corporate deleted successfully.');
    }

}

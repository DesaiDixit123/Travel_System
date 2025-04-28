<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Corporate;
use Auth;
class EmployeeController extends Controller
{
    public function create()
    {
        $companies = Corporate::pluck('company_name');
        return view('laravel-examples.AddEmployee', compact('companies'));
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required',
          
           'company_name' => 'required|exists:corporates,company_name' ,
            'department' => 'required',
            'limit' => 'required|numeric'
        ]);

        // Store in DB
        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
         
            'department' => $request->department,
            'limit' => $request->limit,
            'company_name'=>$request->company_name,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }
    public function index()
    {
        $role = session('user_role'); // Get the role from session
    
        if ($role === 'corporate') {
            $corporate = Auth::guard('corporate')->user();
            $employees = $corporate->employees()->paginate(5); // Relationship with pagination
        } else if ($role === 'admin') {
            $employees = Employee::paginate(5); // Admin side paginate
        } else {
            $employees = collect(); // Empty collection
        }
    
        return view('laravel-examples.Employess', compact('employees'));
    }
    

}
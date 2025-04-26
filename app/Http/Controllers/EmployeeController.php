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
            'employee_id' => 'required|unique:employees',
           'company_name' => 'required|exists:corporates,company_name' ,
            'department' => 'required',
            'limit' => 'required|numeric'
        ]);

        // Store in DB
        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'employee_id' => $request->employee_id,
            'department' => $request->department,
            'limit' => $request->limit,
            'company_name'=>$request->company_name,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    public function index()
    {
        // Check if the user is logged in as corporate or admin
        $role = session('user_role'); // Get the role from session

        if ($role === 'corporate') {
            // For corporate, fetch employees of the logged-in corporate user
            $corporate = Auth::guard('corporate')->user();
            $employees = $corporate->employees; // Assuming the relationship is defined as employees() in the Corporate model
        } else if ($role === 'admin') {
            // For admin, show all employees
            $employees = Employee::all();
        } else {
            $employees = []; // Return empty if no valid session or role
        }

        return view('laravel-examples.Employess', compact('employees'));
    }


}
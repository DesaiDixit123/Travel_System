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
        return view('Pages.AddEmployee', compact('companies'));
    }

    public function store(Request $request)
    {
        // Validation
     $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email',
    'mobile' => 'required',
    'employee_id' => 'required',
    'company_name' => 'required|exists:corporates,company_name',
    'department' => 'required|string',
    'limit' => 'required|numeric',
    'designation' => 'nullable|string|max:255' // 👉 Add this
]);

Employee::create([
    'name' => $request->name,
    'email' => $request->email,
    'mobile' => $request->mobile,
    'employee_id' => $request->employee_id,
    'department' => $request->department,
    'limit' => $request->limit,
    'company_name' => $request->company_name,
    'designation' => $request->designation, // 👉 Add this
]);


        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }
   
    public function index()
    {
        $role = session('user_role'); // Get the role from session
    
        if ($role === 'corporate') {
            $corporate = Auth::guard('corporate')->user();
            $employees = $corporate->employees()
                                   ->orderBy('created_at', 'desc') // 👈 Newest first
                                   ->paginate(5);
        } else if ($role === 'admin') {
            // ✅ Step 1: Get valid company names from Corporate table
            $validCompanyNames = Corporate::pluck('company_name')->toArray();
    
            // ✅ Step 2: Filter employees whose company_name is valid, order by latest
            $employees = Employee::whereIn('company_name', $validCompanyNames)
                                 ->orderBy('created_at', 'desc') // 👈 Newest first
                                 ->paginate(10);
        } else {
            $employees = collect(); // Empty collection
        }
    
        return view('Pages.Employess', compact('employees'));
    }

    // Show edit form
public function edit($id)
{
    $employee = Employee::findOrFail($id);
    $companies = Corporate::pluck('company_name');
    return view('Pages.EditEmployee', compact('employee', 'companies'));
}

// Update employee
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'mobile' => 'required',
        'employee_id' => 'required',
        'company_name' => 'required|exists:corporates,company_name',
        'department' => 'required|string',
        'limit' => 'required|numeric',
         'designation' => 'nullable|string|max:255' 
    ]);

    $employee = Employee::findOrFail($id);
    $employee->update([
        'name' => $request->name,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'employee_id' => $request->employee_id,
        'company_name' => $request->company_name,
        'department' => $request->department,
        'limit' => $request->limit,
        'designation' => $request->designation, 
    ]);

    return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
}

// Delete employee
public function destroy($id)
{
    $employee = Employee::findOrFail($id);
    $employee->delete();

    return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
}
    
}
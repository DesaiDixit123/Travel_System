<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Employee;
use App\Models\Corporate;

class QuotationController extends Controller
{
    // Show Quotation List or Form
    public function index(Request $request)
{
    // Retrieve the search query from the request
    $searchQuery = $request->input('search_query');
    
    // Check if the search query is not empty
    if (!empty($searchQuery)) {
        // If there is a search query, filter quotations based on the provided fields
        $quotations = Quotation::where('employee_mobile', 'like', '%' . $searchQuery . '%')
            ->orWhere('company_name', 'like', '%' . $searchQuery . '%')
            ->orWhere('corporate_mobile', 'like', '%' . $searchQuery . '%')
            ->orWhere('department', 'like', '%' . $searchQuery . '%')
            ->orWhere('corporate_email', 'like', '%' . $searchQuery . '%') // Added email search
            ->orWhere('employee_id', 'like', '%' . $searchQuery . '%') // Added employee ID search
            ->orWhere('status', 'like', '%' . $searchQuery . '%') // Added status search (approved, disapproved, pending)
            ->paginate(5); // Add pagination
    } else {
        // If no search query, return all quotations (or use pagination as before)
        $quotations = Quotation::paginate(5);
    }
    
    // Return the view with the quotations and search query
    return view('laravel-examples.AddQuatation', compact('quotations', 'searchQuery'));
}

    
    // Show create quotation form with employee list
    public function create(Request $request)
    {
        $role = session('user_role'); // Get the role from session
        
        // Get the search query from the request
        $searchQuery = $request->input('search_query');
        
        if ($role === 'corporate') {
            $corporate = \Auth::guard('corporate')->user(); // Get the logged-in corporate user
            $companyName = $corporate->company_name;
        
            // Normalize the company name (remove spaces and convert to lowercase)
            $companyNameNormalized = strtolower(preg_replace('/\s+/', '', $companyName));
    
            // Filter quotations based on the normalized company name and search query (if provided)
            if (!empty($searchQuery)) {
                $quotations = Quotation::whereRaw("REPLACE(LOWER(company_name), ' ', '') = ?", [$companyNameNormalized])
                    ->where(function ($query) use ($searchQuery) {
                        $query->where('employee_mobile', 'like', '%' . $searchQuery . '%')
                            ->orWhere('company_name', 'like', '%' . $searchQuery . '%')
                            ->orWhere('corporate_mobile', 'like', '%' . $searchQuery . '%')
                            ->orWhere('department', 'like', '%' . $searchQuery . '%')
                            ->orWhere('corporate_email', 'like', '%' . $searchQuery . '%')
                            ->orWhere('employee_id', 'like', '%' . $searchQuery . '%')
                            ->orWhere('status', 'like', '%' . $searchQuery . '%');
                    })
                    ->paginate(5);
            } else {
                $quotations = Quotation::whereRaw("REPLACE(LOWER(company_name), ' ', '') = ?", [$companyNameNormalized])
                    ->paginate(5);
            }
        
        } else if ($role === 'admin') {
            // If the user is an admin, apply the search query (if provided)
            if (!empty($searchQuery)) {
                $quotations = Quotation::where(function ($query) use ($searchQuery) {
                    $query->where('employee_mobile', 'like', '%' . $searchQuery . '%')
                        ->orWhere('company_name', 'like', '%' . $searchQuery . '%')
                        ->orWhere('corporate_mobile', 'like', '%' . $searchQuery . '%')
                        ->orWhere('department', 'like', '%' . $searchQuery . '%')
                        ->orWhere('corporate_email', 'like', '%' . $searchQuery . '%')
                        ->orWhere('employee_id', 'like', '%' . $searchQuery . '%')
                        ->orWhere('status', 'like', '%' . $searchQuery . '%');
                })
                ->paginate(5);
            } else {
                $quotations = Quotation::paginate(5);
            }
        } else {
            $quotations = collect(); // Empty collection for other roles
        }
    
        // Return the view with the quotations and the search query
        return view('laravel-examples.Quotations', compact('quotations', 'searchQuery'));
    }
    
    // Store quotation data
     public function store(Request $request)
{
    $employee = Employee::where('id', $request->employee_id_hidden)->first();

    // Debugging step: Check if the email exists in employee
    if (!$employee || !$employee->email) {
        // Handle missing email (you can either show an error or log it)
        return redirect()->back()->with('error', 'Employee email is missing.');
    }

    // Extra checking - lowercase + remove all spaces
    $employeeCompanyName = strtolower(preg_replace('/\s+/', '', $employee->company_name));

    $corporate = Corporate::get()->filter(function($corp) use ($employeeCompanyName) {
        $corpCompanyName = strtolower(preg_replace('/\s+/', '', $corp->company_name));
        return $corpCompanyName === $employeeCompanyName;
    })->first();

    Quotation::create([
        'employee_id'       => $employee->id,
        'employee_mobile'   => $employee->mobile,
        'corporate_mobile'  => $corporate->contact_number ?? 'N/A',
        'corporate_email'   => $corporate->email ?? null,
        'employee_email'    => $request->employee_email, // 👈
        'company_name'      => $request->company_name,
        'employee_name'     => $employee->name,
        'department'        => $employee->department,
        'hotel_limit'       => $employee->limit,
        'flight'            => $request->flight,
        'other_expenses'    => $request->other_expenses,
        'quotation'         => $request->Quotation, // 👈
    ]);
    
    return redirect()->back()->with('success', 'Quotation submitted successfully!');
}

    // API for employee & corporate info
    public function getEmployeeInfo(Request $request)
    {
        try {
            $employee = Employee::where('id', $request->employee_id)->first();
    
            if (!$employee) {
                return response()->json(['success' => false, 'message' => 'Employee not found']);
            }
    
            // Extra checking - lowercase + remove all spaces
            $employeeCompanyName = strtolower(preg_replace('/\s+/', '', $employee->company_name));
    
            $corporate = Corporate::get()->filter(function($corp) use ($employeeCompanyName) {
                $corpCompanyName = strtolower(preg_replace('/\s+/', '', $corp->company_name));
                return $corpCompanyName === $employeeCompanyName;
            })->first();
    
            return response()->json([
                'success' => true,
                'employee' => [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'company_name' => $employee->company_name,
                    'department' => $employee->department,
                    'limit' => $employee->limit,
                    'employee_email' => $employee->email,   // 🛑 Employee email added here
                ],
                'corporate_mobile' => $corporate->contact_number ?? '',
                'corporate_email' => $corporate->email ?? '',
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    


    // Show single quotation detail (View)
public function show($id)
{
    $quotation = Quotation::findOrFail($id);
    return view('laravel-examples.viewQuotation', compact('quotation'));
}

// Show edit form
public function edit($id)
{
    $quotation = Quotation::findOrFail($id);
    return view('laravel-examples.editQuotation', compact('quotation'));
}

// Update quotation
public function update(Request $request, $id)
{
    $quotation = Quotation::findOrFail($id);

    $quotation->update([
        'flight' => $request->flight,
        'other_expenses' => $request->other_expenses,
        'quotation' => $request->Quotation,
    ]);

    return redirect()->route('quotations.create')->with('success', 'Quotation updated successfully.');
}

// Delete quotation
public function destroy($id)
{
    $quotation = Quotation::findOrFail($id);
    $quotation->delete();

    return redirect()->route('quotations.create')->with('success', 'Quotation deleted successfully.');
}



// Approve quotation
public function approve($id)
{
    $quotation = Quotation::findOrFail($id);
    $quotation->status = 'approved';
    $quotation->save();

    return redirect()->back()->with('success', 'Quotation approved successfully.');
}

// Disapprove quotation
public function disapprove($id)
{
    $quotation = Quotation::findOrFail($id);
    $quotation->status = 'disapproved';
    $quotation->save();

    return redirect()->back()->with('success', 'Quotation disapproved successfully.');
}

// Set quotation back to pending
public function setPending($id)
{
    $quotation = Quotation::findOrFail($id);
    $quotation->status = 'pending';
    $quotation->save();

    return redirect()->back()->with('success', 'Quotation set back to pending.');
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Employee;
use App\Models\Corporate;
use Illuminate\Support\Facades\Storage;

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
                ->paginate(10); // Add pagination
        } else {
            // If no search query, return all quotations (or use pagination as before)
            $quotations = Quotation::paginate(10);
        }

        // Return the view with the quotations and search query
        return view('Pages.Quotation.AddQuatation', compact('quotations', 'searchQuery'));
    }


    // Show create quotation form with employee list
    public function create(Request $request)
    {
        $role = session('user_role');

        $employeeMobiles = Employee::pluck('mobile')->toArray();
        $mobilesInQuotations = Quotation::whereIn('employee_mobile', $employeeMobiles)
            ->pluck('employee_mobile')
            ->unique()
            ->toArray();

        $validMobiles = Employee::pluck('mobile')->toArray();

        // 🔍 Search & Date Filters
        $searchQuery = $request->input('search_query');
        $quotationDate = $request->input('quotation_date');
        $fromDate = $request->input('from_date'); // ⬅️ New input
        $toDate = $request->input('to_date');     // ⬅️ New input

        if ($role === 'corporate') {
            $corporate = \Auth::guard('corporate')->user();
            $companyNameNormalized = strtolower(preg_replace('/\s+/', '', $corporate->company_name));

            $quotationsQuery = Quotation::whereRaw("REPLACE(LOWER(company_name), ' ', '') = ?", [$companyNameNormalized])
                ->whereIn('employee_mobile', $validMobiles);

        } else if ($role === 'admin') {
         $quotationsQuery = Quotation::query(); 
        } else {
            $quotations = collect(); // Empty collection
            return view('Pages.Quotation.Quotations', compact('quotations', 'searchQuery', 'quotationDate', 'fromDate', 'toDate'));
        }

        // 🔍 Search query logic (updated with only required fields)
        if (!empty($searchQuery)) {
            $quotationsQuery->where(function ($query) use ($searchQuery) {
                $query->where('employee_id', 'like', '%' . $searchQuery . '%')
                    ->orWhere('employee_name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('invoice_date', 'like', '%' . $searchQuery . '%')
                    ->orWhere('bill_no', 'like', '%' . $searchQuery . '%')
                    ->orWhere('from_to', 'like', '%' . $searchQuery . '%');
            });
        }


        // 📆 Date filter logic
        if (!empty($quotationDate)) {
            $quotationsQuery->whereDate('created_at', $quotationDate);
        }

        // 📆 From-To Date Range Filter (New)
        if (!empty($fromDate) && !empty($toDate)) {
            $quotationsQuery->whereBetween('created_at', [$fromDate, $toDate]);
        }

        // ✅ Order & Pagination
        $paginationCount = ($role === 'corporate') ? 5 : 10;
        $quotations = $quotationsQuery
        ->whereNotNull('invoice_date')
        ->orderBy('invoice_date', 'desc')
        ->paginate($paginationCount);

        return view('Pages.Quotation.Quotations', compact('quotations', 'searchQuery', 'quotationDate', 'fromDate', 'toDate'));
    }

    // Store quotation data
    public function store(Request $request)
    {
        try {
            $employeeIds = $request->input('employee_ids', []);

            if (empty($employeeIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No employee IDs provided.',
                ], 400);
            }

            $names = [];
            $mobiles = [];
            $emails = [];
            $companyNames = [];
            $corporateMobiles = [];
            $corporateEmails = [];

            foreach ($employeeIds as $empId) {
                $employee = Employee::where('employee_id', $empId)->first();

                if (!$employee)
                    continue;

                $names[] = $employee->name;
                $mobiles[] = $employee->mobile;
                $emails[] = $employee->email ?? '';

                $companyNames[] = $employee->company_name ?? '';

                // Match corporate company by name
                $employeeCompany = strtolower(preg_replace('/\s+/', '', $employee->company_name));
                $corporate = Corporate::get()->first(function ($corp) use ($employeeCompany) {
                    return strtolower(preg_replace('/\s+/', '', $corp->company_name)) === $employeeCompany;
                });

                if ($corporate) {
                    $corporateMobiles[] = $corporate->contact_number ?? '';
                    $corporateEmails[] = $corporate->email ?? '';
                }
            }

            if (empty($names)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid employees found.',
                ], 400);
            }

            $quotation = Quotation::create([
                'employee_id' => implode(',', $employeeIds),
                'employee_name' => implode(',', $names),
                'employee_mobile' => implode(',', $mobiles),
                'employee_email' => implode(',', $emails),
                'company_name' => implode(',', $companyNames),
                'corporate_mobile' => implode(',', $corporateMobiles),
                'corporate_email' => implode(',', $corporateEmails),

                'invoice_date' => $request->invoice_date,
                'travel_from' => $request->travel_from,
                'travel_to' => $request->travel_to,
                'bill_no' => $request->bill_no,
                'from_to' => $request->from_to,
                'amount' => $request->amount,
                'include' => is_array($request->include) ? json_encode($request->include) : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quotation saved successfully!',
                'data' => $quotation
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }


    // API for employee & corporate info
    public function getEmployeeInfo(Request $request)
    {
        try {
            // Get the input (either mobile number or employee_id)
            $input = $request->input('input'); // Frontend ma `query` key thi value moklvi

            // Search for employee by mobile or employee_id
            $employee = Employee::where('mobile', $input)
                ->orWhere('employee_id', $input)
                ->first();

            if (!$employee) {
                return response()->json(['success' => false, 'message' => 'Employee not found']);
            }

            // Normalize company name for comparison
            $employeeCompanyName = strtolower(preg_replace('/\s+/', '', $employee->company_name));

            $corporate = Corporate::get()->filter(function ($corp) use ($employeeCompanyName) {
                $corpCompanyName = strtolower(preg_replace('/\s+/', '', $corp->company_name));
                return $corpCompanyName === $employeeCompanyName;
            })->first();

            return response()->json([
                'success' => true,
                'employee' => [
                    'id' => $employee->employee_id,
                    'name' => $employee->name,
                    'company_name' => $employee->company_name,
                    'department' => $employee->department,
                    'limit' => $employee->limit,
                    'employee_email' => $employee->email,
                    'mobile' => $employee->mobile,
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
        return view('Pages.Quotation.viewQuotation', compact('quotation'));
    }

    // Show edit form
    public function edit($id)
    {
        $quotation = Quotation::findOrFail($id);
        return view('Pages.Quotation.editQuotation', compact('quotation'));
    }

    // Update quotation
    public function update(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        $quotation->update([

            'invoice_date' => $request->invoice_date,
            'travel_from' => $request->travel_from,
            'travel_to' => $request->travel_to,
            'bill_no' => $request->bill_no,
            'from_to' => $request->from_to,
            'amount' => $request->amount,
            'include' => is_array($request->include) ? json_encode($request->include) : null,
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


    public function upload(Request $request, $id)
    {
        $request->validate([
            'email_screenshot' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $quotation = Quotation::findOrFail($id);

        if ($request->hasFile('email_screenshot')) {
            // Generate a unique filename
            $filename = time() . '_' . $request->file('email_screenshot')->getClientOriginalName();

            // Store the file in storage/app/public/screenshots
            $path = $request->file('email_screenshot')->storeAs('public/screenshots', $filename);

            // Update both image and status in the DB
            $quotation->update([
                'email_screenshot' => $filename,
                'status' => 'approved', // ✅ Set to approved on successful upload
            ]);
        }

        return redirect()->back()->with('success', 'Screenshot uploaded successfully. Status updated to Approved.');
    }

}

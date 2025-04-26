<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Employee;
use App\Models\Corporate;

class QuotationController extends Controller
{
    // Show Quotation List or Form
    public function index()
    {
        return view('laravel-examples.AddQuatation');
    }

    // Show create quotation form with employee list
    public function create()
    {
        $role = session('user_role'); // Session mathi role get kariye
    
        if ($role === 'corporate') {
            $corporate = \Auth::guard('corporate')->user(); // je corporate login che ene get kariye
            $companyName = $corporate->company_name;
    
            // Extra checking - lowercase + remove all spaces
            $companyNameNormalized = strtolower(preg_replace('/\s+/', '', $companyName));
    
            $quotations = Quotation::all()->filter(function($quotation) use ($companyNameNormalized) {
                $quotationCompanyNameNormalized = strtolower(preg_replace('/\s+/', '', $quotation->company_name));
                return $quotationCompanyNameNormalized === $companyNameNormalized;
            });
        } else if ($role === 'admin') {
            $quotations = Quotation::all();
        } else {
            $quotations = collect(); // empty collection
        }
    
        return view('laravel-examples.Quotations', compact('quotations'));
    }
    

    // Store quotation data
    public function store(Request $request)
    {
        $employee = Employee::where('employee_id', $request->employee_id_hidden)->first();
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
            'corporate_email'   => $employee->email ?? null,
           'company_name'      => $request->company_name, 
            'employee_name'     => $employee->name,
            'department'        => $employee->department,
            'hotel_limit'        => $employee->limit,
            'flight'            => $request->flight,
            'other_expenses'    => $request->other_expenses,
            'Quotation'             => $request->Quotation,
        ]);

        return redirect()->back()->with('success', 'Quotation submitted successfully!');
    }

    // API for employee & corporate info
    public function getEmployeeInfo(Request $request)
    {
        try {
            $employee = Employee::where('employee_id', $request->employee_id)->first();
    
            if (!$employee) {
                return response()->json(['success' => false, 'message' => 'Employee not found']);
            }
    
            // Extra checking - lowercase + remove all spaces
            $employeeCompanyName = strtolower(preg_replace('/\s+/', '', $employee->company_name));
    
            $corporate = Corporate::get()->filter(function($corp) use ($employeeCompanyName) {
                $corpCompanyName = strtolower(preg_replace('/\s+/', '', $corp->company_name));
                return $corpCompanyName === $employeeCompanyName;
            })->first();
    
            if (!$corporate) {
                return response()->json([
                    'success' => true,
                    'employee' => $employee,
                    'corporate_mobile' => '',
                    'corporate_email' => '',
                    'message' => 'Corporate details not found'
                ]);
            }
    
            return response()->json([
                'success' => true,
                'employee' => $employee,
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
      
}

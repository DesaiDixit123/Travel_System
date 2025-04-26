@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Add Quotation</h5>
                </div>
                <div class="card-body px-4">

                    {{-- Step 1: Employee Basic Info --}}
                    <form id="stepOneForm">
                        @csrf
                        <div class="mb-3">
                            <label for="emp_id" class="form-label">Employee ID</label>
                            <input type="text" name="employee_id" class="form-control" id="employee_id" placeholder="Enter employee ID" required>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Employee Mobile Number</label>
                            <input type="text" name="employee_mobile" class="form-control" id="mobile" placeholder="Enter mobile number" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" id="continueBtn" class="btn bg-gradient-primary">Continue</button>
                        </div>
                    </form>

                    {{-- Step 2: Corporate & Quotation Info --}}
                    <form action="{{ route('quotations.store') }}" method="POST" id="quotationForm" style="display: none;">
                        @csrf
                   

                        <input type="hidden" name="employee_id_hidden" id="employee_id_hidden">
                        <input type="hidden" name="employee_mobile_hidden" id="employee_mobile_hidden">

                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" placeholder="Enter company name" required>
                        </div>

                        <div class="mb-3">
                            <label for="corporate_mobile" class="form-label">Corporate Mobile Number</label>
                            <input type="text" name="corporate_mobile" class="form-control" placeholder="Enter corporate mobile number" required>
                        </div>

                        <div class="mb-3">
                            <label for="corporate_email" class="form-label">Corporate Email</label>
                            <input type="email" name="corporate_email" class="form-control" placeholder="Enter corporate email" required>
                        </div>

                        <div class="mb-3">
                            <label for="employee_name" class="form-label">Employee Name</label>
                            <input type="text" name="employee_name" class="form-control" placeholder="Enter employee name" required>
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select name="department" class="form-select" required>
                                <option value="" disabled selected>Select department</option>
                                <option value="HR">HR</option>
                                <option value="IT">IT</option>
                                <option value="Sales">Sales</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Finance">Finance</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="limit" class="form-label">Hotel Limit</label>
                            <input type="text" name="limit" class="form-control" placeholder="Enter hotel limit" required>
                        </div>

                        <div class="mb-3">
                            <label for="flight" class="form-label">Flight</label>
                            <input type="text" name="flight" class="form-control" placeholder="Enter flight details" required>
                        </div>

                        <div class="mb-3">
                            <label for="other_expenses" class="form-label">Other Expenses</label>
                            <textarea name="other_expenses" class="form-control" rows="3" placeholder="Enter other expenses..."></textarea>
                        </div>

                        {{-- New Quotation Field --}}
                        <div class="mb-3">
                            <label for="quotation" class="form-label">Quotation</label>
                            <textarea name="Quotation" class="form-control" rows="3" placeholder="Enter your quotation..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            {{-- WhatsApp Share Button --}}
                            <button type="button" id="shareOnWhatsapp" class="btn btn-success">
    Share on WhatsApp
</button>

                            {{-- Submit Button --}}
                            <button type="submit" class="btn bg-gradient-success">Submit Quotation</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('continueBtn').addEventListener('click', function () {
        const empId = document.getElementById('employee_id').value;
        const mobile = document.getElementById('mobile').value;

        if (empId && mobile) {
            fetch(`/api/employee-info?employee_id=${empId}&mobile=${mobile}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hide first step
                        document.getElementById('stepOneForm').style.display = 'none';
                        // Show second step
                        document.getElementById('quotationForm').style.display = 'block';

                        // Fill hidden values
                        document.getElementById('employee_id_hidden').value = empId;
                        document.getElementById('employee_mobile_hidden').value = mobile;

                        // Fill rest of the form
                        document.querySelector('input[name="company_name"]').value = data.employee.company_name;
                        document.querySelector('input[name="employee_name"]').value = data.employee.name;
                        document.querySelector('input[name="limit"]').value = data.employee.limit;
                        document.querySelector('select[name="department"]').value = data.employee.department;

                        document.querySelector('input[name="corporate_mobile"]').value = data.corporate_mobile;
                        document.querySelector('input[name="corporate_email"]').value = data.corporate_email;
                    } else {
                        alert('Employee not found or invalid mobile number.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Something went wrong while fetching employee info.');
                });
        } else {
            alert("Please enter both Employee ID and Mobile Number.");
        }
    });



    document.getElementById('shareOnWhatsapp').addEventListener('click', function () {
        const employeeName = document.querySelector('input[name="employee_name"]').value;
        const employeeMobile = document.getElementById('mobile').value;
        const companyName = document.querySelector('input[name="company_name"]').value;
        const department = document.querySelector('select[name="department"]').value;
        const limit = document.querySelector('input[name="limit"]').value;
        const flight = document.querySelector('input[name="flight"]').value;
        const otherExpenses = document.querySelector('textarea[name="other_expenses"]').value;
        const quotation = document.querySelector('textarea[name="quotation"]').value;

        // Get corporate mobile number
        let corporateMobile = document.querySelector('input[name="corporate_mobile"]').value;
        corporateMobile = corporateMobile.replace(/\D/g, ''); // remove non-numeric characters

        if (!corporateMobile.startsWith('91')) {
            corporateMobile = '91' + corporateMobile;
        }

        const message = `
*Quotation Details*

👤 *Employee Name:* ${employeeName}
📱 *Employee Mobile:* ${employeeMobile}
🏢 *Company Name:* ${companyName}
🏬 *Department:* ${department}
💰 *Hotel Limit:* ${limit}
✈️ *Flight Details:* ${flight}
📋 *Other Expenses:* ${otherExpenses}
📝 *Quotation:* ${quotation}
        `.trim();

        const encodedMessage = encodeURIComponent(message);
        const whatsappURL = `https://wa.me/${corporateMobile}?text=${encodedMessage}`;

        window.open(whatsappURL, '_blank');
    });

</script>

@endsection

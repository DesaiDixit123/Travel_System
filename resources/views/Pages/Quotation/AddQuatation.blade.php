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
                            <label for="employee_id" class="form-label">Employee ID</label>
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
                    <form id="quotationForm" style="display: none;">
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
                            <label for="employee_email" class="form-label">Employee Email</label>
                            <input type="email" name="employee_email" class="form-control" placeholder="Enter employee email" required>
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

                        <div class="mb-3">
                            <label for="quotation" class="form-label">Quotation</label>
                            <textarea name="quotation" class="form-control" rows="3" placeholder="Enter your quotation..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-success">Submit Quotation</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Popup Modal --}}
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Quotation Submitted Successfully!</h5>
      </div>
      <div class="modal-body text-center">
        <button type="button" id="shareWhatsapp" class="btn btn-success mb-2">Share on WhatsApp</button><br>
        <button type="button" id="goBack" class="btn btn-secondary">Back</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Continue Button
    document.getElementById('continueBtn').addEventListener('click', function () {
        const empId = document.getElementById('employee_id').value.trim();
        const mobile = document.getElementById('mobile').value.trim();

        if (empId && mobile) {
            fetch(`/api/employee-info?employee_id=${empId}&mobile=${mobile}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('stepOneForm').style.display = 'none';
                        document.getElementById('quotationForm').style.display = 'block';

                        document.getElementById('employee_id_hidden').value = empId;
                        document.getElementById('employee_mobile_hidden').value = mobile;

                        document.querySelector('input[name="company_name"]').value = data.employee.company_name || '';
                        document.querySelector('input[name="employee_name"]').value = data.employee.name || '';
                        document.querySelector('input[name="limit"]').value = data.employee.limit || '';
                        document.querySelector('select[name="department"]').value = data.employee.department || '';

                        document.querySelector('input[name="corporate_mobile"]').value = data.corporate_mobile || '';
                        document.querySelector('input[name="corporate_email"]').value = data.corporate_email || '';
                        document.querySelector('input[name="employee_email"]').value = data.employee.employee_email || '';
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

    // Submit Quotation Form
    document.getElementById('quotationForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("{{ route('quotations.store') }}", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
    console.log('Quotation Response:', data); // Debugging line to see the response
    if (data.success) {
        var myModal = new bootstrap.Modal(document.getElementById('successModal'));
        myModal.show();
        
        window.latestQuotationId = data.quotation_id; // Capture the quotation ID
    } else {
        alert('Failed to submit quotation.');
    }
})

        .catch(error => {
            console.error(error);
            alert('Error submitting quotation.');
        });
    });

    document.getElementById('shareWhatsapp').addEventListener('click', function () {
    const employeeName = document.querySelector('input[name="employee_name"]').value.trim();
    const quotation = document.querySelector('textarea[name="quotation"]').value.trim();
    const corporateMobile = document.querySelector('input[name="corporate_mobile"]').value.trim();
    const previewLink = `http://localhost:8000/quotations/${window.latestQuotationId}`;

    const message = `
*Quotation Details*:

👤 *Employee Name:* ${employeeName}
📝 *Quotation:* ${quotation}

🔗 *View the quotation here:* ${previewLink}
    `.trim();

    const encodedMessage = encodeURIComponent(message);

    if (corporateMobile) {
        const whatsappURL = `https://wa.me/${corporateMobile}?text=${encodedMessage}`;
        window.open(whatsappURL, '_blank'); // Open WhatsApp link
    } else {
        alert("Corporate mobile number missing.");
    }
});

    // Go Back Button
    document.getElementById('goBack').addEventListener('click', function () {
        window.location.href = "{{ route('quotations.index') }}"; // Redirect back to quotations list
    });
});
</script>

@endsection

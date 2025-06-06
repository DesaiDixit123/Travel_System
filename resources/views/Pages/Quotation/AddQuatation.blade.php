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

                        {{-- Step 1: Employee Input --}}
                        <form id="stepOneForm">
                            @csrf

                            <div id="employeeInputsContainer">
                                <div class="mb-3 employee-input-group">
                                    <input type="text" class="form-control employee-input"
                                        placeholder="Enter Employee ID or Mobile Number">
                                </div>
                            </div>

                            <div class="mb-3">
                                <button type="button" id="addEmployeeBtn" class="btn btn-sm btn-success">+ Add More</button>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" id="continueBtn" class="btn bg-gradient-primary">Continue</button>
                            </div>
                        </form>

                        {{-- Step 2: Quotation Form --}}
                        <form id="quotationForm" onsubmit="return false;" style="display: none;">
                            @csrf

                            <!-- Hidden Fields -->
                            <div id="employeeHiddenFields"></div>

                            <!-- Employee Name -->
                            <div class="mb-3">
                                <label>Employee Name(s)</label>
                                <div class="form-control" readonly id="employee_name_wrapper"
                                    style="background-color: #f8f9fa; cursor: pointer;"></div>
                            </div>

                            <!-- Hidden Fields (read-only) -->
                            <div class="mb-3" style="display: none;">
                                <label>Company Name</label>
                                <input type="text" name="company_name" class="form-control" readonly>
                            </div>
                            <div class="mb-3" style="display: none;">
                                <label>Corporate Mobile Number</label>
                                <input type="text" name="corporate_mobile" class="form-control" readonly>
                            </div>
                            <div class="mb-3" style="display: none;">
                                <label>Corporate Email</label>
                                <input type="email" name="corporate_email" class="form-control" readonly>
                            </div>
                            <div class="mb-3" style="display: none;">
                                <label>Employee Email</label>
                                <input type="email" name="employee_email" id="employee_email" class="form-control" readonly>
                            </div>

                            <!-- Quotation Fields -->
                            <div class="mb-3">
                                <label>Invoice Date</label>
                                <input type="date" class="form-control" name="invoice_date" required>
                            </div>
                            <div class="mb-3">
                                <label>Travel Date</label>
                                <div class="d-flex gap-2">
                                    <input type="date" class="form-control" name="travel_from" required>
                                    <input type="date" class="form-control" name="travel_to" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Bill No</label>
                                <input type="text" class="form-control" name="bill_no" required>
                            </div>
                            <div class="mb-3">
                                <label>From To</label>
                                <input type="text" class="form-control" name="from_to" required>
                            </div>
                            <div class="mb-3">
                                <label>Amount</label>
                                <input type="number" class="form-control" name="amount" required>
                            </div>
                            <div class="mb-3">
                                <label>Include</label>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="include[]"
                                        value="Flight"> Flight</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="include[]"
                                        value="Train"> Train</div>
                                <div class="form-check"><input class="form-check-input" type="checkbox" name="include[]"
                                        value="Hotel"> Hotel</div>
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

    <!-- Employee Detail Modal -->
    <div class="modal fade" id="employeeDetailModal" tabindex="-1" aria-labelledby="employeeDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modalEmpName"></span></p>
                    <p><strong>Company:</strong> <span id="modalEmpCompany"></span></p>
                    <p><strong>Employee Email:</strong> <span id="modalEmpEmail"></span></p>
                    <p><strong>Corporate Email:</strong> <span id="modalCorporateEmail"></span></p>
                    <p><strong>Corporate Mobile:</strong> <span id="modalCorporateMobile"></span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addBtn = document.getElementById('addEmployeeBtn');
            const continueBtn = document.getElementById('continueBtn');
            const container = document.getElementById('employeeInputsContainer');
            const quotationForm = document.getElementById('quotationForm');
            const hiddenFieldsContainer = document.getElementById('employeeHiddenFields');
            const wrapper = document.getElementById('employee_name_wrapper');

            const names = [], companyNames = [], corporateEmails = [], corporateMobiles = [], employeeEmails = [];

            addBtn.addEventListener('click', () => {
                const newInputDiv = document.createElement('div');
                newInputDiv.classList.add('mb-3', 'employee-input-group');
                newInputDiv.innerHTML = `<input type="text" class="form-control employee-input" placeholder="Enter Employee ID or Mobile Number">`;
                container.appendChild(newInputDiv);
            });

            continueBtn.addEventListener('click', async function () {
                const inputFields = document.querySelectorAll('.employee-input');
                const inputs = [];
                hiddenFieldsContainer.innerHTML = '';
                wrapper.innerHTML = '';

                inputFields.forEach(input => {
                    const val = input.value.trim();
                    if (val) inputs.push(val);
                });

                if (inputs.length === 0) {
                    alert("Please add at least one Employee ID or Mobile Number.");
                    return;
                }

                document.getElementById('stepOneForm').style.display = 'none';
                quotationForm.style.display = 'block';

                for (let [index, input] of inputs.entries()) {
                    try {
                        const response = await fetch(`https://tcholidays.in/corporate/api/employee-info?input=${encodeURIComponent(input)}`);
                        const data = await response.json();

                        if (data.success) {
                            const emp = data.employee;
                            const corpo = data;

                            names.push(emp.name);
                            companyNames.push(emp.company_name);
                            corporateEmails.push(corpo.corporate_email);
                            corporateMobiles.push(corpo.corporate_mobile);
                            employeeEmails.push(emp.employee_email);

                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'employee_ids[]';
                            hiddenInput.value = emp.id;
                            hiddenFieldsContainer.appendChild(hiddenInput);

                            const link = document.createElement('a');
                            link.href = '#';
                            link.textContent = emp.name;
                            link.classList.add('d-inline-block', 'me-2');
                            link.dataset.index = index;
                            link.addEventListener('click', function (e) {
                                e.preventDefault();
                                showEmployeeModal(index);
                            });
                            wrapper.appendChild(link);
                        } else {
                            alert(`Employee not found for: ${input}`);
                        }
                    } catch (error) {
                        console.error(error);
                        alert(`Error fetching info for: ${input}`);
                    }
                }

                quotationForm.querySelector('input[name="company_name"]').value = companyNames.join(', ');
                quotationForm.querySelector('input[name="corporate_email"]').value = corporateEmails.join(', ');
                quotationForm.querySelector('input[name="corporate_mobile"]').value = corporateMobiles.join(', ');
                document.getElementById('employee_email').value = employeeEmails.join(', ');
            });

            quotationForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                const formData = new FormData(quotationForm);

                try {
                    const response = await fetch("{{ route('quotations.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (result.success) {
                        window.location.href = "{{ route('quotations.create') }}";
                    } else {
                        alert(result.message || "Failed to save quotation.");
                    }

                } catch (error) {
                    console.error('Error:', error);
                    alert("Something went wrong while submitting the quotation.");
                }
            });

            function showEmployeeModal(index) {
                const modal = new bootstrap.Modal(document.getElementById('employeeDetailModal'));
                document.getElementById('modalEmpName').textContent = names[index];
                document.getElementById('modalEmpCompany').textContent = companyNames[index];
                document.getElementById('modalEmpEmail').textContent = employeeEmails[index];
                document.getElementById('modalCorporateEmail').textContent = corporateEmails[index];
                document.getElementById('modalCorporateMobile').textContent = corporateMobiles[index];
                modal.show();
            }
        });
    </script>
@endsection
@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="mb-0">Add Employee</h5>
                </div>
                <div class="card-body px-4">
                <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <div class="mb-3">
    <label for="company_name" class="form-label">Company Name</label>
    <select name="company_name" class="form-select" id="company_name" required>
        <option value="" disabled selected>Select company</option>
        @foreach($companies as $company)
            <option value="{{ $company }}">{{ $company }}</option>
        @endforeach
    </select>
</div>


                        <div class="mb-3">
                            <label for="name" class="form-label">Employee Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter employee name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Employee Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter employee email" required>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter mobile number" required>
                        </div>

                        <div class="mb-3">
                            <label for="emp_id" class="form-label">Employee ID</label>
                            <input type="text" name="employee_id" class="form-control" id="emp_id" placeholder="Enter employee ID" required>
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <select name="department" class="form-select" id="department" required>
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
                            <input type="text" name="limit" class="form-control" id="limit" placeholder="Enter hotel limit" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

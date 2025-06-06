@extends('layouts.user_type.auth')

@section('content')

<!-- Import Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Employee</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $employee->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $employee->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" name="mobile" id="mobile" class="form-control" value="{{ $employee->mobile }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee ID</label>
                            <input type="text" name="employee_id" id="employee_id" class="form-control" value="{{ $employee->employee_id }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <select name="company_name" id="company_name" class="form-select" required>
                                @foreach ($companies as $company)
                                    <option value="{{ $company }}" {{ $employee->company_name == $company ? 'selected' : '' }}>
                                        {{ $company }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" name="department" id="department" class="form-control" value="{{ $employee->department }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="limit" class="form-label">Limit</label>
                            <input type="number" name="limit" id="limit" class="form-control" value="{{ $employee->limit }}" required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

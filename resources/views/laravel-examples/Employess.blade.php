@extends('layouts.user_type.auth')

@section('content')

<style>
    .add-btn {
        background-color: #3b5998;
        color: white;
        transition: 0.3s;
    }

    .add-btn:hover {
        background-color: #2d4373;
        color: white;
    }

    .table-responsive::-webkit-scrollbar {
        height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #e0e0e0;
        border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background-color: #3b5998;
        border-radius: 10px;
    }
</style>

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0 px-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Employees</h6>
            <!-- Add Employee Button -->
            <a href="{{ route('employees.create') }}" class="btn add-btn">Add Employee</a>
        </div>
        <div class="card-body pt-4 p-3">
            <div class="table-responsive">
                <table class="table table-bordered align-items-center mb-0">
                    <thead style="background-color: #3b5998; color: white;">
                        <tr>
                            <th class="text-uppercase text-sm px-4 py-3">ID</th>
                            <th class="text-uppercase text-sm px-4 py-3">Company Name</th>
                            <th class="text-uppercase text-sm px-4 py-3">Employee Name</th>
                            <th class="text-uppercase text-sm px-4 py-3">Email</th>
                            <th class="text-uppercase text-sm px-4 py-3">Mobile</th>
                            <th class="text-uppercase text-sm px-4 py-3">Employee ID</th>
                            <th class="text-uppercase text-sm px-4 py-3">Department</th>
                            <th class="text-uppercase text-sm px-4 py-3">Hotel Limit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr style="background-color: {{ $loop->even ? '#ffffff' : '#f8f9fa' }};">
                            <td class="px-4 py-3 text-sm">{{ $employee->id }}</td>
                            <td class="px-4 py-3 text-sm">{{ $employee->company_name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $employee->name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $employee->email }}</td>
                            <td class="px-4 py-3 text-sm">{{ $employee->mobile }}</td>
                            <td class="px-4 py-3 text-sm">{{ $employee->employee_id }}</td>
                            <td class="px-4 py-3 text-sm">{{ $employee->department }}</td>
                            <td class="px-4 py-3 text-sm">{{ $employee->limit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

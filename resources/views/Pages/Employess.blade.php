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

        .action-btn {
            margin-right: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
        }

        .btn-view {
            background-color: #4caf50;
            color: white;
        }

        .btn-edit {
            background-color: #2196f3;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
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
                                <th class="text-uppercase text-sm px-4 py-3">Sr. No.</th>
                                <th class="text-uppercase text-sm px-4 py-3">Employee ID</th>
                                @if(session('user_role') === 'admin')
                                <th class="text-uppercase text-sm px-4 py-3">Company Name</th>
                                @endif
                                <th class="text-uppercase text-sm px-4 py-3">Employee Name</th>
                                <th class="text-uppercase text-sm px-4 py-3">Email</th>
                                <th class="text-uppercase text-sm px-4 py-3">Mobile</th>

                                <th class="text-uppercase text-sm px-4 py-3">Department</th>
                                <th class="text-uppercase text-sm px-4 py-3">Hotel Limit</th>
                                <th class="text-uppercase text-sm px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr style="background-color: {{ $loop->even ? '#ffffff' : '#f8f9fa' }};">
                                    <td class="px-4 py-3 text-sm">{{ $employees->firstItem() + $loop->index }}</td>

                                    <td class="px-4 py-3 text-sm">{{ $employee->employee_id }}</td>
                                    @if(session('user_role') === 'admin')
                                    <td class="px-4 py-3 text-sm">{{ $employee->company_name }}</td>
                                    @endif
                                    <td class="px-4 py-3 text-sm">{{ $employee->name }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $employee->email }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $employee->mobile }}</td>

                                    <td class="px-4 py-3 text-sm">{{ $employee->department }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $employee->limit }}</td>
                                    <td class="px-4 py-3 text-sm d-flex">

                                   
                                            <a href="{{ route('employees.edit', $employee->id) }}"
                                                class="action-btn btn-edit">Edit</a>
                                            <form method="POST" action="{{ route('employees.destroy', $employee->id) }}"
                                                class="inline" onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn btn-delete">Delete</button>
                                            </form>
                   
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination Info + Links -->
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-4 flex-wrap">
                        <!-- Left Side: Showing X to Y of Z results -->
                        <div class="text-sm text-muted mb-2 mb-md-0">

                        </div>

                        <!-- Right Side: Pagination Buttons -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination rounded-pagination mb-0">
                                {{ $employees->links('pagination::bootstrap-5') }}
                            </ul>
                        </nav>
                    </div>
                </div>


            </div>

        </div>
        <script>

function confirmDelete() {
    return confirm('Are you sure you want to delete this employee.?');
}
</script>
    </div>


   
@endsection
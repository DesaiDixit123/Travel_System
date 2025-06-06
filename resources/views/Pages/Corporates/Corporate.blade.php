@extends('layouts.user_type.auth')

@section('content')

    <style>
        .rounded-pagination .page-link {
            border-radius: 50% !important;
            width: 40px;
            height: 40px;
            padding: 8px 0;
            text-align: center;
            line-height: 22px;
            margin: 0 4px;
            transition: 0.3s ease-in-out;
        }

        .rounded-pagination .page-item.active .page-link {
            background-color: #3b5998;
            border-color: #3b5998;
            color: white;
        }

        .rounded-pagination .page-link:hover {
            background-color: #3b5998;
            color: white;
            box-shadow: 0 2px 8px rgba(59, 89, 152, 0.3);
            transform: scale(1.05);
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px;
            /* only horizontal scrollbar */
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #e0e0e0;
            /* Light background for track */
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #3b5998;
            /* Blue color for scrollbar thumb */
            border-radius: 10px;
        }

        .btn-edit {
            background-color: #2196f3;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .action-btn {
            margin-right: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
        }
    </style>


    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Corporate Details</h6>
                <a href="{{ route('addCorporate.create') }}" class="btn add-btn"
                    style="background-color: #3b5998; color: white;">Add Corporate</a>

            </div>
            <div class="card-body pt-4 p-3">
                <div class="table-responsive">
                    <table class="table table-bordered align-items-center mb-0">
                        <thead style="background-color: #3b5998; color: white;">
                            <tr>
                                <th class="text-uppercase text-sm px-4 py-3">Sr. No.</th>

                                <th class="text-uppercase text-sm text-white px-4 py-3">Company Name</th>
                                <th class="text-uppercase text-sm text-white px-4 py-3">Contact Person</th>
                                <th class="text-uppercase text-sm text-white px-4 py-3">Designation</th>
                                <th class="text-uppercase text-sm text-white px-4 py-3">Contact Number</th>
                                <th class="text-uppercase text-sm text-white px-4 py-3">Email</th>
                                <th class="text-uppercase text-sm text-white px-4 py-3">Password</th>
                                <th class="text-uppercase text-sm text-white px-4 py-3">Address</th>
                                <th class="text-uppercase text-sm text-white px-4 py-3" style="display: none;">Department
                                </th>
                                <th class="text-uppercase text-sm px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($corporates as $corporate)
                                <tr style="background-color: {{ $loop->even ? '#ffffff' : '#f8f9fa' }};">
                                    <td class="px-4 py-3 text-sm">{{ $corporates->firstItem() + $loop->index }}</td>

                                    <td class="px-4 py-3 text-sm">{{ $corporate->company_name }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $corporate->contact_person }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $corporate->designation }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $corporate->contact_number }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $corporate->email }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $corporate->password }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $corporate->address }}</td>
                                    <td class="px-4 py-3 text-sm" style="display: none;">{{ $corporate->department }}</td>
                                    <td class="px-4 py-3 text-sm d-flex">


                                        <a href="{{ route('corporates.edit', $corporate->id) }}"
                                            class="action-btn btn-edit">Edit</a>
                                            <form method="POST" action="{{ route('corporates.destroy', $corporate->id) }}"
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
                                {{ $corporates->links('pagination::bootstrap-5') }}
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>

        <script>

function confirmDelete() {
    return confirm('Are you sure you want to delete this corporate.?');
}
</script>
    </div>

@endsection
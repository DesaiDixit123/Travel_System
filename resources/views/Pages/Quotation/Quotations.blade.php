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
    /* Button Styles */
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
   /* Pagination Styling */
.pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.pagination .page-item {
    margin: 0;
}

.pagination .page-link {
    color: #3b5998;
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 8px 12px;
    font-size: 14px;
    transition: background-color 0.3s, color 0.3s;
    cursor: pointer;
}

.pagination .page-link:hover {
    background-color: #3b5998;
    color: white;
}

.pagination .page-item.active .page-link {
    background-color: #3b5998;
    color: white;
    border-color: #3b5998;
}

.pagination .page-item.disabled .page-link {
    color: #ccc;
    pointer-events: none;
    background-color: #f8f9fa;
    border-color: #ddd;
}

</style>

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0 px-3 d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Quotations</h6>
            <!-- Add Quotation Button -->
            @if(session('user_role') === 'admin')
                <a href="{{ route('quotations.index') }}" class="btn add-btn">Add Quotation</a>
            @endif

            <form method="GET" action="{{ route('quotations.create') }}" class="flex items-center space-x-4">
                <!-- Search Input -->
                <input 
                    type="text" 
                    name="search_query" 
                    placeholder="Search Here..."
                    value="{{ request('search_query') }}" 
                    class="py-2 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64"
                >
                <!-- Search Button -->
                <button 
                    type="submit" 
                    class="text-white py-2 px-6 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" 
                    style="background-color: #3b5998; color: white;"
                >
                    Search
                </button>
            </form>

        </div>

        <div class="card-body pt-4 p-3">
            <div class="table-responsive">
                <table class="table table-bordered align-items-center mb-0">
                    <thead style="background-color: #3b5998; color: white;">
                        <tr>
                            <th class="text-uppercase text-sm px-4 py-3">ID</th>
                            <th class="text-uppercase text-sm px-4 py-3">Employee Id</th>
                            <th class="text-uppercase text-sm px-4 py-3">Employee Mobile No.</th>
                            <th class="text-uppercase text-sm px-4 py-3">Corporate Mobile No.</th>
                            <th class="text-uppercase text-sm px-4 py-3">Company Name</th>
                            <th class="text-uppercase text-sm px-4 py-3">Corporate Email</th>
                            <th class="text-uppercase text-sm px-4 py-3">Employee Email</th>
                            <th class="text-uppercase text-sm px-4 py-3">Department</th>
                            <th class="text-uppercase text-sm px-4 py-3">Hotel Limit</th>
                            <th class="text-uppercase text-sm px-4 py-3">Flight</th>
                            <th class="text-uppercase text-sm px-4 py-3">Other Expense</th>
                            <th class="text-uppercase text-sm px-4 py-3">Quotation</th>
                            @if(session('user_role') === 'admin')
                            <th class="text-uppercase text-sm px-4 py-3">Status</th>
                            @endif
                            <th class="text-uppercase text-sm px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotations as $quotation)
                        <tr style="background-color: {{ $loop->even ? '#ffffff' : '#f8f9fa' }};">
                            <td class="px-4 py-3 text-sm">{{ $quotation->id }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->employee_id }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->employee_mobile }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->corporate_mobile }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->company_name }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->corporate_email }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->employee_email }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->department }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->hotel_limit }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->flight }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->other_expenses }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->Quotation }}</td>
                            @if(session('user_role') === 'admin')
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $status = ucfirst(strtolower($quotation->status));
                                    $statusColor = '';
                                    if ($status == 'Pending') {
                                        $statusColor = 'background-color: #ff9800; color: white; padding: 5px 10px; border-radius: 5px;';
                                    } elseif ($status == 'Approved') {
                                        $statusColor = 'background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 5px;';
                                    } elseif ($status == 'Disapproved') {
                                        $statusColor = 'background-color: #f44336; color: white; padding: 5px 10px; border-radius: 5px;';
                                    }
                                @endphp
                                <span style="{{ $statusColor }}">{{ $status }}</span>
                            </td>
                            @endif
                            <td class="px-4 py-3 text-sm">
                                <a href="{{ route('quotations.show', $quotation->id) }}" class="action-btn btn-view">View</a>
                                @if(session('user_role') === 'admin')
                                <a href="{{ route('quotations.edit', $quotation->id) }}" class="action-btn btn-edit">Edit</a>
                                <form method="POST" action="{{ route('quotations.destroy', $quotation->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
<!-- Pagination Info + Links -->
<div class="d-flex justify-content-between align-items-center mt-4 mb-4 flex-wrap">
    <!-- Left Side: Showing X to Y of Z results -->
    <div class="text-sm text-muted mb-2 mb-md-0">
        <!-- You can dynamically show the number of results here -->
        Showing {{ $quotations->firstItem() }} to {{ $quotations->lastItem() }} of {{ $quotations->total() }} results
    </div>

    <!-- Right Side: Pagination Buttons -->
    <nav aria-label="Page navigation">
        <ul class="pagination mb-0">
            <!-- Previous Button -->
            <li class="page-item {{ $quotations->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $quotations->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <!-- Page Number Buttons -->
            @foreach ($quotations->getUrlRange(1, $quotations->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $quotations->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <!-- Next Button -->
            <li class="page-item {{ $quotations->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $quotations->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

            </div>

        </div>
    </div>
</div>

@endsection

@extends('layouts.user_type.auth')

@section('content')




    <link id="pagestyle" rel="stylesheet" href="../assets/css/soft-ui-dashboard.css?v=1.0.3">
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
            <div class="card-header pb-0 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Quotations</h6>
                <!-- Add Quotation Button -->
                @if(session('user_role') === 'admin')
                    <a href="{{ route('quotations.index') }}" class="btn add-btn">Add Quotation</a>
                @endif

                <form method="GET" action="{{ route('quotations.create') }}" class="row g-3 align-items-end mb-4">

                    <!-- Search Input -->
                    <div class="col-md-4">
                        <label for="search_query" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search_query" name="search_query"
                            placeholder="Search Here..." value="{{ request('search_query') }}">
                    </div>

                    <!-- From Date -->
                    <!-- From Date -->
                    <div class="col-md-3">
                        <label for="from_date" class="form-label">From</label>
                        <input type="date" class="form-control" id="from_date" name="from_date"
                            value="{{ \Carbon\Carbon::parse(request('from_date'))->format('Y-m-d') }}">
                    </div>

                    <!-- To Date -->
                    <div class="col-md-3">
                        <label for="to_date" class="form-label">To</label>
                        <input type="date" class="form-control" id="to_date" name="to_date"
                            value="{{ \Carbon\Carbon::parse(request('to_date'))->format('Y-m-d') }}">
                    </div>
                    <!-- Search Button -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Search
                        </button>
                    </div>
                </form>


            </div>

            <div class="card-body pt-4 p-3">
                <div class="table-responsive">
                    <table class="table table-bordered align-items-center mb-0">
                        <thead style="background-color: #3b5998; color: white;">
                            <tr>
                                <th class="text-uppercase text-sm px-4 py-3">Sr. No.</th>

                                <th class="text-uppercase text-sm px-4 py-3">Employee Id</th>
                                <th class="text-uppercase text-sm px-4 py-3">Employee Name</th>
                                <th class="text-uppercase text-sm px-4 py-3">Employee Mobile No.</th>
                                <th class="text-uppercase text-sm px-4 py-3" style="display: none;">Corporate Mobile No.
                                </th>
                                <th class="text-uppercase text-sm px-4 py-3" style="display: none;">Company Name</th>
                                <th class="text-uppercase text-sm px-4 py-3" style="display: none;">Corporate Email</th>
                                <th class="text-uppercase text-sm px-4 py-3" style="display: none;">Employee Email</th>
                                <th class="text-uppercase text-sm px-4 py-3" style="display: none;">Department</th>
                                <th class="text-uppercase text-sm px-4 py-3" style="display: none;">Hotel Limit</th>
                                <th class="text-uppercase text-sm px-4 py-3" style="display: none;">Flight</th>
                                <th class="text-uppercase text-sm px-4 py-3" style="display: none;">Other Expense</th>
                                <th class="text-uppercase text-sm px-4 py-3">Invoice Date</th>
                                <th class="text-uppercase text-sm px-4 py-3" style="display: none;">Quotation</th>
<th class="text-uppercase text-sm px-4 py-3">Travel Duration</th>
                                <th class="text-uppercase text-sm px-4 py-3">Bill No.</th>
                                <th class="text-uppercase text-sm px-4 py-3">From To</th>
                                <th class="text-uppercase text-sm px-4 py-3">Amount</th>
                                <th class="text-uppercase text-sm px-4 py-3">Include</th>
                                <th class="text-uppercase text-sm px-4 py-3">Status</th>

                                <th class="text-uppercase text-sm px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotations as $quotation)
                                <tr style="background-color: {{ $loop->even ? '#ffffff' : '#f8f9fa' }};">
                                    <td class="px-4 py-3 text-sm">{{ $quotations->firstItem() + $loop->index }}</td>

                                    <td class="px-4 py-3 text-sm">
                                        @foreach (explode(',', $quotation->employee_id) as $id)
                                            {{ trim($id) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        @foreach (explode(',', $quotation->employee_name) as $name)
                                            {{ trim($name) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        @foreach (explode(',', $quotation->employee_mobile) as $mobile)
                                            {{ trim($mobile) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm" style="display: none;">
                                        @foreach (explode(',', $quotation->corporate_mobile) as $cmobile)
                                            {{ trim($cmobile) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm" style="display: none;">
                                        @foreach (explode(',', $quotation->company_name) as $company)
                                            {{ trim($company) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm" style="display: none;">
                                        @foreach (explode(',', $quotation->corporate_email) as $cemail)
                                            {{ trim($cemail) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm" style="display: none;">
                                        @foreach (explode(',', $quotation->employee_email) as $eemail)
                                            {{ trim($eemail) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm" style="display: none;">
                                        @foreach (explode(',', $quotation->department) as $dept)
                                            {{ trim($dept) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm" style="display: none;">
                                        @foreach (explode(',', $quotation->hotel_limit) as $limit)
                                            {{ trim($limit) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm" style="display: none;">
                                        @foreach (explode(',', $quotation->flight) as $flight)
                                            {{ trim($flight) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm" style="display: none;">
                                        @foreach (explode(',', $quotation->other_expenses) as $exp)
                                            {{ trim($exp) }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        {{ \Carbon\Carbon::parse($quotation->invoice_date)->format('Y-m-d') }}
                                    </td>

                                    <td class="px-4 py-3 text-sm" style="display: none;">
                                        @foreach (explode(',', $quotation->Quotation) as $quote)
                                            {{ trim($quote) }}<br>
                                        @endforeach
                                    </td>
 <td class="px-4 py-3 text-sm">
    {{ \Carbon\Carbon::parse($quotation->travel_from)->format('Y-m-d') }} To {{ \Carbon\Carbon::parse($quotation->travel_to)->format('Y-m-d') }}
</td>
                                    <td class="px-4 py-3 text-sm">{{ $quotation->bill_no }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $quotation->from_to }}</td>
                                    <td class="px-4 py-3 text-sm">{{ $quotation->amount }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @foreach (json_decode($quotation->include) as $item)
                                            {{ $item }}<br>
                                        @endforeach
                                    </td>

                                    <td class="px-4 py-3 text-sm">
                                        @php
                                            $status = ucfirst(strtolower($quotation->status));
                                            $statusColor = match ($status) {
                                                'Pending' => 'background-color: #ff9800; color: white; padding: 5px 10px; border-radius: 5px;',
                                                'Approved' => 'background-color: #4caf50; color: white; padding: 5px 10px; border-radius: 5px;',
                                                'Disapproved' => 'background-color: #f44336; color: white; padding: 5px 10px; border-radius: 5px;',
                                                default => '',
                                            };
                                        @endphp
                                        <span style="{{ $statusColor }}">{{ $status }}</span>
                                    </td>
<td class="px-4 py-3 text-sm d-flex gap-2">
    <a href="{{ route('quotations.show', $quotation->id) }}" class="action-btn btn-view">View</a>

    @if(session('user_role') === 'admin')
        <a href="{{ route('quotations.edit', $quotation->id) }}" class="action-btn btn-edit">Edit</a>

        <form method="POST" action="{{ route('quotations.destroy', $quotation->id) }}" class="inline" onsubmit="return confirmDelete()">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn btn-delete">Delete</button>
        </form>

        <!-- Upload Button (opens modal) -->
        <button type="button" class="action-btn btn-upload btn-warning" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $quotation->id }}">
            Upload
        </button>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="uploadModal{{ $quotation->id }}" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('quotations.upload', $quotation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload Screenshot</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Please upload your email screenshot pic:</p>
                        <input type="file" name="email_screenshot" class="form-control" required accept="image/*">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</td>

                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-4 mb-4 flex-wrap">
                        <!-- Left Side: Showing X to Y of Z results -->
                        <div class="text-sm text-muted mb-2 mb-md-0">
                            <!-- Dynamically showing the number of results here -->
                            Showing {{ $quotations->firstItem() }} to {{ $quotations->lastItem() }} of
                            {{ $quotations->total() }} results
                        </div>

                        <!-- Right Side: Pagination Buttons -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                <!-- Previous Button -->
                                <li class="page-item {{ $quotations->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link"
                                        href="{{ $quotations->previousPageUrl() . (request('search_query') ? '&search_query=' . request('search_query') : '') . (request('quotation_date') ? '&quotation_date=' . request('quotation_date') : '') }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>

                                <!-- Page Number Buttons -->
                                @foreach ($quotations->getUrlRange(1, $quotations->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $quotations->currentPage() ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $url . (request('search_query') ? '&search_query=' . request('search_query') : '') . (request('quotation_date') ? '&quotation_date=' . request('quotation_date') : '') }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next Button -->
                                <li class="page-item {{ $quotations->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link"
                                        href="{{ $quotations->nextPageUrl() . (request('search_query') ? '&search_query=' . request('search_query') : '') . (request('quotation_date') ? '&quotation_date=' . request('quotation_date') : '') }}"
                                        aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
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


    <script>
        const dateInput = document.getElementById('quotationDate');
        const form = document.getElementById('filterForm');

        // When user selects date or pastes date
        dateInput.addEventListener('change', () => {
            form.submit(); // Auto submit the form
        });

        // Also catch paste event (optional, for immediate paste-detection)
        dateInput.addEventListener('paste', function () {
            setTimeout(() => form.submit(), 100); // Wait a bit before submitting
        });



        function confirmDelete() {
            return confirm('Are you sure you want to delete this quotation.?');
        }
    </script>

@endsection
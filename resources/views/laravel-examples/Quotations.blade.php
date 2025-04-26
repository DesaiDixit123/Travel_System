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
            <h6 class="mb-0">Quotations</h6>
            <!-- Add Employee Button -->
            <a href="{{ route('quotations.index') }}" class="btn add-btn">Add Quotation</a>
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
                            <th class="text-uppercase text-sm px-4 py-3">Email</th>
        
                            <th class="text-uppercase text-sm px-4 py-3">Department</th>
                            <th class="text-uppercase text-sm px-4 py-3">Hotel Limit</th>
                            <th class="text-uppercase text-sm px-4 py-3">Flight</th>
                            <th class="text-uppercase text-sm px-4 py-3">Other Expence</th>
                            <th class="text-uppercase text-sm px-4 py-3">Quotation</th>
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
                            <td class="px-4 py-3 text-sm">{{ $quotation->department }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->hotel_limit }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->flight }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->other_expenses }}</td>
                            <td class="px-4 py-3 text-sm">{{ $quotation->Quotation }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

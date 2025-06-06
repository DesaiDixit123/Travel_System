@extends('layouts.user_type.auth')

@section('content')

<link id="pagestyle" rel="stylesheet" href="../assets/css/soft-ui-dashboard.css?v=1.0.3">
    <div class="container py-4">
        <h2>Quotation Details</h2>


        {{-- Email Screenshot --}}
        @if($quotation->email_screenshot)
            <p><strong>Email Screenshot:</strong></p>
            <a href="{{ asset('storage/screenshots/' . $quotation->email_screenshot) }}" target="_blank">
                <img src="{{ asset('storage/screenshots/' . $quotation->email_screenshot) }}" alt="Screenshot"
                    class="img-fluid rounded border" style="max-width: 300px;">
            </a>
        @else
            <p><strong>Email Screenshot:</strong> Not uploaded yet.</p>
        @endif
        @php
            $employeeIds = explode(',', $quotation->employee_id);
        @endphp
        <p><strong>Employee ID:</strong></p>
        <ul>
            @foreach($employeeIds as $id)
                <li>{{ trim($id) }}</li>
            @endforeach
        </ul>
        @php
            $comapnyname = explode(',', $quotation->company_name);
        @endphp
        <p><strong>Company Name:</strong>
        <ul>
            @foreach($comapnyname as $companyName)
                <li>{{ trim($companyName) }}</li>
            @endforeach
        </ul>
        </p>
        @php
            $corporatemobile = explode(',', $quotation->corporate_mobile);
        @endphp
        <p><strong>Corporate Mobile:</strong>
        <ul>
            @foreach($corporatemobile as $corporatemobiles)
                <li>{{ trim($corporatemobiles) }}</li>
            @endforeach
        </ul>
        </p>
        <p><strong>Invoice Date:</strong> {{ $quotation->invoice_date }}</p>
        <p><strong>Travel Duration:</strong> {{ $quotation->travel_from }} To {{ $quotation->travel_to }}</p>
        <p><strong>Bill Number:</strong> {{ $quotation->bill_no }}</p>
        <p><strong>From To:</strong> {{ $quotation->from_to }}</p>
        <p><strong>Amount:</strong> {{ $quotation->amount }}</p>

        {{-- Include Items --}}
        <p><strong>Include:</strong></p>
        @php
            $includes = json_decode($quotation->include, true);
        @endphp

        @if(!empty($includes))
            <ul>
                @foreach($includes as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @else
            <p>No items included.</p>
        @endif



        {{-- Show STATUS only for Admin --}}
        @if(session('user_role') === 'admin')
            <p><strong>Status:</strong>
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
            </p>
        @endif

        {{-- Show BUTTONS only for Corporate --}}
        @if(session('user_role') === 'corporate')
            @if (strtolower($quotation->status) == 'pending')
                <form action="{{ route('quotations.approve', $quotation->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success mt-2">Approve</button>
                </form>
                <form action="{{ route('quotations.disapprove', $quotation->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger mt-2">Disapprove</button>
                </form>
            @endif
        @endif

        <a href="{{ route('quotations.create') }}" class="btn btn-secondary mt-3">Back</a>
    </div>

@endsection
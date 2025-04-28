@extends('layouts.user_type.auth')

@section('content')

<div class="container py-4">
    <h2>Quotation Details</h2>
    <p><strong>Employee ID:</strong> {{ $quotation->employee_id }}</p>
    <p><strong>Company Name:</strong> {{ $quotation->company_name }}</p>
    <p><strong>Flight:</strong> {{ $quotation->flight }}</p>
    <p><strong>Other Expenses:</strong> {{ $quotation->other_expenses }}</p>
                            <p><strong>Quotation:</strong> {{ $quotation->quotation }}</p>

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

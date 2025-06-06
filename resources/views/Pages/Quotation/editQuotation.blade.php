@extends('layouts.user_type.auth')

@section('content')

<!-- Import Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Quotation</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('quotations.update', $quotation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="invoice_date" class="form-label">Invoice Date</label>
                            <input type="date" name="invoice_date" id="invoice_date" class="form-control" value="{{ $quotation->invoice_date }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="travel_from" class="form-label">Travel From</label>
                            <input type="text" name="travel_from" id="travel_from" class="form-control" value="{{ $quotation->travel_from }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="travel_to" class="form-label">Travel To</label>
                            <input type="text" name="travel_to" id="travel_to" class="form-control" value="{{ $quotation->travel_to }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="bill_no" class="form-label">Bill No</label>
                            <input type="text" name="bill_no" id="bill_no" class="form-control" value="{{ $quotation->bill_no }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="from_to" class="form-label">From-To</label>
                            <input type="text" name="from_to" id="from_to" class="form-control" value="{{ $quotation->from_to }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" value="{{ $quotation->amount }}" required>
                        </div>

                  <div class="mb-3">
    <label class="form-label">Include</label>
    <div class="d-flex flex-wrap gap-3">
        @php
            $selectedIncludes = json_decode($quotation->include, true) ?? [];
            $options = ['Flight', 'Train', 'Hotel'];
        @endphp
        @foreach($options as $option)
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="include[]"
                    value="{{ $option }}"
                    id="include_{{ $option }}"
                    {{ in_array($option, $selectedIncludes) ? 'checked' : '' }}
                >
                <label class="form-check-label" for="include_{{ $option }}">
                    {{ $option }}
                </label>
            </div>
        @endforeach
    </div>
</div>


                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

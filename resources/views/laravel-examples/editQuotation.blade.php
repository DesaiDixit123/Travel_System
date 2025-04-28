@extends('layouts.user_type.auth')

@section('content')

<!-- Import Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Quotation</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('quotations.update', $quotation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="flight" class="form-label">Flight</label>
                            <input type="text" name="flight" id="flight" class="form-control" value="{{ $quotation->flight }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="other_expenses" class="form-label">Other Expenses</label>
                            <input type="text" name="other_expenses" id="other_expenses" class="form-control" value="{{ $quotation->other_expenses }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="Quotation" class="form-label">Quotation</label>
                            <input type="text" name="Quotation" id="Quotation" class="form-control" value="{{ $quotation->Quotation }}" required>
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

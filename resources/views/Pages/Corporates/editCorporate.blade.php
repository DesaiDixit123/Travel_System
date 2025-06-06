@extends('layouts.user_type.auth')

@section('content')

<!-- Import Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Corporate</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('corporates.update', $corporate->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" name="company_name" id="company_name" class="form-control" value="{{ $corporate->company_name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_person" class="form-label">Contact Person</label>
                            <input type="text" name="contact_person" id="contact_person" class="form-control" value="{{ $corporate->contact_person }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" name="designation" id="designation" class="form-control" value="{{ $corporate->designation }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" id="contact_number" class="form-control" value="{{ $corporate->contact_number }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $corporate->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control" required>{{ $corporate->address }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('corporates.index') }}" class="btn btn-secondary">Back</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.user_type.guest')

@section('content')

  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" >
      <span class="mask  opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
         
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Signup with Corporate</h5>
            </div>
            
            <div class="card-body">
            <form role="form text-left" method="POST" action="/register">
  @csrf

  
  <div class="mb-3">
    <input type="text" class="form-control" placeholder="Company Name" name="company_name" id="company_name" aria-label="Company Name" aria-describedby="company_name" value="{{ old('company_name') }}">
    @error('company_name')
      <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
  </div>
  
  <div class="mb-3">
    <input type="text" class="form-control" placeholder="Contact Person" name="contact_person" id="contact_person" aria-label="Contact Person" aria-describedby="contact_person" value="{{ old('contact_person') }}">
    @error('contact_person')
      <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
  </div>
  
  <div class="mb-3">
    <input type="text" class="form-control" placeholder="Designation" name="designation" id="designation" aria-label="Designation" aria-describedby="designation" value="{{ old('designation') }}">
    @error('designation')
      <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
  </div>
  
  <div class="mb-3">
    <input type="text" class="form-control" placeholder="Contact Number (WhatsApp)" name="contact_number" id="contact_number" aria-label="Contact Number (WhatsApp)" aria-describedby="contact_number" value="{{ old('contact_number') }}">
    @error('contact_number')
      <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
  </div>
  
  <div class="mb-3">
    <input type="email" class="form-control" placeholder="Email ID" name="email" id="email" aria-label="Email ID" aria-describedby="email-addon" value="{{ old('email') }}">
    @error('email')
      <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
  </div>
  
  <div class="mb-3">
    <textarea class="form-control" placeholder="Address" name="address" id="address" aria-label="Address" aria-describedby="address-addon">{{ old('address') }}</textarea>
    @error('address')
      <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
  </div>

  <div class="mb-3" style="display: none;">
    <select class="form-control" name="department" id="department">
      <option value="">Select Department</option>
      <option value="sales" {{ old('department') == 'sales' ? 'selected' : '' }}>Sales</option>
      <option value="marketing" {{ old('department') == 'marketing' ? 'selected' : '' }}>Marketing</option>
      <option value="hr" {{ old('department') == 'hr' ? 'selected' : '' }}>HR</option>
      <!-- Add more options as needed -->
    </select>
    @error('department')
      <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
  </div>

  <div class="mb-3">
    <input type="password" class="form-control" placeholder="Password" name="password" id="password" aria-label="Password" aria-describedby="password-addon">
    @error('password')
      <p class="text-danger text-xs mt-2">{{ $message }}</p>
    @enderror
  </div>
  
  <div class="form-check form-check-info text-left">
    <input class="form-check-input" type="checkbox" name="agreement" id="flexCheckDefault" checked>
    <label class="form-check-label" for="flexCheckDefault">
      I agree to the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
    </label>
    @error('agreement')
      <p class="text-danger text-xs mt-2">First, agree to the Terms and Conditions, then try registering again.</p>
    @enderror
  </div>
  
  <div class="text-center">
    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
  </div>
  
  <p class="text-sm mt-3 mb-0">Already have an account? <a href="login" class="text-dark font-weight-bolder">Sign in</a></p>
</form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection


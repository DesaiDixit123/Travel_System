@extends('layouts.user_type.guest')

@section('content')

<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient"> Login</h3>
                                <!-- <p class="mb-0">Login with your credentials</p> -->
                            </div>
                            <div class="card-body">
                            <form action="{{ route('login.store') }}" method="POST">
    @csrf
    <label>Email</label>
    <div class="mb-3">
        <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
        @error('email')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

    <label>Password</label>
    <div class="mb-3">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
        @error('password')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
        @enderror
    </div>

   
    <div class="text-center">
        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
    </div>
</form>

                            </div>
                        
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

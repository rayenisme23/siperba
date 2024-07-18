@extends('layouts.guest')
@section('title')
    Forget Password
@endsection
@section('content')
    <div class="section-authentication-cover">
        <div class="">
            <div class="row g-0">
                <div
                    class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end bg-transparent">

                    <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent bg-none">
                        <div class="card-body">
                            <img src="{{ URL::asset('build/images/auth/forgot-password1.png') }}"
                                class="img-fluid auth-img-cover-login" width="550" alt="">
                        </div>
                    </div>

                </div>

                <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                    <div class="card rounded-0 m-3 mb-0 border-0 shadow-none bg-none">
                        <div class="card-body p-5">
                            <div class="d-flex align-items-center ms-4 mb-5">
                                <img src="{{ URL::asset('build/images/logo-indoneptune.png') }}" class="mb-2" width="100"
                                    alt="">
                                <h4 class="fw-bold text-uppercase ms-2">pt. indoneptune net</h4>
                            </div>
                            <p class="mt-2 fs-6 fw-semibold">Kami menerima permintaan setel ulang password. Silakan masukkan email Anda!</p>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="form-body mt-3">
                                <form method="POST" action="{{ route('password.email') }}" class="row g-3">
                                    @csrf

                                    <div class="col-12">
                                        <label class="form-label" for="email">Email <span
                                                class="text-danger">*</span></label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus
                                            placeholder="Masukkan email anda">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
                                            <a href="{{ route('login') }}" class="btn btn-secondary">Kembali ke Login</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

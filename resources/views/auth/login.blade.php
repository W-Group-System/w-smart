@extends('layouts.login_header')

@section('content')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center justify-content-center auth auth-img-bg">
            <div class="row flex-grow d-flex align-items-center justify-content-center">
                <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center">
                    <img src="{{ asset('images/p37RCvd.png') }}" alt="Login Illustration" class="img-fluid" style="max-width: 80%;">
                </div>

                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <div class="auth-form-transparent text-left p-4" style="width: 100%; max-width: 400px;">
                        <div class="brand-logo text-center">
                            <img src="{{ asset('images/logo.png') }}" alt="logo" style="max-width: 150px;">
                        </div>

                        <h4 class="text-left" style="font-size: 24px; font-weight: bold;">Sign In to</h4>
                        <h6 class="font-weight-light text-left" style="font-size: 16px; color: #6c757d;">W Smart</h6>

                        <!-- Display the error message if login fails -->
                        @if ($errors->has('email'))
                            <div class="alert alert-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif

                        <form class="pt-3" method="POST" action="{{ route('login') }}">
                            @csrf <!-- Include CSRF token for security -->
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" name="email" required
                                    class="form-control form-control-lg" value="{{ old('email') }}">
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" required
                                    class="form-control form-control-lg">
                            </div>

                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check ms-4">
                                    <input type="checkbox" name="remember" class="form-check-input" id="rememberMe" style="accent-color: #007AFF;">
                                    <label class="form-check-label ms-2" for="rememberMe" style="color: #6c757d ;">
                                        Remember me
                                    </label>
                                </div>
                                <a href="#" class="auth-link" style="color: #6c757d;">Forgot Password</a>
                            </div>

                            <div class="my-3">
                                <button type="submit" class="btn btn-lg font-weight-medium auth-form-btn"
                                    style="background-color: #1737B2; color: white; width: 100%;">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
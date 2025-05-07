@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="text-primary fw-bold">{{ __('Đăng Nhập') }}</h2>
                        <p class="text-muted">Chào mừng bạn đến với Cinnamon Shop</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="Nhập email của bạn">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('Mật khẩu') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="current-password"
                                    placeholder="Nhập mật khẩu của bạn">
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    {{ __('Ghi nhớ đăng nhập') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                {{ __('Đăng Nhập') }}
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    {{ __('Quên mật khẩu?') }}
                                </a>
                            @endif
                        </div>

                        <div class="text-center mt-3">
                            <span class="text-muted">{{ __('Bạn chưa có tài khoản?') }}</span>
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #8B4513;">
                                {{ __('Đăng ký ngay!') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        border-radius: 15px;
    }
    .btn-primary {
        background-color: #8B4513;
        border-color: #8B4513;
    }
    .btn-primary:hover {
        background-color: #654321;
        border-color: #654321;
    }
    .text-primary {
        color: #8B4513 !important;
    }
    .input-group-text {
        border: none;
    }
    .form-control {
        border: 1px solid #dee2e6;
    }
    .form-control:focus {
        border-color: #8B4513;
        box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
    }
</style>
@endpush
@endsection

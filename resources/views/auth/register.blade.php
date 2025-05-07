@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-cinnamon text-white text-center py-3">
                    <h4 class="mb-0">{{ __('Đăng Ký Tài Khoản') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">{{ __('Họ và tên') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                    placeholder="Nhập họ và tên của bạn">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" value="{{ old('email') }}" required autocomplete="email"
                                    placeholder="Nhập địa chỉ email của bạn">
                                @error('email')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label">{{ __('Số điện thoại') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                    name="phone" value="{{ old('phone') }}" required
                                    placeholder="Nhập số điện thoại của bạn">
                                @error('phone')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">{{ __('Mật khẩu') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                    name="password" required autocomplete="new-password"
                                    placeholder="Nhập mật khẩu">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">{{ __('Xác nhận mật khẩu') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input id="password-confirm" type="password" class="form-control" 
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Nhập lại mật khẩu">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-cinnamon btn-lg">
                                <i class="fas fa-user-plus me-2"></i>{{ __('Đăng Ký') }}
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="mb-0">Đã có tài khoản? <a href="{{ route('login') }}" class="text-cinnamon">Đăng nhập</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-cinnamon {
    background-color: #8B4513;
}
.btn-cinnamon {
    background-color: #8B4513;
    color: white;
    border: none;
}
.btn-cinnamon:hover {
    background-color: #6B3410;
    color: white;
}
.text-cinnamon {
    color: #8B4513;
}
.card {
    border-radius: 15px;
}
.input-group-text {
    background-color: #f8f9fa;
}
.form-control:focus {
    border-color: #8B4513;
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
}
</style>

<script>
// Thêm validation cho form
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>
@endsection

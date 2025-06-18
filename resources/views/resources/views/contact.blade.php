@extends('layouts.app')

@section('content')
<style>
    .contact-us {
        background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%);
        padding: 60px 40px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        margin: 40px auto;
        max-width: 1200px;
    }

    .page-title {
        color: #fff;
        font-size: 2.8rem;
        text-align: center;
        margin-bottom: 40px;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        font-weight: 700;
    }

    .contact-us__form {
        background: rgba(255, 255, 255, 0.98);
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        transition: transform 0.3s ease;
    }

    .contact-us__form:hover {
        transform: translateY(-5px);
    }

    .contact-us__form h3 {
        color: #1a237e;
        font-size: 2rem;
        margin-bottom: 30px;
        text-align: center;
        font-weight: 700;
        position: relative;
        padding-bottom: 15px;
    }

    .contact-us__form h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(45deg, #ff5722, #ff7043);
        border-radius: 2px;
    }

    .form-floating {
        margin-bottom: 25px;
        position: relative;
    }

    .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        padding: 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
        height: auto;
        margin-bottom: 5px;
    }

    .form-control:focus {
        border-color: #ff5722;
        box-shadow: 0 0 0 0.2rem rgba(255, 87, 34, 0.15);
    }

    .form-floating label {
        color: #666;
        padding: 15px;
        font-size: 1rem;
        pointer-events: none;
    }

    .form-floating>.form-control:focus~label,
    .form-floating>.form-control:not(:placeholder-shown)~label {
        transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        color: #ff5722;
        background: #fff;
        padding: 0 6px;
        z-index: 2;
        left: 8px;
        top: 2px;
        position: absolute;
        pointer-events: none;
    }

    .text-danger {
        color: #d32f2f !important;
        font-size: 0.9rem;
        margin-top: 5px;
        display: block;
        font-weight: 500;
        position: relative;
        padding-left: 5px;
    }

    textarea.form-control {
        min-height: 180px;
        resize: vertical;
        padding: 15px;
        margin-bottom: 5px;
    }

    .btn-primary {
        background: linear-gradient(45deg, #ff5722, #ff7043);
        border: none;
        padding: 15px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 8px;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        display: block;
    }

    .btn-primary:hover {
        background: linear-gradient(45deg, #f4511e, #ff5722);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 87, 34, 0.4);
    }

    .alert-success {
        background-color: #e8f5e9;
        border-color: #c8e6c9;
        color: #2e7d32;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-size: 1.1rem;
        text-align: center;
    }

    /* Tablet */
    @media (max-width: 991px) {
        .contact-us {
            padding: 40px 30px;
            margin: 30px 20px;
        }
        
        .page-title {
            font-size: 2.4rem;
        }

        .contact-us__form {
            padding: 30px;
        }

        .contact-us__form h3 {
            font-size: 1.8rem;
        }

        .form-floating {
            margin-bottom: 20px;
        }
    }

    /* Mobile */
    @media (max-width: 767px) {
        .contact-us {
            padding: 25px 15px;
            margin: 20px 10px;
            border-radius: 15px;
        }
        
        .page-title {
            font-size: 1.8rem;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .contact-us__form {
            padding: 20px;
        }

        .contact-us__form h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .form-floating {
            margin-bottom: 15px;
        }

        .form-control {
            padding: 12px;
            font-size: 0.95rem;
            margin-bottom: 3px;
        }

        .form-floating label {
            padding: 12px;
            font-size: 0.95rem;
        }

        .text-danger {
            font-size: 0.85rem;
            margin-top: 3px;
        }

        .btn-primary {
            padding: 12px 25px;
            font-size: 1rem;
            max-width: 100%;
        }

        textarea.form-control {
            min-height: 150px;
        }

        .alert-success {
            padding: 15px;
            font-size: 1rem;
        }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
        .contact-us {
            padding: 20px 10px;
            margin: 15px 5px;
        }
        
        .page-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .contact-us__form {
            padding: 15px;
        }

        .contact-us__form h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }

        .form-floating {
            margin-bottom: 12px;
        }

        .form-control {
            padding: 10px;
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .form-floating label {
            padding: 10px;
            font-size: 0.9rem;
        }

        .text-danger {
            font-size: 0.8rem;
            margin-top: 2px;
        }
    }
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">LIÊN HỆ CHÚNG TÔI</h2>
      </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
          <form name="contact-us-form" class="needs-validation" novalidate="" action="{{ route('home.contact.store') }}" method="POST">
            @csrf
            <h3 class="mb-5">Liên Hệ Với Chúng Tôi</h3>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="name" placeholder="Họ và tên *" required="" value="{{ old('name') }}">
              <label for="contact_us_name">Họ và tên *</label>
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-floating my-4">
              <input type="text" class="form-control" name="phone" placeholder="Số điện thoại *" required="" value="{{ old('phone') }}">
              <label for="contact_us_name">Số điện thoại *</label>
              @error('phone')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="form-floating my-4">
              <input type="email" class="form-control" name="email" placeholder="Địa chỉ email *" required="" value="{{ old('email') }}">
              <label for="contact_us_name">Địa chỉ email *</label>
              @error('email')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="my-4">
              <textarea class="form-control form-control_gray" name="comment" placeholder="Nội dung tin nhắn" cols="30"
                rows="8" required="">{{ old('comment') }}</textarea>
              @error('comment')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="my-4">
              <button type="submit" class="btn btn-primary">Gửi</button>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
@endsection
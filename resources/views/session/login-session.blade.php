@extends('layouts.user_type.guest')

@section('content')

<style>
    /* Reset */
    html, body {
        margin: 0;
        padding: 0;
        min-height: 100%;
        overflow-x: hidden;
    }

    /* Layout utama */
    .erocs-login {
        display: flex;
        width: 100%;
        min-height: 100vh;
        background: #f5f6fa;
    }

    /* Sisi kiri */
    .erocs-login-left {
        width: 50%;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px 40px;
        background: #f5f6fa;
        box-sizing: border-box;
    }

    .erocs-login-content {
        width: 100%;
        max-width: 449px;
    }

    /* Heading */
    .erocs-login-content h3 {
        font-size: 29px;
        font-weight: 400;
        color: #222;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .erocs-login-content h3 strong {
        font-weight: 700;
        color: #237227;
    }

    .erocs-description {
        font-size: 16px;
        line-height: 1.6;
        color: #b0b0b0;
        margin-bottom: 28px;
    }

    /* Form */
    .erocs-form-group {
        margin-bottom: 19px;
    }

    .erocs-form-group label {
        display: block;
        color: #222;
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .erocs-input {
        display: block;
        width: 100%;
        height: 59px;
        padding: 12px;
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        color: #555;
        font-size: 16px;
        box-sizing: border-box;
        transition: 0.3s ease;
    }

    .erocs-input:focus {
        outline: none;
        border-color: #237227;
        box-shadow: 0 0 0 3px rgba(35, 114, 39, 0.1);
    }

    .erocs-input::placeholder {
        color: #777;
    }

    /* Button */
    .erocs-btn-login {
        display: block;
        width: 100%;
        height: 59px;
        background: #237227;
        border: none;
        border-radius: 5px;
        color: #fff;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .erocs-btn-login:hover {
        background: #1b5a1f;
        box-shadow: 0 5px 15px rgba(35, 114, 39, 0.2);
    }

    /* Error validation */
    .erocs-error {
        display: block;
        color: #dc3545;
        font-size: 12px;
        margin-top: 6px;
    }

    /* Footer */
    .erocs-footer {
        text-align: center;
        margin-top: 65px;
    }

    .erocs-footer p {
        color: #aaa;
        font-size: 12px;
        margin-bottom: 5px;
    }

    /* Slideshow kanan */
  .erocs-login-right {
      width: 50%;
      min-height: 100vh;
      position: relative;
      overflow: hidden;
      background: #eee;
  }

  .erocs-slide {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1.5s ease-in-out;
  }

  .erocs-slide.active {
      opacity: 1;
  }

    /* Responsive tablet dan mobile */
    @media (max-width: 991px) {
        .erocs-login {
            flex-direction: column;
        }

        .erocs-login-left {
            width: 100%;
            min-height: 100vh;
            padding: 45px 30px;
            order: 2;
        }

        .erocs-login-right {
            width: 100%;
            min-height: 280px;
            height: 280px;
            order: 1;
        }

        .erocs-login-content {
            max-width: 500px;
        }

        .erocs-footer {
            margin-top: 45px;
        }
    }

    @media (max-width: 576px) {
        .erocs-login-right {
            min-height: 210px;
            height: 210px;
        }

        .erocs-login-left {
            padding: 40px 25px;
        }

        .erocs-login-content h3 {
            font-size: 25px;
        }

        .erocs-description {
            font-size: 14px;
        }
    }
</style>

<main class="erocs-login">

    {{-- BAGIAN KIRI: FORM LOGIN --}}
    <div class="erocs-login-left">

        <div class="erocs-login-content">

            <h3>
                Login to <strong>E-ROCS</strong>
            </h3>

            <p class="erocs-description">
                Environment Reporting & Compliance System
            </p>

            <form role="form" method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="erocs-form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="erocs-input"
                        placeholder="your-email@gmail.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >

                    @error('email')
                        <span class="erocs-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                {{-- Password --}}
                <div class="erocs-form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="erocs-input"
                        placeholder="Your Password"
                        required
                        autocomplete="current-password"
                    >

                    @error('password')
                        <span class="erocs-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

                {{-- Login Button --}}
                <button type="submit" class="erocs-btn-login">
                    Log In
                </button>

            </form>

            {{-- Footer --}}
            <div class="erocs-footer">

                <p>
                    &copy; {{ date('Y') }} PT Nusa Karya Arindo
                </p>

                <p>
                    Site Moronopo
                </p>

            </div>

        </div>

    </div>

    {{-- BAGIAN KANAN: BACKGROUND IMAGE --}}
    <div class="erocs-login-right">

      <img
          src="{{ asset('assets/img/slide-show/foto1.png') }}"
          class="erocs-slide active"
          alt="Dokumentasi perusahaan 1"
      >
S
      <img
          src="{{ asset('assets/img/slide-show/foto2.png') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 2"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto3.jpeg') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 3"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto4.jpeg') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 4"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto5.png') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 5"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto6.png') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 6"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto8.jpg') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 8"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto10.jpeg') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 10"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto12.jpeg') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 12"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto13.jpeg') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 13"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto15.png') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 15"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto16.png') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 16"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto17.jpeg') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 17"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto18.jpeg') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 18"
      >

      <img
          src="{{ asset('assets/img/slide-show/foto19.jpeg') }}"
          class="erocs-slide"
          alt="Dokumentasi perusahaan 19"
      >

  </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const slides = document.querySelectorAll('.erocs-slide');

        let currentSlide = 0;

        function showNextSlide() {

            slides[currentSlide].classList.remove('active');

            currentSlide = (currentSlide + 1) % slides.length;

            slides[currentSlide].classList.add('active');

        }

        // Berganti setiap 5 detik
        setInterval(showNextSlide, 5000);

    });
</script>

@endsection
@extends('layouts.user_type.guest')

@section('content')

<style>
  /* Reset dasar untuk memastikan tinggi penuh */
  html, body {
    height: 100%;
    margin: 0;
    overflow-x: hidden; 
  }

  /* Wrapper utama agar konten berada di tengah vertikal */
  .login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }

  /* Styling untuk sisi Gambar */
  .login-image-side {
    /* Ganti contain menjadi cover agar gambar memenuhi area tanpa ruang kosong putih */
    /* Jika Anda wajib menggunakan 'contain', kembalikan ke contain, tapi 'cover' biasanya lebih estetik */
    background-image: url('{{ asset('assets/img/curved-images/HalamanLogin.jpg') }}');
    background-size: cover; 
    background-position: center;
    background-repeat: no-repeat;
    width: 100%;
    height: 100%;
    min-height: 100vh;
    position: relative;
  }
  
  /* Overlay gelap tipis di atas gambar agar teks (jika ada) terbaca, atau sekadar estetika */
  .login-image-side::before {
    content: "";
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.4) 100%);
  }

  /* Styling Form Container */
  .login-form-container {
    background: #ffffff;
    padding: 3rem 2rem;
    border-radius: 1rem;
    /* Shadow halus khas modern UI */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); 
    width: 100%;
    max-width: 450px;
    margin: auto;
  }

  /* Input Styling */
  .form-control {
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    border: 1px solid #e0e0e0;
    transition: all 0.2s;
  }

  .form-control:focus {
    box-shadow: 0 0 0 3px rgba(23, 193, 232, 0.2); /* Warna info soft */
    border-color: #17c1e8;
  }

  /* Button Styling */
  .btn-login {
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: transform 0.2s;
  }
  
  .btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(23, 193, 232, 0.4);
  }
</style>

<main class="main-content mt-0">
  <section class="min-vh-100">
    <div class="container-fluid p-0">
      <div class="row g-0 login-wrapper">
        
        <!-- Kolom Kiri: Form Login -->
        <div class="col-lg-6 col-md-12 d-flex align-items-center justify-content-center bg-white py-5">
          <div class="login-form-container">
            
            <div class="text-center mb-4">
              <h3 class="font-weight-bolder text-info text-gradient mb-1">E-ROCS</h3>
              <p class="text-sm text-secondary mb-0">Environment Reporting & Compliance System</p>
              <hr class="my-4" style="opacity: 0.1;">
            </div>
            
            <form role="form" method="POST" action="{{ route('login') }}">
              @csrf
              
              <div class="mb-3">
                <label class="form-label text-sm font-weight-bold text-dark">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required autofocus value="{{ old('email') }}">
                @error('email')
                  <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>
              
              <div class="mb-3">
                <label class="form-label text-sm font-weight-bold text-dark">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                @error('password')
                  <p class="text-danger text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>
              
              <div class="text-center mt-4">
                <button type="submit" class="btn bg-gradient-info w-100 mb-0 btn-login shadow-sm">
                  Login
                </button>
              </div>
            </form>
            
            <div class="text-center mt-5">
               <p class="text-xs text-muted mb-0">&copy; {{ date('Y') }} PT Nusa Karya Arindo</p>
               <p class="text-xs text-muted">Site Moronopo</p>
            </div>
          </div>
        </div>

        <!-- Kolom Kanan: Gambar -->
        <div class="col-lg-6 d-none d-lg-block p-0">
          <div class="login-image-side">
            <!-- Opsional: Anda bisa menambahkan teks welcome di atas gambar di sini -->
          </div>
        </div>

      </div>
    </div>
  </section>
</main>

@endsection
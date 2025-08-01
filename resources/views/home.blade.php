@extends('layouts.app')

@section('content')
<div class="hero-wrapper">
    <section class="hero-section row">
        <div class="col-md-7">
            <div class="text-white p-5">
                <h1 class="fw-bold mb-3 judul">Make Health a Priority!</h1>
                <p class="mb-4 fs-1 isi">With ibudigi</p>
                <a href="#" class="btn btn-outline-danger fw-bold px-4 py-2">Let’s Start →</a>
            </div>
        </div>
        <div class="col-md-5 d-flex justify-content-end">
            <img src="{{ asset('images/Image.png') }}" class="hero-image img-fluid" alt="Vaccine">
        </div>
    </section>

    <section class="check-status mt-5">
        <h5 class="fw-bold mb-1">🧑‍⚕️ Health Status</h5>
        <p class="text-muted mb-3">Select to check vaccine status</p>
        <hr>

        <div class="row">
            <div class="col-md-12 d-grid">
                @auth
                    {{-- If user is logged in, go to result page --}}
                    <a href="{{ route('check.results') }}" id="check-btn" class="btn btn-primary btn-lg">
                        Check
                    </a>
                @else
                    {{-- If user is NOT logged in, show login modal --}}
                    <button id="check-btn" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#loginRequiredModal">
                        Check
                    </button>
                @endauth

            </div>
        </div>
    </section>

    <!-- About Us Section (unchanged) -->
    <section class="container my-5 contentisi">
        <div class="row align-items-center">
            <div class="col-md-5">
                <img src="{{ asset('images/family-vaccine.png') }}" class="img-fluid rounded-4"
                    alt="Family vaccinated">
            </div>
            <div class="col-md-7 about">
                <span class="badge bg-danger-subtle text-danger px-3 py-1 mb-2 rounded-pill">About Us</span>
                <h3 class="fw-bold">Ibu Digi Is A Digital Platform That Makes Posyandu Services Easier And More
                    Accessible For Families.</h3>
                <p class="mt-3 text-muted">
                    From child growth tracking to vaccination reminders, we bring essential maternal and child
                    health services right to your fingertips.
                    <br><br>
                    With Ibu Digi, Posyandu goes smart helping moms stay informed, connected, and confident in
                    caring for their little ones.
                </p>
            </div>
        </div>
    </section>

    <section class="container my-5 contentisi">
        <h4 class="fw-bold mb-4">
            <span class="text-primary">Recent</span><span class="text-danger"> News</span>
        </h4>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach ($news as $n)
                <div class="swiper-slide">
                    <div class="card bggambar border-0"
                        style="background-image: url('{{ asset('images/base shape.png') }}'); background-size: contain; background-position: center; background-repeat: no-repeat;">
                        <img src="{{ asset('storage/news_images/' . $n->image) }}" class="card-img-top rounded-top-4"
                            alt="News">
                        <div class="card-body">
                            <p class="text-white fw-semibold p-5 fs-4">{{ $n->title }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-end">
                            <a href="/new/{{ $n->id }}">
                                <button class="btn btn-light btn-sm bton-arrow-active" style="background-color: #92687B; color: #fff">→</button>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination mt-3"></div>
        </div>
    </section>
</div>

<!-- Login Modal with Toggleable Forms -->
<div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="loginRequiredModalLabel">Account Access</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        {{-- Login Form --}}
        <div id="login-form">
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" name="email" required autofocus>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <button type="submit" class="btn btn-primary">Login</button>
              <a href="#" id="show-forgot-form" class="text-decoration-none">Forgot Password?</a>
            </div>
            <div class="mt-3 text-center">
              <a href="#" id="show-register-form" class="text-decoration-none">Don't have an account? Register</a>
            </div>
          </form>
        </div>

        {{-- Forgot Password Form --}}
        <div id="forgot-form" style="display: none;">
          <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
              <label for="forgot-email" class="form-label">Enter your email</label>
              <input name="email" id="forgot-email" type="email" class="form-control" required>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <button type="submit" class="btn btn-warning">Send Reset Link</button>
              <a href="#" id="back-to-login-from-forgot" class="text-decoration-none">Back to login</a>
            </div>
          </form>
        </div>

        {{-- Register Form --}}
        <div id="register-form" style="display: none;">
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Full Name</label>
              <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
              <label for="register-email" class="form-label">Email address</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
              <label for="register-NIK" class="form-label">NIK</label>
              <input type="text" class="form-control" name="NIK" required>
            </div>
            <div class="mb-3">
              <label for="register-password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
              <label for="register-password-confirmation" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" name="password_confirmation" required>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <button type="submit" class="btn btn-success">Register</button>
              <a href="#" id="back-to-login-from-register" class="text-decoration-none">Back to login</a>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  document.getElementById('show-forgot-form').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('forgot-form').style.display = 'block';
    document.getElementById('register-form').style.display = 'none';
  });

  document.getElementById('back-to-login-from-forgot').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('forgot-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
  });

  document.getElementById('show-register-form').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('forgot-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'block';
  });

  document.getElementById('back-to-login-from-register').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('register-form').style.display = 'none';
    document.getElementById('login-form').style.display = 'block';
  });
</script>


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
                <!-- optional status content -->
            </div>
        </div>
    </section>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade show" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" style="display: block;" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password</h5>
        <a href="{{ url('/') }}" class="btn-close"></a> {{-- Back to home on close --}}
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ request()->email }}">

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" name="password" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Backdrop that also closes the modal --}}
<div class="modal-backdrop fade show" onclick="window.location.href='{{ url('/') }}'"></div>
@endsection

@extends('layouts.app')
@section('title', 'Profile')
@section('content')
<div class="title-wrapper pt-30">
    <div class="row align-items-center">
    <div class="col-md-6">
        <div class="title">
        <h2>Profile</h2>
        </div>
    </div>

    </div>
    <!-- end row -->
</div>
<div class="row mt-2">
    <div class="col-12">

      <!-- Profile Information -->
      <div class="card mb-4 shadow-sm w-100">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Profile Information</h5>
        </div>
        <div class="card-body">
          <p class="text-muted">Update your account's profile information and email address.</p>

          <form method="POST" action="{{ route('profile.update') }}" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-6">
              <label for="name" class="form-label">Name</label>
              <input type="text" id="name" name="name" 
                value="{{ old('name', auth()->user()->name) }}" 
                class="form-control @error('name') is-invalid @enderror">
              @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" id="email" name="email" 
                value="{{ old('email', auth()->user()->email) }}" 
                class="form-control @error('email') is-invalid @enderror">
              @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Change Password -->
      <div class="card shadow-sm w-100">
        <div class="card-header bg-secondary text-white">
          <h5 class="mb-0">Change Password</h5>
        </div>
        <div class="card-body">
          <p class="text-muted">Ensure your account is using a strong, random password.</p>

          <form method="POST" action="{{ route('password.update') }}" class="row g-3">
            @csrf
            @method('PUT')

            <div class="col-md-4">
              <label for="current_password" class="form-label">Current Password</label>
              <input type="password" id="current_password" name="current_password"
                class="form-control @error('current_password') is-invalid @enderror">
              @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
              <label for="password" class="form-label">New Password</label>
              <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror">
              @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
              <label for="password_confirmation" class="form-label">Confirm New Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-secondary">Update Password</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

@endsection

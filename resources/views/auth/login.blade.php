<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Login | SF</title>
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/default-logo.png') }}" type="image/x-icon" />

  <!-- Theme Config Js -->
  <script src="{{ asset('assets/js/config.js') }}"></script>

  <!-- Vendor css -->
  <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

  <!-- App css -->
  <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

  <!-- Icons css -->
  <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

  <style>
    .btn-primary {
        background-color: #0d6ee6 !important;
    }
  </style>

</head>

<body>
  <div class="d-flex min-vh-100 justify-content-center align-items-center" style="background-color: #0d6ee6;">
    <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
        <div class="col-xl-4 col-lg-5 col-md-6">
            <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                <a href="#" class="auth-brand mb-3 d-flex align-items-center justify-content-center">
                    {{-- <img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="dark logo" height="40" class="logo-dark">
                    <img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="logo light" height="40" class="logo-light"> --}}
                    <span class="fw-bold fs-3 text-dark">SF</span>
                </a>

                <form method="POST" action="{{ route('login') }}" class="text-start mb-3">
                  @csrf

                  <div class="mb-3">
                      <label class="form-label" for="email">Email</label>
                      <input 
                          type="email" 
                          id="email" 
                          name="email" 
                          class="form-control @error('email') is-invalid @enderror" 
                          placeholder="Enter your email"
                          value="{{ old('email') }}"
                          required 
                          autofocus
                      >
                      @error('email')
                          <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                  </div>

                  <div class="mb-3">
                      <label class="form-label" for="password">Password</label>
                      <input 
                          type="password" 
                          id="password" 
                          name="password" 
                          class="form-control @error('password') is-invalid @enderror" 
                          placeholder="Enter your password"
                          required
                      >
                      @error('password')
                          <span class="invalid-feedback">{{ $message }}</span>
                      @enderror
                  </div>

                  <div class="d-flex justify-content-between mb-3">
                      <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="remember" name="remember">
                          <label class="form-check-label" for="remember">Remember me</label>
                      </div>

                      <a href="{{ route('password.request') }}" class="text-muted border-bottom border-dashed">
                          Forgot Password?
                      </a>
                  </div>

                  <div class="d-grid">
                      <button class="btn btn-primary" type="submit">Login</button>
                  </div>
                </form>

                <p class="mt-auto mb-0">
                    <script>document.write(new Date().getFullYear())</script> © SF
                </p>
            </div>
        </div>
    </div>
  </div>

  <!-- Vendor js -->
  <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

  <!-- App js -->
  <script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>

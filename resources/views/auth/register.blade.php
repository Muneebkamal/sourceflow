<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign Up | SF</title>
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo-default.png') }}" type="image/x-icon" />

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />

  <style>
    /* lock viewport and remove scroll */
    html, body {
      height: 100%;
      margin: 0;
      overflow: hidden; /* no scroll */
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* blue background */
    body {
      background-color: #0d6efd; /* bootstrap primary */
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }

    /* card */
    .signup-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      padding: 2rem;
      width: 100%;
      max-width: 450px;
      text-align: center;
    }

    .signup-card .logo img {
      max-width: 120px;
      display: block;
      margin: 0 auto 1rem auto;
    }

    .signup-card h4 {
      margin-bottom: .25rem;
      color: #0d6efd;
    }

    .signup-card p {
      margin-bottom: 1.25rem;
      color: #495057;
    }

    /* ensure labels are left aligned but card content center */
    .form-label { display: block; text-align: left; font-weight: 600; margin-bottom: .35rem; }
    .form-group { margin-bottom: 1rem; text-align: left; }

    /* show validation message */
    .invalid-feedback { color: #dc3545; display: block; margin-top: .35rem; }

    /* smaller checkbox spacing */
    .form-check { margin-top: .25rem; }
  </style>
</head>
<body>
  <div class="signup-card">
    <!-- Logo (center top) -->
    <div class="logo">
      <img src="{{ asset('assets/images/logo/logo-default.png') }}" alt="Logo">
    </div>

    <h4 class="mb-0">Create an account</h4>
    <p class="mb-3">Start creating the best possible user experience for your customers.</p>

    <form method="POST" action="{{ route('register') }}" novalidate>
      @csrf

      <!-- Name -->
      <div class="form-group">
        <label for="name" class="form-label">Name</label>
        <input
          id="name"
          type="text"
          name="name"
          value="{{ old('name') }}"
          class="form-control @error('name') is-invalid @enderror"
          placeholder="Your full name"
          required
          autofocus
        />
        @error('name')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <!-- Email -->
      <div class="form-group">
        <label for="email" class="form-label">Email</label>
        <input
          id="email"
          type="email"
          name="email"
          value="{{ old('email') }}"
          class="form-control @error('email') is-invalid @enderror"
          placeholder="name@example.com"
          required
        />
        @error('email')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <!-- Password -->
      <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input
          id="password"
          type="password"
          name="password"
          class="form-control @error('password') is-invalid @enderror"
          placeholder="Choose a strong password"
          required
          autocomplete="new-password"
        />
        @error('password')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <label for="password-confirm" class="form-label">Confirm Password</label>
        <input
          id="password-confirm"
          type="password"
          name="password_confirmation"
          class="form-control"
          placeholder="Repeat password"
          required
          autocomplete="new-password"
        />
      </div>

      <!-- Not robot checkbox -->
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="not_robot" name="not_robot" {{ old('not_robot') ? 'checked' : '' }}>
          <label class="form-check-label" for="not_robot">
            I'm not a robot
          </label>
        </div>
        @error('not_robot')
          <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
        @enderror
      </div>

      <!-- Submit -->
      <div class="d-grid mt-2">
        <button type="submit" class="btn btn-primary btn-block">Register</button>
      </div>
    </form>
  </div>

  <!-- JS -->
  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

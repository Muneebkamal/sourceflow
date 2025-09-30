<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Login | Source Flow</title>
  <link rel="shortcut icon" href="{{ asset('assets/images/logo/logo-default.png') }}" type="image/x-icon" />

  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />

  <style>
    html, body {
      height: 100%;
      margin: 0;
      overflow: hidden; /* 🚫 no scroll */
    }

    body {
      background-color: #0d6efd; /* Bootstrap blue */
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-card {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      padding: 2rem;
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .login-card img {
      max-width: 120px;
      margin-bottom: 1rem;
    }
  </style>
</head>

<body>
  <div class="login-card">
    <!-- Logo -->
    <img src="{{ asset('assets/images/logo/logo-default.png') }}" alt="Source Flow Logo">

    <!-- Title -->
    <h4 class="mb-3 text-primary">Sign in to your account</h4>

    <!-- Form -->
    <form action="{{ route('login') }}" method="POST">
      @csrf

      <!-- Email -->
      <div class="mb-3 text-start">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required />
      </div>

      <!-- Password -->
      <div class="mb-3 text-start">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
      </div>

      <!-- Options -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="checkbox-remember" />
          <label class="form-check-label" for="checkbox-remember">Remember me</label>
        </div>
        <a href="{{ route('password.request') }}" class="small">Forgot Password?</a>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>

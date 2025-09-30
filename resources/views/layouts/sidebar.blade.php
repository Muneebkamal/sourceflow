<aside class="sidebar-nav-wrapper">
  <div class="navbar-logo">
    <a href="index.html" class="d-flex align-items-center">
      <img src="{{ asset('assets/images/logo/logo-default.png') }}" style="width:48px; height:48px; object-fit:contain;" alt="logo" />
      <span class="ms-2 fw-bold fs-5" style="color:#333;">Source Flow</span>
    </a>
  </div>
  <nav class="sidebar-nav">
    <ul>
      <li class="nav-item">
        <a href="{{ route('dashboard') }}">
          <span class="icon"><i class="bi bi-speedometer2"></i></span>
          <span class="text">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#">
          <span class="icon"><i class="bi bi-bar-chart-line"></i></span>
          <span class="text">Smart Data</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#">
          <span class="icon"><i class="bi bi-bag-check"></i></span>
          <span class="text">Buy List</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#">
          <span class="icon"><i class="bi bi-receipt-cutoff"></i></span>
          <span class="text">Orders</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#">
          <span class="icon"><i class="bi bi-truck"></i></span>
          <span class="text">Shipping</span>
        </a>
      </li>

      <span class="divider">Lead Source<hr /></span>

      <li class="nav-item">
        <a href="#">
          <span class="icon"><i class="bi bi-people"></i></span>
          <span class="text">My Leads</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#">
          <span class="icon"><i class="bi bi-lightbulb"></i></span>
          <span class="text">OA Cheddar</span>
        </a>
      </li>

      <span class="divider mt-5"><hr /></span>

      <li class="nav-item">
        <a href="#">
          <span class="icon"><i class="bi bi-question-circle"></i></span>
          <span class="text">Help Center</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#">
          <span class="icon"><i class="bi bi-gear"></i></span>
          <span class="text">Settings</span>
        </a>
      </li>
    </ul>
  </nav>
</aside>

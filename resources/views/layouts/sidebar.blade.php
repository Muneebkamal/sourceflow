<div class="sidenav-menu">
  <!-- Brand Logo -->
  <a href="#" class="logo">
      <span class="logo-light">
          <span class="logo-lg">
            {{-- <img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="logo"> --}}
            <span class="text-logo fs-3 fw-bolder text-white">SF</span>
          </span>
          <span class="logo-sm text-logo text-white">SF</span>
          {{-- <span class="logo-sm"><img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="small logo"></span> --}}
      </span>

      <span class="logo-dark">
          <span class="logo-lg">
            {{-- <img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="dark logo"> --}}
            <span class="text-logo fs-3 fw-bolder">SF</span>
          </span>
          <span class="logo-sm text-logo text-white">SF</span>
          {{-- <span class="logo-sm"><img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="small logo"></span> --}}
      </span>
  </a>

  <!-- Sidebar Hover Menu Toggle Button -->
  <button class="button-sm-hover">
      <i class="ti ti-circle align-middle"></i>
  </button>

  <!-- Full Sidebar Menu Close Button -->
  <button class="button-close-fullsidebar">
      <i class="ti ti-x align-middle"></i>
  </button>

  <div data-simplebar>
    <!--- Sidenav Menu -->
    <ul class="side-nav">
      <li class="side-nav-item">
        <a href="{{ route('dashboard') }}" class="side-nav-link">
          <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
          <span class="menu-text">Dashboard</span>
        </a>
      </li>

      <li class="side-nav-item">
        <a href="{{ route('smart.data') }}" class="side-nav-link">
          <span class="menu-icon"><i class="ti ti-chart-line"></i></span>
          <span class="menu-text">Smart Data</span>
        </a>
      </li>

      <li class="side-nav-item">
        <a href="{{ route('buylists.index') }}" class="side-nav-link">
          <span class="menu-icon"><i class="ti ti-shopping-bag"></i></span>
          <span class="menu-text">Buy List</span>
        </a>
      </li>

      <li class="side-nav-item">
        <a href="{{ route('orders.index') }}" class="side-nav-link">
          <span class="menu-icon"><i class="ti ti-clipboard-list"></i></span>
          <span class="menu-text">Purchase Orders</span>
        </a>
      </li>

      <li class="side-nav-item">
        <a href="{{ route('shipping.index') }}" class="side-nav-link">
          <span class="menu-icon"><i class="ti ti-truck-delivery"></i></span>
          <span class="menu-text">Shipping</span>
        </a>
      </li>

      <li class="side-nav-title mt-3">Lead Sources</li>

      <li class="side-nav-item">
        <a href="{{ route('leads.index') }}" class="side-nav-link">
          <span class="menu-icon"><i class="ti ti-users"></i></span>
          <span class="menu-text">My Leads</span>
        </a>
      </li>

      <li class="side-nav-item">
        <a href="{{ route('oac.leads.index') }}" class="side-nav-link">
          <span class="menu-icon"><i class="ti ti-bulb"></i></span>
          <span class="menu-text">OA Cheddar</span>
        </a>
      </li>

      <span class="divider mt-4"><hr /></span>

      <li class="side-nav-item">
        <a href="#" class="side-nav-link">
          <span class="menu-icon"><i class="ti ti-help-circle"></i></span>
          <span class="menu-text">Help Center</span>
        </a>
      </li>

      <li class="side-nav-item">
        <a href="{{ route('setting.index') }}" class="side-nav-link">
          <span class="menu-icon"><i class="ti ti-settings"></i></span>
          <span class="menu-text">Settings</span>
        </a>
      </li>
    </ul>
    <div class="clearfix"></div>
  </div>
</div>

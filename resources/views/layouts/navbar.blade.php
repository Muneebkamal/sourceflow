<header class="header">
  <div class="container-fluid">
    <div class="row">
        <div class="col-lg-5 col-md-5 col-6">
        <div class="header-left d-flex align-items-center">
            <!-- Sidebar Toggle -->
            <div class="menu-toggle-btn mr-15">
            <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                <i class="lni lni-chevron-left me-2"></i>
            </button>
            </div>

            <!-- Dark/Light Mode Toggle -->
            <div class="theme-toggle ms-3">
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="btn btn-sm btn-outline-secondary ms-2">
            <i id="theme-icon" class="lni lni-sun"></i>
            </button>
            </div>
        </div>
        </div>


      <div class="col-lg-7 col-md-7 col-6">
        <div class="header-right">
          <!-- notification start -->
          <div class="notification-box ml-15 d-none d-md-flex">
            <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown"
              aria-expanded="false">
              <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M11 20.1667C9.88317 20.1667 8.88718 19.63 8.23901 18.7917H13.761C13.113 19.63 12.1169 20.1667 11 20.1667Z"
                  fill="" />
                <path
                  d="M10.1157 2.74999C10.1157 2.24374 10.5117 1.83333 11 1.83333C11.4883 1.83333 11.8842 2.24374 11.8842 2.74999V2.82604C14.3932 3.26245 16.3051 5.52474 16.3051 8.24999V14.287C16.3051 14.5301 16.3982 14.7633 16.564 14.9352L18.2029 16.6342C18.4814 16.9229 18.2842 17.4167 17.8903 17.4167H4.10961C3.71574 17.4167 3.5185 16.9229 3.797 16.6342L5.43589 14.9352C5.6017 14.7633 5.69485 14.5301 5.69485 14.287V8.24999C5.69485 5.52474 7.60672 3.26245 10.1157 2.82604V2.74999Z"
                  fill="" />
              </svg>
              <span></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
              <li>
                <a href="#0">
                  <div class="image">
                    <img src="assets/images/lead/lead-6.png" alt="" />
                  </div>
                  <div class="content">
                    <h6>
                      John Doe
                      <span class="text-regular"> comment on a product. </span>
                    </h6>
                    <p>Lorem ipsum dolor sit amet...</p>
                    <span>10 mins ago</span>
                  </div>
                </a>
              </li>
              <li>
                <a href="#0">
                  <div class="image">
                    <img src="assets/images/lead/lead-1.png" alt="" />
                  </div>
                  <div class="content">
                    <h6>
                      Jonathon
                      <span class="text-regular"> like on a product. </span>
                    </h6>
                    <p>Lorem ipsum dolor sit amet...</p>
                    <span>10 mins ago</span>
                  </div>
                </a>
              </li>
            </ul>
          </div>
          <!-- notification end -->

          <!-- Balance Section instead of message -->
          <div class="profile-box ml-15">
            <!-- Balance Section -->
            <div class="header-balance ml-15 d-none d-md-flex align-items-center dropdown">
            <button class="dropdown-toggle bg-transparent border-0 d-flex align-items-center fw-bold text-success" type="button" id="balanceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="lni lni-wallet me-2"></i>
                $32423
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                <li>
                <a href="#0"><i class="lni lni-user"></i> Default Buyl ist </a>
              </li>
              <li>
                <a href="#0"><i class="lni lni-inbox"></i> Team</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="#0"><i class="lni lni-exit"></i> Sign Out</a>
              </li>
            </ul>
            </div>
        <!-- Balance Section end -->

          </div>
          <!-- Balance Section end -->

          <!-- profile start -->
          <div class="profile-box ml-15">
            <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
              data-bs-toggle="dropdown" aria-expanded="false">
              <div class="profile-info">
                <div class="info">
                  <div class="image">
                    <img src="assets/images/profile/profile-image.png" alt="" />
                  </div>
                  <div>
                    <h6 class="fw-500">{{ auth()->user()->name }}</h6>
                    <p>{{ auth()->user()->name }}`s Team</p>
                  </div>
                </div>
              </div>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
              <li>
                <a href="{{ route('profile.index') }}"><i class="lni lni-user"></i> Profile</a>
              </li>
              <li>
                <a href="#0"><i class="lni lni-inbox"></i> Team</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="{{ route('logout') }}" 
                    class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="lni lni-exit"></i> Sign Out
                </a>
                </li>

                <!-- Hidden logout form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
                </form>

            </ul>
          </div>
          <!-- profile end -->
        </div>
      </div>
    </div>
  </div>
</header>

<header class="app-topbar">
<div class="page-container topbar-menu">
    <div class="d-flex align-items-center gap-2">

        <!-- Light/Dark Mode Button -->
        <div class="topbar-item d-none d-sm-flex">
            <button class="topbar-link" id="light-dark-mode" type="button">
                <i class="ti ti-moon fs-22"></i>
            </button>
        </div>

        {{-- <!-- Brand Logo -->
        <a href="#" class="logo">
            <span class="logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="logo">
                    <span class="text-logo text-white">SF</span>
                </span>
                <span class="logo-sm"><img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="small logo"></span>
            </span>

            <span class="logo-dark">
                <span class="logo-lg">
                    <img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="dark logo">
                    <span class="text-logo">SF</span>
                </span>
                <span class="logo-sm"><img src="{{ asset('assets/images/logo/default-logo.png') }}" alt="small logo"></span>
            </span>
        </a>
        
        <!-- Sidebar Menu Toggle Button -->
        <button class="sidenav-toggle-button px-2">
            <i class="ti ti-menu-deep fs-24"></i>
        </button>

        <!-- Horizontal Menu Toggle Button -->
        <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
            <i class="ti ti-menu-deep fs-22"></i>
        </button>

        <!-- Button Trigger Search Modal -->
        <div class="topbar-search text-muted d-none d-xl-flex gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
            <i class="ti ti-search fs-18"></i>
            <span class="me-2">Search something..</span>
            <span class="ms-auto fw-medium">⌘K</span>
        </div>

        <!-- Mega Menu Dropdown -->
        <div class="topbar-item d-none d-md-flex">
            <div class="dropdown">
                <a href="#" class="topbar-link btn btn-link px-2 dropdown-toggle drop-arrow-none fw-medium" data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-offset="0,17" aria-haspopup="false" aria-expanded="false">
                    Pages <i class="ti ti-chevron-down ms-1"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-xxl p-0">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="p-3">
                                <h5 class="mb-2 fw-semibold">UI Components</h5>
                                <ul class="list-unstyled megamenu-list">
                                    <li>
                                        <a href="#!">Widgets</a>
                                    </li>
                                    <li>
                                        <a href="extended-dragula.html">Dragula</a>
                                    </li>
                                    <li>
                                        <a href="ui-dropdowns.html">Dropdowns</a>
                                    </li>
                                    <li>
                                        <a href="extended-ratings.html">Ratings</a>
                                    </li>
                                    <li>
                                        <a href="extended-sweetalerts.html">Sweet Alerts</a>
                                    </li>
                                    <li>
                                        <a href="extended-scrollbar.html">Scrollbar</a>
                                    </li>
                                    <li>
                                        <a href="form-range-slider.html">Range Slider</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3">
                                <h5 class="mb-2 fw-semibold">Applications</h5>
                                <ul class="list-unstyled megamenu-list">
                                    <li>
                                        <a href="apps-ecommerce-products.html">eCommerce Pages</a>
                                    </li>
                                    <li>
                                        <a href="apps-hospital-doctors.html">Hospital</a>
                                    </li>
                                    <li>
                                        <a href="apps-email.html">Email</a>
                                    </li>
                                    <li>
                                        <a href="apps-calendar.html">Calendar</a>
                                    </li>
                                    <li>
                                        <a href="apps-kanban.html">Kanban Board</a>
                                    </li>
                                    <li>
                                        <a href="apps-invoices.html">Invoice Management</a>
                                    </li>
                                    <li>
                                        <a href="pages-pricing.html">Pricing</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 bg-light bg-opacity-50">
                            <div class="p-3">
                                <h5 class="mb-2 fw-semibold">Extra Pages</h5>
                                <ul class="list-unstyled megamenu-list">
                                    <li>
                                        <a href="javascript:void(0);">Left Sidebar with User</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Menu Collapsed</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Small Left Sidebar</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">New Header Style</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">My Account</a>
                                    </li>
                                    <li>
                                        <a href="pages-coming-soon.html">Maintenance & Coming Soon</a>
                                    </li>
                                </ul>
                            </div> <!-- end .bg-light-->
                        </div> <!-- end col-->
                    </div> <!-- end row-->
                </div> <!-- .dropdown-menu-->
            </div> <!-- .dropdown-->
        </div> <!-- end topbar-item --> --}}
    </div>

    <div class="d-flex align-items-center gap-2">
        <button class="btn btn-soft-primary">
            Submit Feedback <i class="ti ti-external-link fs-4"></i>
        </button>
        {{-- <!-- Search for small devices -->
        <div class="topbar-item d-flex d-xl-none">
            <button class="topbar-link" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                <i class="ti ti-search fs-22"></i>
            </button>
        </div> --}}

        {{-- <!-- Language Dropdown -->
        <div class="topbar-item">
            <div class="dropdown">
                <button class="topbar-link" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" aria-haspopup="false" aria-expanded="false">
                    <img src="assets/images/flags/us.svg" alt="user-image" class="w-100 rounded" height="18" id="selected-language-image">
                </button>

                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="en">
                        <img src="assets/images/flags/us.svg" alt="user-image" class="me-1 rounded" height="18" data-translator-image> <span class="align-middle">English</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="hi">
                        <img src="assets/images/flags/in.svg" alt="user-image" class="me-1 rounded" height="18" data-translator-image> <span class="align-middle">Hindi</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <img src="assets/images/flags/de.svg" alt="user-image" class="me-1 rounded" height="18"> <span class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <img src="assets/images/flags/it.svg" alt="user-image" class="me-1 rounded" height="18"> <span class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <img src="assets/images/flags/es.svg" alt="user-image" class="me-1 rounded" height="18"> <span class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <img src="assets/images/flags/ru.svg" alt="user-image" class="me-1 rounded" height="18"> <span class="align-middle">Russian</span>
                    </a>

                </div>
            </div>
        </div> --}}

        <!-- Notification Dropdown -->
        <div class="topbar-item">
            <div class="dropdown">
                <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-bell animate-ring fs-22"></i>
                    <span class="noti-icon-badge"></span>
                </button>

                <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-height: 300px;">
                    <div class="p-3 border-bottom border-dashed">
                        <h6 class="m-0 fs-16 fw-semibold">Notifications (<span id="notif-count">0</span>)</h6>
                    </div>

                    <div class="card shadow-none rounded-0 mb-0" style="height: 300px;">
                        <div id="notification-list" class="list-unstyled p-1 m-0 overflow-auto" style="height: 240px;">
                            <!-- Notifications -->
                        </div>

                        <div class="p-2">
                            <a class="btn btn-white mark-read-btn w-100 d-none">Mark as read</a>
                        </div>
                    </div>


                    <div id="no-notifications" class="text-center py-3 text-muted fst-italic" style="display: none;">
                        No new notifications
                    </div>
                </div>

            </div>
        </div>

        {{-- <!-- Apps Dropdown -->
        <div class="topbar-item d-none d-sm-flex">
            <div class="dropdown">
                <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-apps fs-22"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0">
                    <div class="p-2">
                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/slack.svg" alt="slack">
                                    <span>Slack</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/gitlab.svg" alt="Github">
                                    <span>Gitlab</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dribbble.svg" alt="dribbble">
                                    <span>Dribbble</span>
                                </a>
                            </div>
                        </div>

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/bitbucket.svg" alt="bitbucket">
                                    <span>Bitbucket</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/dropbox.svg" alt="dropbox">
                                    <span>Dropbox</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/google-cloud.svg" alt="G Suite">
                                    <span>G Cloud</span>
                                </a>
                            </div>
                        </div> <!-- end row-->

                        <div class="row g-0">
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/aws.svg" alt="bitbucket">
                                    <span>AWS</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/digital-ocean.svg" alt="dropbox">
                                    <span>Server</span>
                                </a>
                            </div>
                            <div class="col">
                                <a class="dropdown-icon-item" href="#">
                                    <img src="assets/images/brands/bootstrap.svg" alt="G Suite">
                                    <span>Bootstrap</span>
                                </a>
                            </div>
                        </div> <!-- end row-->
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <!-- Button Trigger Customizer Offcanvas -->
        <div class="topbar-item d-none d-sm-flex">
            <button class="topbar-link" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" type="button">
                <i class="ti ti-settings fs-22"></i>
            </button>
        </div> --}}

        <!-- Amount Dropdown -->
        <div class="topbar-item">
            <div class="dropdown">
                <a class="topbar-link dropdown-toggle drop-arrow-none px-2 d-flex align-items-center"
                data-bs-toggle="dropdown" data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">

                    <!-- Icon Instead of Image -->
                    <div class="rounded bg-success-subtle p-1 me-2 d-flex align-items-center justify-content-center">
                        <i class="ti ti-currency-dollar text-success fs-3"></i>
                    </div>

                    <!-- Balance -->
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0">$7,792.09</h5>
                    </span>

                    <!-- Arrow -->
                    <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                </a>

                <!-- Dropdown Menu -->
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 w-auto">
                    <div class="py-1">
                        <!-- Item 1 -->
                        <a href="#" class="dropdown-item d-flex justify-content-between align-items-center">
                            <span>Default Buy List</span>
                            <span class="fw-semibold">$7,757.09</span>
                        </a>

                        <!-- Item 2 -->
                        <a href="#" class="dropdown-item d-flex justify-content-between align-items-center">
                            <span>Kamal</span>
                            <span class="fw-semibold">$35.00</span>
                        </a>

                        <div class="dropdown-divider my-1"></div>

                        <!-- Total -->
                        <a href="#" class="dropdown-item d-flex justify-content-between align-items-center fw-semibold">
                            <span>Total</span>
                            <span>$7,792.09</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Dropdown -->
        <div class="topbar-item nav-user">
            <div class="dropdown">
                <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">
                    {{-- <img src="assets/images/users/avatar-1.jpg" width="32" class="rounded-circle me-lg-2 d-flex" alt="user-image"> --}}
                    <div class="rounded bg-primary-subtle p-1 me-2 d-flex align-items-center justify-content-center">
                        <i class="ti ti-user text-primary fs-3"></i>
                    </div>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0">{{ auth()->user()->name }}</h5>
                        <h6 class="my-0 fw-normal">{{ auth()->user()->name }}'s team</h6>
                    </span>
                    <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('setting.index') }}" class="dropdown-item">
                        <i class="ti ti-user-hexagon me-1 fs-17 align-middle"></i>
                        <span class="align-middle">Your Profile</span>
                    </a>

                    <!-- item-->
                    {{-- <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ti ti-wallet me-1 fs-17 align-middle"></i>
                        <span class="align-middle">Wallet : <span class="fw-semibold">$985.25</span></span>
                    </a> --}}

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ti ti-settings me-1 fs-17 align-middle"></i>
                        <span class="align-middle">Team</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    {{-- <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item">
                        <i class="ti ti-lock-square-rounded me-1 fs-17 align-middle"></i>
                        <span class="align-middle">Lock Screen</span>
                    </a> --}}

                    <!-- item-->
                    <a href="javascript:void(0);" 
                    class="dropdown-item active fw-semibold text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                        <span class="align-middle">Sign Out</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</header>
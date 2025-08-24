<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - ' . config('app.name'))</title>
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <!-- simplebar CSS-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <!-- Bootstrap core CSS-->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- animate CSS-->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons CSS-->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <!-- Sidebar CSS-->
    <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet" />
    <!-- Custom Style-->
    <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet" />
    <!-- Custom Scrollbar -->
    <link href="{{ asset('assets/css/custom-scrollbar.css') }}" rel="stylesheet" />
    @yield('styles')
</head>

<body class="bg-theme bg-theme1">
    <!-- Start wrapper-->
    <div id="wrapper">

        <!--Start sidebar-wrapper-->
        <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
            <div class="brand-logo">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                    <h5 class="logo-text">{{ config('app.name') }}</h5>
                </a>
            </div>
            <ul class="sidebar-menu do-nicescrol">
                <li class="sidebar-header">MAIN NAVIGATION</li>
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('users') ? 'active' : '' }}">
                    <a href="{{ route('users') }}">
                        <i class="zmdi zmdi-account-circle"></i> <span>Users</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('orders') ? 'active' : '' }}">
                    <a href="{{ route('orders') }}">
                        <i class="zmdi zmdi-shopping-cart"></i> <span>Orders</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('categories') ? 'active' : '' }}">
                    <a href="{{ route('categories') }}">
                        <i class="zmdi zmdi-label"></i> <span>Categories</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('brands') ? 'active' : '' }}">
                    <a href="{{ route('brands') }}">
                        <i class="zmdi zmdi-store"></i> <span>Brands</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('inventories') ? 'active' : '' }}">
                    <a href="{{ route('inventories') }}">
                        <i class="zmdi zmdi-inbox"></i> <span>Inventories</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('promo-codes') ? 'active' : '' }}">
                    <a href="{{ route('promo-codes') }}">
                        <i class="zmdi zmdi-ticket-star"></i> <span>Promo Codes</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('icons') ? 'active' : '' }}">
                    <a href="{{ route('icons') }}">
                        <i class="zmdi zmdi-invert-colors"></i> <span>UI Icons</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('forms') ? 'active' : '' }}">
                    <a href="{{ route('forms') }}">
                        <i class="zmdi zmdi-format-list-bulleted"></i> <span>Forms</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('tables') ? 'active' : '' }}">
                    <a href="{{ route('tables') }}">
                        <i class="zmdi zmdi-grid"></i> <span>Tables</span>
                    </a>
                </li>



                <li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}">
                        <i class="zmdi zmdi-face"></i> <span>Profile</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('login') }}" target="_blank">
                        <i class="zmdi zmdi-lock"></i> <span>Login</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('register') }}" target="_blank">
                        <i class="zmdi zmdi-account-circle"></i> <span>Registration</span>
                    </a>
                </li>

                <li class="sidebar-header">LABELS</li>
                <li><a href="javascript:void();"><i class="zmdi zmdi-coffee text-danger"></i> <span>Important</span></a>
                </li>
                <li><a href="javascript:void();"><i class="zmdi zmdi-chart-donut text-success"></i>
                        <span>Warning</span></a></li>
                <li><a href="javascript:void();"><i class="zmdi zmdi-share text-info"></i> <span>Information</span></a>
                </li>
            </ul>
        </div>
        <!--End sidebar-wrapper-->

        <!--Start topbar header-->
        <header class="topbar-nav">
            <nav class="navbar navbar-expand fixed-top">
                <ul class="navbar-nav mr-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link toggle-menu" href="javascript:void();">
                            <i class="icon-menu menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form class="search-bar">
                            <input type="text" class="form-control" placeholder="Enter keywords">
                            <a href="javascript:void();"><i class="icon-magnifier"></i></a>
                        </form>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center right-nav-link">
                    <li class="nav-item dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown"
                            href="javascript:void();">
                            <i class="fa fa-envelope-open-o"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item">
                                <div class="media">
                                    <div class="avatar"><img class="align-self-start mr-3"
                                            style="width: 40px; height: 40px; border-radius: 50%;"
                                            src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-placeholder-black-png-image_3918427.jpg"
                                            alt="user avatar"></div>
                                    <div class="media-body">
                                        <h6 class="mt-2 user-title">John Doe</h6>
                                        <p class="user-subtitle">Lorem ipsum dolor sit amet...</p>
                                        <small class="text-dark">3 hours ago</small>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <div class="media">
                                    <div class="avatar"><img class="align-self-start mr-3"
                                            style="width: 40px; height: 40px; border-radius: 50%;"
                                            src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-placeholder-black-png-image_3918427.jpg"
                                            alt="user avatar"></div>
                                    <div class="media-body">
                                        <h6 class="mt-2 user-title">Jane Smith</h6>
                                        <p class="user-subtitle">New project update available...</p>
                                        <small class="text-dark">5 hours ago</small>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item text-center">View All Messages</li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown-lg">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect"
                            data-toggle="dropdown" href="javascript:void();">
                            <i class="fa fa-bell-o"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item">
                                <div class="media">
                                    <div class="avatar"><i class="fa fa-user-plus mr-3 text-primary"></i></div>
                                    <div class="media-body">
                                        <h6 class="mt-2 user-title">New User Registration</h6>
                                        <p class="user-subtitle">A new user has registered</p>
                                        <small class="text-dark">2 hours ago</small>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <div class="media">
                                    <div class="avatar"><i class="fa fa-download mr-3 text-success"></i></div>
                                    <div class="media-body">
                                        <h6 class="mt-2 user-title">Download Complete</h6>
                                        <p class="user-subtitle">Your file has been downloaded</p>
                                        <small class="text-dark">1 hour ago</small>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <div class="media">
                                    <div class="avatar"><i class="fa fa-exclamation-triangle mr-3 text-warning"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mt-2 user-title">System Alert</h6>
                                        <p class="user-subtitle">Server maintenance scheduled</p>
                                        <small class="text-dark">30 minutes ago</small>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item text-center">View All Notifications</li>
                        </ul>
                    </li>
                    <li class="nav-item language">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect"
                            data-toggle="dropdown" href="javascript:void();"><i class="fa fa-flag"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-gb mr-2"></i> English</li>
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-fr mr-2"></i> French</li>
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-cn mr-2"></i> Chinese</li>
                            <li class="dropdown-item"> <i class="flag-icon flag-icon-de mr-2"></i> German</li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown"
                            href="#">
                            <span class="user-profile"><img
                                    src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-placeholder-black-png-image_3918427.jpg"
                                    class="img-circle" alt="user avatar"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="dropdown-item user-details">
                                <a href="javaScript:void();">
                                    <div class="media">
                                        <div class="avatar"><img class="align-self-start mr-3"
                                                src="https://png.pngtree.com/png-clipart/20210915/ourmid/pngtree-user-avatar-placeholder-black-png-image_3918427.jpg"
                                                alt="user avatar"></div>
                                        <div class="media-body">
                                            <h6 class="mt-2 user-title">{{ auth()->user()->name ?? 'Guest User' }}
                                            </h6>
                                            <p class="user-subtitle">
                                                {{ auth()->user()->email ?? 'guest@example.com' }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-envelope mr-2"></i> Inbox</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-wallet mr-2"></i> Account</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item"><i class="icon-settings mr-2"></i> Setting</li>
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-power mr-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <!--End topbar header-->

        <div class="clearfix"></div>

        <div class="content-wrapper" data-simplebar="" data-simplebar-auto-hide="false">
            <div class="container-fluid">
                <!-- Error Alerts -->
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="custom-alert custom-alert-error" data-index="{{ $loop->index }}">
                            <div class="alert-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2L13.09 8.26L20 9L13.09 9.74L12 16L10.91 9.74L4 9L10.91 8.26L12 2Z"
                                        fill="currentColor" />
                                </svg>
                            </div>
                            <div class="alert-content">
                                <h4>Error</h4>
                                <p>{{ $error }}</p>
                            </div>
                            <button class="alert-close" onclick="closeAlert(this)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                @endif

                <!-- Success Alerts -->
                @if (session('success'))
                    <div class="custom-alert custom-alert-success" data-index="0">
                        <div class="alert-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="alert-content">
                            <h4>Success</h4>
                            <p>{{ session('success') }}</p>
                        </div>
                        <button class="alert-close" onclick="closeAlert(this)">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                @endif

                <!-- Warning Alerts -->
                @if (session('warning'))
                    <div class="custom-alert custom-alert-warning" data-index="0">
                        <div class="alert-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 9V13M12 17H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="alert-content">
                            <h4>Warning</h4>
                            <p>{{ session('warning') }}</p>
                        </div>
                        <button class="alert-close" onclick="closeAlert(this)">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                @endif
                    <style>
                        .custom-alert {
                            position: fixed;
                            top: 100px;
                            right: -400px;
                            z-index: 9999;
                            width: 350px;
                            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
                            color: white;
                            border-radius: 8px;
                            padding: 12px 16px;
                            display: flex;
                            align-items: center;
                            gap: 12px;
                            box-shadow: 0 4px 20px rgba(255, 107, 107, 0.3);
                            border: 1px solid rgba(255, 255, 255, 0.2);
                            backdrop-filter: blur(10px);
                            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                            opacity: 0;
                            transform: translateX(0) scale(0.8);
                        }

                        .custom-alert-error {
                            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
                        }

                        .custom-alert-success {
                            background: linear-gradient(135deg, #51cf66, #40c057);
                        }

                        .custom-alert-warning {
                            background: linear-gradient(135deg, #ffd43b, #fcc419);
                            color: #333;
                        }

                        .alert-icon {
                            flex-shrink: 0;
                            width: 32px;
                            height: 32px;
                            background: rgba(255, 255, 255, 0.2);
                            border-radius: 50%;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        }

                        .alert-content {
                            flex: 1;
                        }

                        .alert-content h4 {
                            margin: 0 0 2px 0;
                            font-size: 14px;
                            font-weight: 600;
                        }

                        .alert-content p {
                            margin: 0;
                            font-size: 12px;
                            opacity: 0.9;
                            line-height: 1.3;
                        }

                        .alert-close {
                            background: none;
                            border: none;
                            color: inherit;
                            cursor: pointer;
                            padding: 4px;
                            border-radius: 4px;
                            transition: background-color 0.2s;
                            flex-shrink: 0;
                        }

                        .alert-close:hover {
                            background: rgba(255, 255, 255, 0.2);
                        }

                        .custom-alert.show {
                            opacity: 1;
                            right: 20px;
                            transform: scale(1);
                        }

                        .custom-alert.hide {
                            opacity: 0;
                            right: -400px;
                            transform: scale(0.8);
                        }

                        @keyframes slideOut {
                            to {
                                transform: translateX(-50%) translateY(-100px);
                                opacity: 0;
                            }
                        }
                    </style>

                    <script>
                        // Wait for page to fully load including all resources
                        window.addEventListener('load', function() {
                            // Additional delay to ensure everything is ready
                            setTimeout(function() {
                                const alerts = document.querySelectorAll('.custom-alert');
                                let currentTop = 100; // Starting position to avoid navbar

                                alerts.forEach((alert, index) => {
                                    // Position each alert at the correct vertical position
                                    alert.style.top = currentTop + 'px';

                                    // Stagger the animations
                                    setTimeout(() => {
                                        alert.classList.add('show');
                                    }, index * 150);

                                    // Calculate the height of this alert and add gap for next one
                                    const alertHeight = alert.offsetHeight;
                                    currentTop += alertHeight + 20; // 20px gap between alerts

                                    // Auto-hide after 5 seconds
                                    setTimeout(() => {
                                        alert.classList.add('hide');
                                        setTimeout(() => {
                                            alert.remove();
                                        }, 600);
                                    }, 5000 + (index * 150));
                                });
                            }, 1000); // 1000ms delay after page load
                        });

                        function closeAlert(button) {
                            const alert = button.closest('.custom-alert');
                            alert.classList.add('hide');
                            setTimeout(() => {
                                alert.remove();
                            }, 600);
                        }
                    </script>
                @yield('content')
            </div>
        </div>
        <!--End content-wrapper-->

        <!--Start Back To Top Button-->
        <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
        <!--End Back To Top Button-->

        <!--Start footer-->
        <footer class="footer">
            <div class="container">
                <div class="text-center">
                    Copyright © {{ date('Y') }} {{ config('app.name') }}
                </div>
            </div>
        </footer>
        <!--End footer-->

        <!--start color switcher-->
        <div class="right-sidebar">
            <div class="switcher-icon">
                <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
            </div>
            <div class="right-sidebar-content">
                <p class="mb-0">Gaussion Texture</p>
                <hr>
                <ul class="switcher">
                    <li id="theme1" style="cursor: pointer;" onclick="changeTheme('bg-theme1')"></li>
                    <li id="theme2" style="cursor: pointer;" onclick="changeTheme('bg-theme2')"></li>
                    <li id="theme3" style="cursor: pointer;" onclick="changeTheme('bg-theme3')"></li>
                    <li id="theme4" style="cursor: pointer;" onclick="changeTheme('bg-theme4')"></li>
                    <li id="theme5" style="cursor: pointer;" onclick="changeTheme('bg-theme5')"></li>
                    <li id="theme6" style="cursor: pointer;" onclick="changeTheme('bg-theme6')"></li>
                </ul>
                <p class="mb-0">Gradient Background</p>
                <hr>
                <ul class="switcher">
                    <li id="theme7" style="cursor: pointer;" onclick="changeTheme('bg-theme7')"></li>
                    <li id="theme8" style="cursor: pointer;" onclick="changeTheme('bg-theme8')"></li>
                    <li id="theme9" style="cursor: pointer;" onclick="changeTheme('bg-theme9')"></li>
                    <li id="theme10" style="cursor: pointer;" onclick="changeTheme('bg-theme10')"></li>
                    <li id="theme11" style="cursor: pointer;" onclick="changeTheme('bg-theme11')"></li>
                    <li id="theme12" style="cursor: pointer;" onclick="changeTheme('bg-theme12')"></li>
                    <li id="theme13" style="cursor: pointer;" onclick="changeTheme('bg-theme13')"></li>
                    <li id="theme14" style="cursor: pointer;" onclick="changeTheme('bg-theme14')"></li>
                    <li id="theme15" style="cursor: pointer;" onclick="changeTheme('bg-theme15')"></li>
                </ul>
            </div>
        </div>
        <!--end color switcher-->

    </div>
    <!--End wrapper-->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- simplebar js -->
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
    <!-- sidebar-menu js -->
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <!-- Custom scripts -->
    <script src="{{ asset('assets/js/app-script.js') }}"></script>
    <!-- Theme switcher -->
    <script src="{{ asset('assets/js/theme-switcher.js') }}"></script>

    <!-- Inline theme switcher script -->
    <script>
        // Direct theme change function
        function changeTheme(themeClass) {
            // Apply theme
            document.body.className = 'bg-theme ' + themeClass;

            // Save to localStorage
            localStorage.setItem('dashtremeTheme', themeClass);

            // Close sidebar
            document.querySelector('.right-sidebar').classList.remove('right-toggled');

            // Refresh scrollbars if SimpleBar is available
            if (typeof SimpleBar !== 'undefined' && SimpleBar.instances) {
                document.querySelectorAll('[data-simplebar]').forEach(function(element) {
                    var sb = SimpleBar.instances.get(element);
                    if (sb) {
                        sb.recalculate();
                    }
                });
            }
        }

        // Toggle theme switcher sidebar
        document.addEventListener('DOMContentLoaded', function() {
            var switcherIcon = document.querySelector('.switcher-icon');
            if (switcherIcon) {
                switcherIcon.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector('.right-sidebar').classList.toggle('right-toggled');
                });
            }
        });
    </script>

    @yield('scripts')
</body>

</html>

<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-lg navbar-dark">
        {{-- ============================================================== --}}
        {{-- ====================== Header Menu Section =================== --}}
        {{-- ============================================================== --}}


        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <a class="navbar-brand" href="{{ route('super_admin.dashboard') }}">
                <b class="logo-icon">
                    <!-- Light Logo icon -->
                    {{-- <img src="{{ asset('style_files/shared/images_default/profilesf.jpg') }}" alt="BlueRay Logo"
                        class="rounded-circle logo-image" width="60" height="60" /> --}}
                </b>

                <span class="logo-text">
                    <b> Insurance System </b>
                </span>
            </a>

          
            {{-- ============================================================== --}}
            {{-- ====================== Left Side Toggle ====================== --}}
            {{-- ============================================================== --}}
            <ul class="navbar-nav me-auto">
                {{-- Toggle Visible on Mobile Only --}}
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                        data-sidebartype="mini-sidebar">
                        <i class="icon-arrow-left-circle"></i>
                    </a>
                </li>
            </ul>

            {{-- ============================================================== --}}
            {{-- ====================== Right Side Toggle ===================== --}}
            {{-- ============================================================== --}}

            <ul class="navbar-nav">
                {{-- Search --}}
                {{-- <li class="nav-item search-box d-none d-md-block"> --}}
                {{-- <form class="app-search mt-3 me-2">
                        <input type="text" class="form-control rounded-pill border-0" placeholder="Search for...">
                        <a class="srh-btn"><i class="ti-search"></i></a>
                    </form> --}}

                {{-- </li> --}}
                {{-- <div>
                    <h4 class="mb-0 text-white"> {{ isset(auth()->user()->name) ? auth()->user()->name : 'Undefined' }}
                    </h4>
                </div> --}}


                {{-- User Profile --}}
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        @if (auth()->guard('super_admin')->check() && auth()->guard('super_admin')->user()->image && file_exists(auth()->guard('super_admin')->user()->image))
                            <img src="{{ asset(auth()->guard('super_admin')->user()->image) }}" width="30"
                                height="30" class="profile-pic rounded-circle">
                        @else
                            <img src="{{ asset('style_files/shared/images_default/profilesf.png') }}" alt="user"
                                width="30" height="30" class="profile-pic rounded-circle" />
                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY">
                        <div class="d-flex no-block align-items-center p-3 bg-info text-white mb-2">
                            <div>
                                @if (auth()->guard('super_admin')->check() && auth()->guard('super_admin')->user()->image && file_exists(auth()->guard('super_admin')->user()->image))
                                    <img src="{{ asset(auth()->guard('super_admin')->user()->image) }}" width="60"
                                        height="60" class="profile-pic rounded-circle">
                                @else
                                    <img src="{{ asset('style_files/shared/images_default/profilesf.png') }}"
                                        alt="user" class="rounded-circle" width="60">
                                @endif
                            </div>
                            <div class="ms-2">
                                <h4 class="mb-0 text-white">
                                    {{ isset(auth()->user()->name) ? auth()->user()->name : 'Undefined' }}</h4>
                                <p class=" mb-0">
                                    {{ isset(auth()->user()->email) ? auth()->user()->email : 'Undefined' }}</p>
                            </div>
                        </div>

                        @if (auth()->guard('super_admin')->check())
                            <a class="dropdown-item"
                                href="{{ route('super_admin.admins-show', ['id' => isset(auth()->user()->id) ? auth()->user()->id : 'Undefined']) }}">
                                <i data-feather="user" class="feather-sm text-info me-1 ms-1"></i> My Profile
                            </a>
                        @endif


                        <a class="dropdown-item" href="{{ route('super_admin.support_tickets-index') }}"><i
                                data-feather="settings" class="feather-sm text-warning me-1 ms-1"></i>
                            Supprt Tickets
                        </a>


                        <a class="dropdown-item" href="{{ route('super_admin.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i>Logout
                        </a>

                        <form id="logout-form" action="{{ route('super_admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>

                    </div>
                </li> --}}

                {{-- Language --}}
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="flag-icon flag-icon-us"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up">
                        <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-jo"></i>Arabic
                        </a>
                    </div>
                </li> --}}
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            @if (auth()->guard('super_admin')->check() &&
                                    auth()->guard('super_admin')->user()->image &&
                                    file_exists(auth()->guard('super_admin')->user()->image))
                                <img src="{{ asset(auth()->guard('super_admin')->user()->image) }}" width="30"
                                    height="30" class="profile-pic rounded-circle">
                            @else
                                <img src="{{ asset('style_files/shared/images_default/profilesf.png') }}"
                                    alt="user" width="30" height="30"
                                    class="profile-pic rounded-circle" />
                            @endif
                            <span class="ms-2">
                                <strong> {{ isset(auth()->user()->name) ? auth()->user()->name : 'Undefined' }}
                                </strong>
                            </span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY">
                        <div class="d-flex no-block align-items-center p-3 bg-info text-white mb-2">
                            <div>
                                @if (auth()->guard('super_admin')->check() &&
                                        auth()->guard('super_admin')->user()->image &&
                                        file_exists(auth()->guard('super_admin')->user()->image))
                                    <img src="{{ asset(auth()->guard('super_admin')->user()->image) }}"
                                        width="60" height="60" class="profile-pic rounded-circle">
                                @else
                                    <img src="{{ asset('style_files/shared/images_default/profilesf.png') }}"
                                        alt="user" class="rounded-circle" width="60">
                                @endif
                            </div>
                            <div class="ms-2">
                                <h4 class="mb-0 text-white">
                                    {{ isset(auth()->user()->name) ? auth()->user()->name : 'Undefined' }}</h4>
                                <p class=" mb-0">
                                    {{ isset(auth()->user()->email) ? auth()->user()->email : 'Undefined' }}</p>
                            </div>
                        </div>

                        {{-- @if (auth()->guard('super_admin')->check())
                            <a class="dropdown-item"
                                href="{{ route('super_admin.admins-show', ['id' => isset(auth()->user()->id) ? auth()->user()->id : 'Undefined']) }}">
                                <i data-feather="user" class="feather-sm text-info me-1 ms-1"></i> My Profile
                            </a>
                        @endif --}}


                        <a class="dropdown-item" href="{{ route('welcome') }}"><i
                                data-feather="settings" class="feather-sm text-warning me-1 ms-1"></i>
                            Go To Website
                        </a>
                       
                        <a class="dropdown-item" href="{{ route('super_admin.support_tickets-index') }}"><i
                                data-feather="settings" class="feather-sm text-warning me-1 ms-1"></i>
                            Supprt Tickets
                        </a>


                        <a class="dropdown-item" href="{{ route('super_admin.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i>Logout
                        </a>

                        <form id="logout-form" action="{{ route('super_admin.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>

                    </div>
                </li>

                <!-- ... other menu items ... -->
            </ul>
        </div>
    </nav>
</header>

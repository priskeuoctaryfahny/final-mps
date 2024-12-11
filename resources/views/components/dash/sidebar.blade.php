<nav class="navbar navbar-vertical navbar-expand-lg d-print-none">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">


                <li class="nav-item">

                    <div class="nav-item-wrapper">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} label-1"
                            href="{{ route('dashboard') }}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span data-feather="compass"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">{{ __('text-ui.sidebar.dashboard') }}</span>
                                </span>
                            </div>
                        </a>
                    </div>

                    @canany(['role-list', 'role-create', 'role-edit', 'role-delete'])
                        <div class="nav-item-wrapper">
                            <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }} label-1"
                                href="{{ route('roles.index') }}" role="button" data-bs-toggle="" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-icon">
                                        <span data-feather="compass"></span>
                                    </span>
                                    <span class="nav-link-text-wrapper">
                                        <span class="nav-link-text">{{ __('text-ui.sidebar.role') }}</span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endcanany

                    <div class="nav-item-wrapper">
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }} label-1"
                            href="{{ route('users.index') }}" role="button" data-bs-toggle="" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <span class="nav-link-icon">
                                    <span data-feather="compass"></span>
                                </span>
                                <span class="nav-link-text-wrapper">
                                    <span class="nav-link-text">{{ __('text-ui.sidebar.user') }}</span>
                                </span>
                            </div>
                        </a>
                    </div>


                </li>


            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer">
        <button
            class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center">
            <span class="uil uil-left-arrow-to-left fs-8"></span>
            <span class="uil uil-arrow-from-right fs-8"></span>
            <span class="navbar-vertical-footer-text ms-2">{{ __('text-ui.sidebar.collapse') }}</span>
        </button>
    </div>
</nav>

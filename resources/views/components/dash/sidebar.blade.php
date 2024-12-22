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
                                    <span data-feather="grid"></span>
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
                                        <span data-feather="key"></span>
                                    </span>
                                    <span class="nav-link-text-wrapper">
                                        <span class="nav-link-text">{{ __('text-ui.sidebar.role') }}</span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endcanany



                </li>



                @canany(['user-list', 'user-create', 'user-edit', 'user-delete', 'activity-list', 'activity-download'])
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('users.*') || request()->routeIs('activities.*') ? '' : 'collapsed' }}"
                            href="#nv-user" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('users.*') || request()->routeIs('activities.*') ? 'true' : 'false' }}"
                            aria-controls="nv-user">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper"><span
                                        class="fas fa-caret-right dropdown-indicator-icon"></span></div><span
                                    class="nav-link-icon"><span data-feather="users"></span></span><span
                                    class="nav-link-text">{{ __('text-ui.sidebar.user') }}</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ request()->routeIs('users.*') || request()->routeIs('activities.*') ? 'show' : '' }}"
                                data-bs-parent="#navbarVerticalCollapse" id="nv-user">
                                <li class="collapsed-nav-item-title d-none">{{ __('text-ui.sidebar.user') }}
                                </li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                        href="{{ route('users.index') }}">
                                        <div class="d-flex align-items-center"><span class="nav-link-text">
                                                Data Pengguna
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                @can('activity-list')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('activities.index') ? 'active' : '' }}"
                                            href="{{ route('activities.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">
                                                    Histori Pengguna
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                @endcan

                @canany(['unit-list', 'unit-create', 'unit-edit', 'unit-delete', 'unit-download', 'incident-list',
                    'incident-create', 'incident-edit', 'incident-delete', 'incident-download'])
                    <div class="nav-item-wrapper">
                        <a class="nav-link dropdown-indicator label-1 {{ request()->routeIs('units.*') || request()->routeIs('incidents.*') ? '' : 'collapsed' }}"
                            href="#nv-masters" role="button" data-bs-toggle="collapse"
                            aria-expanded="{{ request()->routeIs('units.*') || request()->routeIs('incidents.*') ? 'true' : 'false' }}"
                            aria-controls="nv-masters">
                            <div class="d-flex align-items-center">
                                <div class="dropdown-indicator-icon-wrapper"><span
                                        class="fas fa-caret-right dropdown-indicator-icon"></span></div><span
                                    class="nav-link-icon"><span data-feather="clipboard"></span></span><span
                                    class="nav-link-text">Master Data</span>
                            </div>
                        </a>
                        <div class="parent-wrapper label-1">
                            <ul class="nav collapse parent {{ request()->routeIs('units.*') || request()->routeIs('incidents.*') ? 'show' : '' }}"
                                data-bs-parent="#navbarVerticalCollapse" id="nv-masters">
                                <li class="collapsed-nav-item-title d-none">
                                    Master Data
                                </li>
                                @can('unit-list')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('units.index') ? 'active' : '' }}"
                                            href="{{ route('units.index') }}">
                                            <div class="d-flex align-items-center"><span class="nav-link-text">
                                                    Data Unit
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                @endcan
                                @can('incident-list')
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('incidents.index') ? 'active' : '' }}"
                                            href="{{ route('incidents.index') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="nav-link-text">
                                                    Data Insiden
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </div>
                @endcan


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

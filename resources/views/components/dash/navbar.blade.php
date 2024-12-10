<nav class="navbar navbar-top fixed-top navbar-expand d-print-none" id="navbarDefault">
    <div class="collapse navbar-collapse justify-content-between">
        <div class="navbar-logo">

            <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse"
                aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                        class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="#">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{ $sets->web_logo ? Storage::url($sets->web_logo) : asset('backend/assets/img/default/nope.jpg') }}"
                            alt="phoenix" width="27" />
                        <h5 class="logo-text ms-2 d-none d-sm-block">
                            {{ $sets->web_title ? $sets->web_title : config('app.name') }}
                        </h5>
                    </div>
                </div>
            </a>
        </div>
        <div class="search-box navbar-top-search-box d-none d-lg-block" data-list='{"valueNames":["title"]}'
            style="width:25rem;">
            <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                <input class="form-control search-input fuzzy-search rounded-pill form-control-sm" type="search"
                    placeholder="Search..." aria-label="Search" />
                <span class="fas fa-search search-box-icon"></span>

            </form>
            <div class="btn-close position-absolute end-0 top-50 translate-middle cursor-pointer shadow-none"
                data-bs-dismiss="search">
                <button class="btn btn-link p-0" aria-label="Close"></button>
            </div>
            <div class="dropdown-menu border start-0 py-0 overflow-hidden w-100">
                <div class="scrollbar-overlay" style="max-height: 30rem;">
                    <div class="list pb-3">
                        <h6 class="dropdown-header text-body-highlight fs-10 py-2">24 <span
                                class="text-body-quaternary">results</span></h6>
                        <hr class="my-0" />
                        <h6
                            class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                            Recently Searched </h6>
                        <div class="py-2"><a class="dropdown-item"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="d-flex align-items-center">

                                    <div class="fw-normal text-body-highlight title"><span
                                            class="fa-solid fa-clock-rotate-left" data-fa-transform="shrink-2"></span>
                                        Store Macbook</div>
                                </div>
                            </a>
                            <a class="dropdown-item"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="d-flex align-items-center">

                                    <div class="fw-normal text-body-highlight title"> <span
                                            class="fa-solid fa-clock-rotate-left" data-fa-transform="shrink-2"></span>
                                        MacBook Air - 13″</div>
                                </div>
                            </a>

                        </div>
                        <hr class="my-0" />
                        <h6
                            class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                            Products</h6>
                        <div class="py-2"><a class="dropdown-item py-2 d-flex align-items-center"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="file-thumbnail me-2"><img class="h-100 w-100 object-fit-cover rounded-3"
                                        src="{{ asset('backend') }}/assets/img/products/60x60/3.png" alt="" />
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 text-body-highlight title">MacBook Air - 13″</h6>
                                    <p class="fs-10 mb-0 d-flex text-body-tertiary"><span
                                            class="fw-medium text-body-tertiary text-opactity-85">8GB Memory - 1.6GHz -
                                            128GB Storage</span></p>
                                </div>
                            </a>
                            <a class="dropdown-item py-2 d-flex align-items-center"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="file-thumbnail me-2"><img class="img-fluid"
                                        src="{{ asset('backend') }}/assets/img/products/60x60/3.png" alt="" />
                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 text-body-highlight title">MacBook Pro - 13″</h6>
                                    <p class="fs-10 mb-0 d-flex text-body-tertiary"><span
                                            class="fw-medium text-body-tertiary text-opactity-85">30 Sep at 12:30
                                            PM</span></p>
                                </div>
                            </a>

                        </div>
                        <hr class="my-0" />
                        <h6
                            class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                            Quick Links</h6>
                        <div class="py-2"><a class="dropdown-item"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="d-flex align-items-center">

                                    <div class="fw-normal text-body-highlight title"><span
                                            class="fa-solid fa-link text-body" data-fa-transform="shrink-2"></span>
                                        Support MacBook House</div>
                                </div>
                            </a>
                            <a class="dropdown-item"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="d-flex align-items-center">

                                    <div class="fw-normal text-body-highlight title"> <span
                                            class="fa-solid fa-link text-body" data-fa-transform="shrink-2"></span>
                                        Store MacBook″</div>
                                </div>
                            </a>

                        </div>
                        <hr class="my-0" />
                        <h6
                            class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                            Files</h6>
                        <div class="py-2"><a class="dropdown-item"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="d-flex align-items-center">

                                    <div class="fw-normal text-body-highlight title"><span
                                            class="fa-solid fa-file-zipper text-body"
                                            data-fa-transform="shrink-2"></span> Library MacBook folder.rar</div>
                                </div>
                            </a>
                            <a class="dropdown-item"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="d-flex align-items-center">

                                    <div class="fw-normal text-body-highlight title"> <span
                                            class="fa-solid fa-file-lines text-body"
                                            data-fa-transform="shrink-2"></span> Feature MacBook extensions.txt</div>
                                </div>
                            </a>
                            <a class="dropdown-item"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="d-flex align-items-center">

                                    <div class="fw-normal text-body-highlight title"> <span
                                            class="fa-solid fa-image text-body" data-fa-transform="shrink-2"></span>
                                        MacBook Pro_13.jpg</div>
                                </div>
                            </a>

                        </div>
                        <hr class="my-0" />
                        <h6
                            class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                            Members</h6>
                        <div class="py-2"><a class="dropdown-item py-2 d-flex align-items-center"
                                href="{{ asset('backend') }}/pages/members.html">
                                <div class="avatar avatar-l status-online  me-2 text-body">
                                    <img class="rounded-circle "
                                        src="{{ asset('backend') }}/assets/img/team/40x40/10.webp" alt="" />

                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 text-body-highlight title">Carry Anna</h6>
                                    <p class="fs-10 mb-0 d-flex text-body-tertiary">anna@technext.it</p>
                                </div>
                            </a>
                            <a class="dropdown-item py-2 d-flex align-items-center"
                                href="{{ asset('backend') }}/pages/members.html">
                                <div class="avatar avatar-l  me-2 text-body">
                                    <img class="rounded-circle "
                                        src="{{ asset('backend') }}/assets/img/team/40x40/12.webp" alt="" />

                                </div>
                                <div class="flex-1">
                                    <h6 class="mb-0 text-body-highlight title">John Smith</h6>
                                    <p class="fs-10 mb-0 d-flex text-body-tertiary">smith@technext.it</p>
                                </div>
                            </a>

                        </div>
                        <hr class="my-0" />
                        <h6
                            class="dropdown-header text-body-highlight fs-9 border-bottom border-translucent py-2 lh-sm">
                            Related Searches</h6>
                        <div class="py-2"><a class="dropdown-item"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="d-flex align-items-center">

                                    <div class="fw-normal text-body-highlight title"><span
                                            class="fa-brands fa-firefox-browser text-body"
                                            data-fa-transform="shrink-2"></span> Search in the Web MacBook</div>
                                </div>
                            </a>
                            <a class="dropdown-item"
                                href="{{ asset('backend') }}/apps/e-commerce/landing/product-details.html">
                                <div class="d-flex align-items-center">

                                    <div class="fw-normal text-body-highlight title"> <span
                                            class="fa-brands fa-chrome text-body" data-fa-transform="shrink-2"></span>
                                        Store MacBook″</div>
                                </div>
                            </a>

                        </div>
                    </div>
                    <div class="text-center">
                        <p class="fallback fw-bold fs-7 d-none">No Result Found.</p>
                    </div>
                </div>
            </div>
        </div>
        <ul class="navbar-nav navbar-nav-icons flex-row">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="languageDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ trans('text-ui.lang.text') }}: {{ __('text-ui.lang.language') }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                    <li>
                        <a class="dropdown-item"
                            href="{{ route('change.lang', ['lang' => 'en']) }}">{{ __('text-ui.lang.english') }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="{{ route('change.lang', ['lang' => 'id']) }}">{{ __('text-ui.lang.indonesia') }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="{{ route('change.lang', ['lang' => 'jv']) }}">{{ __('text-ui.lang.javanese') }}</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <div class="theme-control-toggle fa-icon-wait px-2">
                    <input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox"
                        data-theme-control="phoenixTheme" value="dark" id="themeControlToggle" />
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                        style="height:32px;width:32px;"><span class="icon" data-feather="moon"></span></label>
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle"
                        data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Switch theme"
                        style="height:32px;width:32px;"><span class="icon" data-feather="sun"></span></label>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!"
                    role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="avatar avatar-l ">
                        <img class="rounded-circle "
                            src="{{ Auth::user()->picture ? Storage::url(Auth::user()->picture) : asset('backend/assets/img/team/1.webp') }}"
                            alt="" />

                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border"
                    aria-labelledby="navbarDropdownUser">
                    <div class="card position-relative border-0">
                        <div class="card-body p-0">
                            <div class="text-center pt-4 pb-3">
                                <div class="avatar avatar-xl ">
                                    <img class="rounded-circle "
                                        src="{{ Auth::user()->picture ? Storage::url(Auth::user()->picture) : asset('backend/assets/img/team/1.webp') }}"
                                        alt="" />

                                </div>
                                <h6 class="mt-2 text-body-emphasis">{{ Auth::user()->name }}</h6>
                            </div>
                            <div class="mb-3 mx-3">
                                <input class="form-control form-control-sm" id="statusUpdateInput" type="text"
                                    placeholder="Update your status" />
                            </div>
                        </div>
                        <div class="overflow-auto scrollbar" style="height: 10rem;">
                            <ul class="nav d-flex flex-column mb-2 pb-1">
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('profiles.*') ? 'text-primary' : '' }} px-3 d-block"
                                        href="{{ route('profiles.index') }}"> <span
                                            class="me-2 text-body align-bottom"
                                            data-feather="user"></span><span>{{ __('text-ui.navbar.profile') }}</span></a>
                                </li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('dashboard') ? 'text-primary' : '' }} px-3 d-block"
                                        href="{{ route('dashboard') }}"><span class="me-2 text-body align-bottom"
                                            data-feather="pie-chart"></span>{{ __('text-ui.navbar.dashboard') }}</a>
                                </li>
                                <li class="nav-item"><a
                                        class="nav-link {{ request()->routeIs('settings.index') ? 'text-primary' : '' }} px-3 d-block"
                                        href="{{ route('settings.index') }}"><span
                                            class="me-2 text-body align-bottom"
                                            data-feather="settings"></span>{{ __('text-ui.navbar.web-setting') }}</a>
                                </li>


                            </ul>
                        </div>
                        <div class="card-footer p-0">
                            <div class="px-3 mt-2">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button class="btn btn-phoenix-secondary d-flex flex-center w-100" href="#!">
                                        <span class="me-2" data-feather="log-out">
                                        </span>{{ __('text-ui.navbar.logout') }}</button>
                                </form>
                            </div>
                            <div class="my-2 text-center fw-bold fs-10 text-body-quaternary"><a
                                    class="text-body-quaternary me-1" href="#!">Privacy policy</a>&bull;<a
                                    class="text-body-quaternary mx-1" href="#!">Terms</a>&bull;<a
                                    class="text-body-quaternary ms-1" href="#!">Cookies</a></div>
                        </div>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</nav>

<div class="content">
    <nav class="mb-3 d-print-none" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            @if (Breadcrumbs::exists($slot))
                {!! Breadcrumbs::render($slot) !!}
            @endif
        </ol>
    </nav>

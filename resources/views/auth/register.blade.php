<x-auth.layout>
    @slot('title')
        Halaman Registrasi
    @endslot

    <main class="main" id="top">
        <div class="row vh-100 g-0">
            <div class="col-lg-6 position-relative d-none d-lg-block">
                <div class="bg-holder" style="background-image:url({{ asset('backend') }}/assets/img/bg/30.png);">
                </div>
                <!--/.bg-holder-->
            </div>
            <div class="col-lg-6">
                <div class="row flex-center h-100 g-0 px-4 px-sm-0">
                    <div class="col col-sm-6 col-lg-7 col-xl-6">
                        <a class="d-flex flex-center text-decoration-none mb-4" href="{{ asset('backend') }}/index.html">
                            <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                    src="{{ asset('backend') }}/assets/img/icons/logo.png" alt="phoenix"
                                    width="58" />
                            </div>
                        </a>
                        <div class="text-center mb-7">
                            <h3 class="text-body-highlight">Create Account</h3>
                            <p class="text-body-tertiary">Please fill in the details below</p>
                        </div>

                        @if ($errors->any())
                            @foreach ($errors->all() as $row)
                                <div class="alert alert-outline-danger d-flex align-items-center" role="alert">
                                    <span class="fas fa-times-circle text-danger fs-5 me-3"></span>
                                    <p class="mb-0 flex-1">
                                        {{ $row }}
                                    </p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endforeach
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3 text-start">
                                <label class="form-label" for="name">Name</label>
                                <div class="form-icon-container">
                                    <input class="form-control form-icon-input" id="name" name="name"
                                        type="text" placeholder="Your Name" value="{{ old('name') }}" required
                                        autofocus />
                                    <span class="fas fa-user text-body fs-9 form-icon"></span>
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label" for="email">Email address</label>
                                <div class="form-icon-container">
                                    <input class="form-control form-icon-input" id="email" name="email"
                                        type="email" placeholder="name@example.com" value="{{ old('email') }}"
                                        required />
                                    <span class="fas fa-envelope text-body fs-9 form-icon"></span>
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label" for="password">Password</label>
                                <div class="form-icon-container">
                                    <input class="form-control form-icon-input" id="password" name="password"
                                        type="password" placeholder="Password" required />
                                    <span class="fas fa-key text-body fs-9 form-icon"></span>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <div class="form-icon-container">
                                    <input class="form-control form-icon-input" id="password_confirmation"
                                        name="password_confirmation" type="password" placeholder="Confirm Password"
                                        required />
                                    <span class="fas fa-key text-body fs-9 form-icon"></span>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <button class="btn btn-primary w-100 mb-3">Register</button>
                        </form>
                        <div class="text-center">
                            <a class="fs-9 fw-bold" href="{{ route('login') }}">Already registered?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var navbarTopStyle = window.config.config.phoenixNavbarTopStyle;
            var navbarTop = document.querySelector('.navbar-top');
            if (navbarTopStyle === 'darker') {
                navbarTop.setAttribute('data-navbar-appearance', 'darker');
            }

            var navbarVerticalStyle = window.config.config.phoenixNavbarVerticalStyle;
            var navbarVertical = document.querySelector('.navbar-vertical');
            if (navbarVertical && navbarVerticalStyle === 'darker') {
                navbarVertical.setAttribute('data-navbar-appearance', 'darker');
            }
        </script>
    </main>
</x-auth.layout>

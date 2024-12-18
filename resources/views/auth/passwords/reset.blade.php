<x-auth.layout>
    @slot('title')
        Halaman Reset Password
    @endslot
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                        class="d-flex flex-center text-decoration-none mb-4" href="{{ route('login') }}">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="{{ $sets->web_logo ? Storage::url($sets->web_logo) : asset('backend/assets/img/default/nope.jpg') }}"
                                alt="phoenix" width="58" />
                        </div>
                    </a>
                    <div class="text-center mb-6">
                        <h4 class="text-body-highlight">Reset Password</h4>
                        <p class="text-body-tertiary">Silahkan masukkan password baru</p>
                        <form class="mt-5 needs-validation" method="POST" action="{{ route('password.update') }}"
                            novalidate="" onsubmit="showLoader()">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="position-relative mb-2">
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            <div class="position-relative mb-2" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" name="password" id="password"
                                    type="password" placeholder="Password Baru"
                                    data-password-input="data-password-input" required />
                                <button type="button"
                                    class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle"><span
                                        class="uil uil-eye show"></span><span
                                        class="uil uil-eye-slash hide"></span></button>
                            </div>
                            <div class="position-relative mb-4" data-password="data-password">
                                <input class="form-control form-icon-input pe-6" id="confirmPassword" type="password"
                                    name="password_confirmation" placeholder="Konfirmasi Password Baru"
                                    data-password-input="data-password-input" required />
                                <button type="button"
                                    class="btn px-3 py-0 h-100 position-absolute top-0 end-0 fs-7 text-body-tertiary"
                                    data-password-toggle="data-password-toggle"><span
                                        class="uil uil-eye show"></span><span
                                        class="uil uil-eye-slash hide"></span></button>
                            </div>
                            <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                        </form>
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

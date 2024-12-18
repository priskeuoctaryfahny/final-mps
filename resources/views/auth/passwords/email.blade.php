<x-auth.layout>
    @slot('title')
        Halaman Reset Password
    @endslot
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4"><a class="d-flex flex-center text-decoration-none mb-4"
                        href="{{ route('login') }}">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block"><img
                                src="{{ $sets->web_logo ? Storage::url($sets->web_logo) : asset('backend/assets/img/default/nope.jpg') }}"
                                alt="phoenix" width="58" />
                        </div>
                    </a>
                    <div class="px-xxl-5">
                        <div class="text-center mb-6">
                            <h4 class="text-body-highlight">Lupa Password?</h4>
                            <p class="text-body-tertiary mb-5">Masukkan email Anda di bawah ini dan kami akan kirim <br>
                                <br class="d-sm-none" />link reset password
                            </p>
                            <form class="d-flex align-items-center mb-5 needs-validation" method="POST"
                                action="{{ route('password.email') }}" novalidate="" onsubmit="showLoader()">
                                @csrf
                                <input class="form-control flex-1" id="email" type="email"
                                    placeholder="Alamat Email" required name="email" value="{{ old('email') }}" />
                                <button class="btn btn-primary ms-2">Kirim<span
                                        class="fas fa-chevron-right ms-2"></span></button>
                            </form>
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

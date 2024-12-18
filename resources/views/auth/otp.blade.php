<x-auth.layout>
    @slot('title')
        Halaman Login
    @endslot
    <main class="main" id="top">
        <div class="container">
            <div class="row flex-center min-vh-100 py-5">
                <div class="col-sm-10 col-md-8 col-lg-5 col-xxl-4"><a class="d-flex flex-center text-decoration-none mb-4"
                        href="{{ route('login') }}">
                        <div class="d-flex align-items-center fw-bolder fs-3 d-inline-block">
                            <img src="{{ $sets->web_logo ? Storage::url($sets->web_logo) : asset('backend/assets/img/default/nope.jpg') }}"
                                alt="logo {{ $sets->web_title }}" width="58" />
                        </div>
                    </a>
                    <div class="px-xxl-5">
                        <div class="text-center mb-6">
                            <h4 class="text-body-highlight">Masukkan Kode OTP</h4>
                            <p class="text-body-tertiary mb-0">
                                Silahkan masukkan kode OTP yang dikirimkan
                            </p>
                            <form class="verification-form" action="{{ route('otp.verify') }}" method="post"
                                data-2fa-form="data-2fa-form">
                                @csrf
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <input class="form-control px-2 text-center" name="otp[]"
                                        oninput="moveToNext(this)" type="number" />
                                    <input class="form-control px-2 text-center" name="otp[]"
                                        oninput="moveToNext(this)" type="number" />
                                    <input class="form-control px-2 text-center" name="otp[]"
                                        oninput="moveToNext(this)" type="number" /><span>-</span>
                                    <input class="form-control px-2 text-center" name="otp[]"
                                        oninput="moveToNext(this)" type="number" />
                                    <input class="form-control px-2 text-center" name="otp[]"
                                        oninput="moveToNext(this)" type="number" />
                                    <input class="form-control px-2 text-center" name="otp[]"
                                        oninput="moveToNext(this)" type="number" />
                                </div>
                                <div class="form-check text-start mb-4">
                                    <input class="form-check-input" id="2fa-checkbox" type="checkbox" />
                                    <label for="2fa-checkbox">Jangan tanya lagi di perangkat ini (1 bulan)</label>
                                </div>
                                <button class="btn btn-primary w-100 mb-5" type="submit" disabled="disabled">
                                    Verify
                                </button>
                                <a class="fs-9" href="#!">
                                    Kirim ulang kode OTP
                                </a>
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

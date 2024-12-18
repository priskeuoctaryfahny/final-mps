<x-auth.layout>
    @slot('title')
        Verify Email
    @endslot

    <main class="main" id="top">
        <div class="row vh-100 g-0">
            <div class="col-lg-12">
                <div class="row flex-center h-100 g-0 px-4 px-sm-0">
                    <div class="col col-sm-6 col-lg-7 col-xl-6">
                        <div class="text-center mb-7">
                            <h3 class="text-body-highlight">Verifikasi Email</h3>
                            <p class="text-body-tertiary">Silahkan verifikasi email</p>
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <div class="mb-4 text-sm text-center text-gray-600">
                            Verifikasi email anda untuk melanjutkan ke halaman selanjutnya, Link verifikasi email akan
                            dikirimkan ke email anda.
                        </div>

                        <div class="text-center">
                            <form class="needs-validation" method="POST" action="{{ route('verification.send') }}"
                                novalidate onsubmit="showLoader()">
                                @csrf
                                <div>
                                    <x-primary-button>
                                        {{ __('Kirim Link Verifikasi') }}
                                    </x-primary-button>
                                </div>
                            </form>

                            <form class="my-2" method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary">
                                    {{ __('Keluar') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-auth.layout>

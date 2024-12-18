<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST" action="{{ route('users.store') }}"
                onsubmit="showLoader()">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="name" type="text" name="name"
                            placeholder="Nama Lengkap" value="{{ old('name') }}" required />
                        <label for="name">Nama Lengkap</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="email" type="email" name="email"
                            placeholder="Alamat Email (Wajib aktif)" value="{{ old('email') }}" required />
                        <label for="email">Alamat Email (Wajib aktif)</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="password" type="password" name="password"
                            placeholder="Password" required />
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="confirm-password" type="password" name="confirm-password"
                            placeholder="Konfirmasi Password" required />
                        <label for="confirm-password">Konfirmasi Password</label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating form-floating-advance-select">
                        <label>Peran Akun</label>
                        <select class="form-select" id="roles" required name="roles">
                            <option hidden value="">Pilih Peran</option>
                            @foreach ($roles as $value => $label)
                                @if (old('roles') && old('roles') == $value)
                                    <option value="{{ old('roles') }}" selected>{{ $label }}</option>
                                @else
                                    <option value="{{ $value }}">
                                        {{ $label }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <a href="{{ route(explode('.', Route::current()->getName())[0] . '.index') }}"
                                class="btn btn-phoenix-primary px-5" type="button">Cancel</a>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dash.layout>

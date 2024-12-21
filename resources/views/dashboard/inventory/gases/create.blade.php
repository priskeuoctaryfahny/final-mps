<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-8">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST" action="{{ route('gases.store') }}"
                onsubmit="showLoader()">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="number" type="text" name="name"
                            placeholder="Nama/Tipe Gas" value="{{ old('name') }}" required />
                        <label for="name">Nama/Tipe Gas</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-floating form-floating-advance-select">
                            <label for="user_id">Penanggung Jawab</label>
                            <select class="form-select" id="user_id" data-choices="data-choices" size="1"
                                name="user_id" data-options='{"removeItemButton":true,"placeholder":true}' required>
                                <option value="" hidden>Pilih Penanggung Jawab</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- End of new input fields -->
                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Batal</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Tambah</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('header')
        <link rel="stylesheet" href="{{ asset('backend/vendors/choices/choices.min.css') }}">
    @endpush
    @push('footer')
        <script src="{{ asset('backend/vendors/choices/choices.min.js') }}"></script>
    @endpush
</x-dash.layout>

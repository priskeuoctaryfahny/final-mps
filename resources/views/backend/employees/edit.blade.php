<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('employees.update', $employee->id) }}" onsubmit="showLoader(event)">
                @csrf
                @method('PUT')
                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text"
                            name="name" placeholder="Nama Lengkap" value="{{ old('name', $employee->name) }}"
                            required />
                        <label for="name">Nama Lengkap</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('employee_identification_number') is-invalid @enderror"
                            id="employee_identification_number" type="text" name="employee_identification_number"
                            placeholder="NIP"
                            value="{{ old('employee_identification_number', $employee->employee_identification_number) }}"
                            required />
                        <label for="employee_identification_number">NIP</label>
                        @error('employee_identification_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('birth_place') is-invalid @enderror" id="birth_place"
                            type="text" name="birth_place" placeholder="Tempat Lahir"
                            value="{{ old('birth_place', $employee->birth_place) }}" required />
                        <label for="birth_place">Tempat Lahir</label>
                        @error('birth_place')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('birth_date') is-invalid @enderror" id="birth_date"
                            type="date" name="birth_date" placeholder="Tanggal Lahir"
                            value="{{ old('birth_date', $employee->birth_date->translatedFormat('Y-m-d')) }}"
                            required />
                        <label for="birth_date">Tanggal Lahir</label>
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('position_start_date') is-invalid @enderror"
                            id="position_start_date" type="date" name="position_start_date" placeholder="TMT Jabatan"
                            value="{{ old('position_start_date', $employee->position_start_date->translatedFormat('Y-m-d')) }}"
                            required />
                        <label for="position_start_date">TMT Jabatan</label>
                        @error('position_start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('position') is-invalid @enderror" id="position"
                            type="text" name="position" placeholder="Jabatan"
                            value="{{ old('position', $employee->position) }}" />
                        <label for="position">Jabatan</label>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('education_level') is-invalid @enderror" id="education_level"
                            name="education_level">
                            <option value="" hidden>Pilih Pendidikan Terakhir</option>
                            @foreach (['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'Diploma 3', 'Diploma 4 / Sarjana', 'Magister', 'Doktor', 'Profesional'] as $level)
                                <option value="{{ $level }}"
                                    {{ old('education_level', $employee->education_level) == $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                        <label for="education_level">Pendidikan Terakhir</label>
                        @error('education_level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('education_institution') is-invalid @enderror"
                            id="education_institution" type="text" name="education_institution"
                            placeholder="Nama Perguruan Tinggi"
                            value="{{ old('education_institution', $employee->education_institution) }}" />
                        <label for="education_institution">Nama Perguruan Tinggi</label>
                        @error('education_institution')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('major') is-invalid @enderror" id="major" type="text"
                            name="major" placeholder="Jurusan" value="{{ old('major', $employee->major) }}" />
                        <label for="major">Jurusan</label>
                        @error('major')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('graduation_date') is-invalid @enderror" id="graduation_date"
                            type="date" name="graduation_date" placeholder="Tanggal Lulus"
                            value="{{ old('graduation_date', optional($employee->graduation_date)->translatedFormat('Y-m-d')) }}" />
                        <label for="graduation_date">Tanggal Lulus</label>
                        @error('graduation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>



                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('unit_id') is-invalid @enderror" id="unit_id"
                            name="unit_id" required>
                            <option value="" hidden>Pilih Unit Kerja</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ old('unit_id', $employee->unit_id) == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="unit_id">Pilih Unit Kerja</label>
                        @error('unit_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                @if ($employee->user_id == false)
                    <div class="col-sm-12 col-md-6">
                        <div class="form-floating">
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                name="user_id">
                                <option value="" hidden>Hubungkan dengan akun {{ config('app.name', 'sistem') }}
                                </option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', $employee->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                                <option value="">Nanti saja</option>
                            </select>
                            <label for="user_id">Hubungkan dengan akun {{ config('app.name', 'sistem') }}</label>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif


                <div class="col-sm-12 col-md-6" id="email-field" style="display: none;">
                    <div class="form-floating">
                        <input class="form-control @error('email') is-invalid @enderror" id="email"
                            type="email" name="email" placeholder="Alamat Email (Wajib aktif)"
                            value="{{ old('email', $employee->email) }}" />
                        <label for="email">Alamat Email (Wajib aktif)</label>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Batal</button>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary px-5 px-sm-15">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-xl-3">
            @if ($employee->user_id)
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <select class="form-select" id="user_id" name="user_id" disabled>
                            <option value="{{ $employee->user_id }}" selected>{{ $employee->user->email }}
                            </option>
                        </select>
                        <label for="user_id">Akun terhubung pada email</label>
                        <div class="form-text">Status akun sudah terhubung</div>
                    </div>
                    <div class="mt-3">
                        <form method="POST" action="{{ route('employees.disconnect', $employee->id) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">Putuskan Koneksi</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @push('header')
        <link href="{{ asset('backend') }}/vendors/choices/choices.min.css" rel="stylesheet" />
    @endpush
    @push('footer')
        <script src="{{ asset('backend') }}/vendors/choices/choices.min.js"></script>
    @endpush
</x-dash.layout>

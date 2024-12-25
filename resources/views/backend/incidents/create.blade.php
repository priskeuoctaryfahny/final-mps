<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('incidents.store') }}" onsubmit="showLoader()">
                @csrf
                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('date') is-invalid @enderror" id="date" type="date"
                            name="date" placeholder="Tanggal" value="{{ old('date') }}" required />
                        <label for="date">Tanggal</label>
                        @error('date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('time') is-invalid @enderror" id="time" type="time"
                            name="time" placeholder="Waktu" value="{{ old('time') }}" required />
                        <label for="time">Waktu</label>
                        @error('time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('location') is-invalid @enderror" id="location"
                            type="text" name="location" placeholder="Lokasi" value="{{ old('location') }}" />
                        <label for="location">Lokasi</label>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('employee_id') is-invalid @enderror" id="employee_id"
                            name="employee_id" required>
                            <option value="" hidden>Pilih Karyawan</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}"
                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="employee_id">Pilih Karyawan</label>
                        @error('employee_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            placeholder="Deskripsi">{{ old('description') }}</textarea>
                        <label for="description">Deskripsi</label>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('severity') is-invalid @enderror" id="severity"
                            name="severity" required>
                            <option value="" hidden>Pilih Severity</option>
                            @foreach (['Critical', 'Hampir Terjadi', 'Sedang', 'Rendah'] as $level)
                                <option value="{{ $level }}" {{ old('severity') == $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                        <label for="severity">Severity</label>
                        @error('severity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('incident_type') is-invalid @enderror" id="incident_type"
                            name="incident_type" required>
                            <option value="" hidden>Pilih Tipe Insiden</option>
                            @foreach (['Gangguan', 'Psikolis', 'Penyakit', 'Cedera'] as $type)
                                <option value="{{ $type }}"
                                    {{ old('incident_type') == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        <label for="incident_type">Tipe Insiden</label>
                        @error('incident_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('injury_consequence') is-invalid @enderror"
                            id="injury_consequence" name="injury_consequence" required>
                            <option value="" hidden>Pilih Konsekuensi Cedera</option>
                            @foreach (['Tanpa Perawatan', 'Pertolongan Pertama', 'Perawatan Medis', 'Waktu Hilang'] as $consequence)
                                <option value="{{ $consequence }}"
                                    {{ old('injury_consequence') == $consequence ? 'selected' : '' }}>
                                    {{ $consequence }}
                                </option>
                            @endforeach
                        </select>
                        <label for="injury_consequence">Konsekuensi Cedera</label>
                        @error('injury_consequence')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('days_of_absence') is-invalid @enderror" id="days_of_absence"
                            type="number" name="days_of_absence" placeholder="Hari Ketidakhadiran"
                            value="{{ old('days_of_absence') }}" />
                        <label for="days_of_absence">Hari Ketidakhadiran</label>
                        @error('days_of_absence')
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
                            <button class="btn btn-primary px-5 px-sm-15">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dash.layout>

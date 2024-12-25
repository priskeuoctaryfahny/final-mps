<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST" action="{{ route('reports.store') }}"
                onsubmit="showLoader()">
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

                <div class="col-sm-12">
                    <div class="form-floating">
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            placeholder="Deskripsi" required>{{ old('description') }}</textarea>
                        <label for="description">Deskripsi</label>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status"
                            required>
                            <option value="" hidden>Pilih Status</option>
                            @foreach (['Positive', 'Warning', 'Critical'] as $status)
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        <label for="status">Status</label>
                        @error('status')
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
                        @error('employee _id')
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

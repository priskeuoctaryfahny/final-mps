<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="mb-9">
        <div id="employeeSummary" data-list='{"valueNames":["id", "name", "nip", "unit"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">{{ $title }}<span class="fw-normal text-body-tertiary ms-3"></span></h2>
                </div>
            </div>
            <form method="POST" action="{{ route('employees.bulkDestroy') }}" id="bulk-delete-form">
                @csrf
                @method('DELETE')
                <div class="row g-3 justify-content-between align-items-end mb-4">
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex align-items-center">
                            @can('employee-create')
                                <div class="mt-3 mx-2">
                                    <a class="btn btn-primary btn-sm" href="{{ route('employees.create') }}">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah
                                    </a>
                                </div>
                            @endcan
                            <div class="mt-3">
                                <button type="submit" class="btn btn-danger btn-sm" id="delete-selected"
                                    onclick="return confirm('Apakah anda yakin?')" disabled>
                                    <span class="fas fa-trash me-2"></span>Hapus yang dipilih
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-auto">
                        <div class="search-box me-3">
                            <form class="position-relative">
                                <input class="form-control search-input search" type="search"
                                    placeholder="Cari pegawai" aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive scrollbar">
                    <table class="table fs-9 mb-0 border-top border-translucent">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width:2%;">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="sort ps-3" scope="col" data-sort="id" style="width:6%;">No</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="name">Nama Lengkap
                                </th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="nip">NIP</th>
                                <th class="sort white-space-nowrap ps-0" scope="col">Tempat, Tanggal Lahir</th>
                                <th class="sort white-space-nowrap ps-0" scope="col">Jabatan</th>
                                <th class="sort white-space-nowrap ps-0" scope="col">Pendidikan</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="unit">Unit Kerja</th>
                                @canany(['employee-edit', 'employee-delete'])
                                    <th class="sort text-end" scope="col"></th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="list" id="employee-list-table-body">
                            @php $i = 0; @endphp
                            @foreach ($employees as $row)
                                <tr class="position-static">
                                    <td class="text-center ps-3">
                                        <input type="checkbox" name="employeeIds[]" value="{{ $row->id }}"
                                            class="select-item">
                                    </td>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="name">{{ $row->name }}</td>
                                    <td class="nip">{{ $row->employee_identification_number }}</td>
                                    <td>{{ $row->birth_place }}, {{ $row->birth_date->translatedFormat('d F Y') }}</td>
                                    <td>{{ $row->position }}</td>
                                    <td>{{ $row->education_level }}</td>
                                    <td class="unit">{{ $row->unit->name }}</td>
                                    @canany(['employee-edit', 'employee-delete'])
                                        <td class="text-end white-space-nowrap pe-0 action">
                                            <div class="btn-reveal-trigger position-static">
                                                <button
                                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                    type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                    aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                    @can('employee-edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('employees.edit', $row->id) }}">Edit</a>
                                                    @endcan
                                                    @can('employee-delete')
                                                        <div class="dropdown-divider"></div>
                                                        <form method="POST"
                                                            action="{{ route('employees.destroy', $row->id) }}"
                                                            style="display:inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger"
                                                                onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </div>
                                        </td>
                                    @endcanany
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div
                    class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs-9 border-bottom border-translucent">
                    <div class="d-flex">
                        <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                        </p>
                    </div>
                    <div class="d-flex">
                        <button class="page-link" data-list-pagination="prev"><span
                                class="fas fa-chevron-left"></span></button>
                        <ul class="mb-0 pagination"></ul>
                        <button class="page-link pe-0" data-list-pagination="next"><span
                                class="fas fa-chevron-right"></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dash.layout>

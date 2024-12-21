<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="mb-9">
        <div id="{{ $title }}Summary"
            data-list='{"valueNames":["id","nama", "user", "stok"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">{{ $title }}<span class="fw-normal text-body-tertiary ms-3"></span></h2>
                </div>
            </div>
            <div class="row g-3 justify-content-between align-items-end mb-4">
                <div class="col-12 col-sm-auto">
                    <div class="d-flex align-items-center">
                        @can('gas-create')
                            <div class="mt-3 mx-2">
                                <a href="{{ route('gases.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-plus me-2"></i>Tambah
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="col-12 col-sm-auto">
                    <div class="search-box me-3">
                        <form class="position-relative">
                            <input class="form-control search-input search" type="search" placeholder="Cari gas"
                                aria-label="Search" />
                            <span class="fas fa-search search-box-icon"></span>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive scrollbar">
                <table class="table fs-9 mb-0 border-top border-translucent">
                    <thead>
                        <tr>
                            <th class="sort  ps-3" scope="col" data-sort="id" style="width:6%;">No
                            </th>
                            <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="nama">
                                Nama Gas</th>
                            <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="user">
                                Penanggung Jawab</th>
                            <th class="sort white-space-nowrap  ps-0" scope="col" data-sort="stok">Stok</th>
                            @canany(['gas-edit', 'gas-delete', 'gas-download'])
                                <th class="sort text-end" scope="col"></th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="list" id="project-list-table-body">
                        @php $i = 0; @endphp
                        @foreach ($gases as $row)
                            <tr class="position-static">
                                <td class=" text-center time white-space-nowrap ps-0 id py-4">
                                    {{ ++$i }}</td>
                                <td class=" time white-space-nowrap ps-0 nama py-4">
                                    {{ $row->name }}
                                </td>
                                <td class=" time white-space-nowrap ps-0 user py-4">
                                    {{ $row->user->name }}
                                </td>
                                <td class=" time white-space-nowrap ps-0 stok py-4">
                                    {{ $row->total ?? 0 }}
                                </td>
                                @canany(['gas-edit', 'gas-delete'])
                                    <td class=" text-end white-space-nowrap pe-0 action">
                                        <div class="btn-reveal-trigger position-static">
                                            <button
                                                class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                                                <span class="fas fa-ellipsis-h fs-10"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end py-2">
                                                @can('gas-edit')
                                                    <a class="dropdown-item" href="{{ route('gases.edit', $row->id) }}">Edit</a>
                                                @endcan
                                                @can('gas-delete')
                                                    <div class="dropdown-divider"></div>
                                                    <form method="POST" action="{{ route('gases.destroy', $row->id) }}"
                                                        style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Apakah anda yakin?')">Remove</button>
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
                    <a class="fw-semibold" href="#!" data-list-view="*">View all<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                    <a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="d-flex">
                    <button class="page-link" data-list-pagination="prev"><span
                            class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span
                            class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>
</x-dash.layout>

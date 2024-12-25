<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="mb-9">
        <div id="incident Summary"
            data-list='{"valueNames":["id", "date", "time", "location", "description", "severity", "incident_type"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">{{ $title }}</h2>
                </div>
            </div>
            <form method="POST" action="{{ route('incidents.bulkDestroy') }}" id="bulk-delete-form">
                @csrf
                @method('DELETE')
                <div class="row g-3 justify-content-between align-items-end mb-4">
                    <div class="col-12 col-sm-auto">
                        <div class="d-flex align-items-center">
                            @can('incident-create')
                                <div class="mt-3 mx-2">
                                    <a class="btn btn-primary btn-sm" href="{{ route('incidents.create') }}">
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
                </div>

                <div class="table-responsive scrollbar">
                    <table class="table fs-9 mb-0 border-top border-translucent">
                        <thead>
                            <tr>
                                <th class="ps-3" style="width:2%;">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th class="sort ps-3" scope="col" data-sort="id" style="width:6%;">No</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="date">Tanggal</th>
                                <th class="sort white-space-nowrap ps-0" scope="col" data-sort="time">Waktu</th>
                                <th class="sort white-space-nowrap ps-0" scope="col">Lokasi</th>
                                <th class="sort white-space-nowrap ps-0" scope="col">Deskripsi</th>
                                <th class="sort white-space-nowrap ps-0" scope="col">Severity</th>
                                <th class="sort white-space-nowrap ps-0" scope="col">Tipe Insiden</th>
                                @canany(['incident-edit', 'incident-delete'])
                                    <th class="sort text-end" scope="col"></th>
                                @endcanany
                            </tr>
                        </thead>
                        <tbody class="list" id="incident-list-table-body">
                            @php $i = 0; @endphp
                            @foreach ($incidents as $incident)
                                <tr>
                                    <td class="text-center ps-3">
                                        <input type="checkbox" name="incidentIds[]" value="{{ $incident->id }}"
                                            class="select-item">
                                    </td>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="date">{{ $incident->date }}</td>
                                    <td class="time">{{ $incident->time }}</td>
                                    <td>{{ $incident->location }}</td>
                                    <td>{{ $incident->description }}</td>
                                    <td>{{ $incident->severity }}</td>
                                    <td>{{ $incident->incident_type }}</td>
                                    @canany(['incident-edit', 'incident-delete'])
                                        <td class="text-end white-space-nowrap pe-0 action">
                                            <div class="btn-reveal-trigger position-static">
                                                <button
                                                    class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                    type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <span class="fas fa-ellipsis-h fs-10"></span>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end py-2">
                                                    @can('incident-edit')
                                                        <a class="dropdown-item"
                                                            href="{{ route('incidents.edit', $incident->id) }}">Edit</a>
                                                    @endcan
                                                    @can('incident-delete')
                                                        <div class="dropdown-divider"></div>
                                                        <form method="POST"
                                                            action="{{ route('incidents.destroy', $incident->id) }}"
                                                            style="display:inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger"
                                                                onclick="return confirm('Apakah anda yakin?')">Hapus </button>
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
            </form>
        </div>
    </div>
</x-dash.layout>

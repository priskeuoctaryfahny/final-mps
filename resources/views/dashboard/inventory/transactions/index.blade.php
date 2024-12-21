<x-dash.layout>
    @push('header')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    @endpush
    @slot('title')
        {{ $title }}
    @endslot


    <div class="mb-9">
        <div id="{{ $title }}Data">
            <div class="row g-3 justify-content-end align-items-end mb-4">
                <div class="card col-md-12 mb-4">
                    <div class="p-6 m-20 bg-inherit rounded shadow" id="chart-container">
                        {!! $chart->container() !!}
                    </div>
                </div>
            </div>
            <div class="card d-print-none shadow-none border my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="mb-0" autofocus>{{ $title }}<span
                                    class="fw-normal text-body-tertiary ms-3"></span></h4>
                        </div>
                        <div class="col col-md-auto">
                            <nav class="nav justify-content-end doc-tab-nav align-items-center" role="tablist">

                                @can('transaction-create')
                                    <div class="btn-group">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                id="createDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-plus me-2"></i>Tambah
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="createDropdown">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('transactions.create.in', $id) }}">
                                                        Gas Masuk
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('transactions.create.out', $id) }}">
                                                        Gas Keluar
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @endcan
                                @can('transaction-download')
                                    <button class="btn btn-sm btn-info mx-2" type="button" id="importDropdown"
                                        data-bs-toggle="modal" data-bs-target="#importModal" data-format="pdf">
                                        <i class="fa-solid fa-file-import me-2"></i>Import
                                    </button>

                                    <div class="modal fade" id="importModal" tabindex="-1"
                                        aria-labelledby="importModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="importModalLabel">Impor Data</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row g-3" enctype="multipart/form-data" id="importForm"
                                                        action="{{ route('transactions.import') }}" method="post">
                                                        @csrf
                                                        <div class="col-md-12">
                                                            <input type="file" name="importFile" class="form-control">
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="alert alert-info fw-bold text-white">
                                                                Format XLS, XLSX dan CSV
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="submitImport">Impor</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // submit the form
                                            document.getElementById('submitImport').addEventListener('click', function() {
                                                document.getElementById('importForm').submit();
                                            });
                                        })
                                    </script>

                                    <x-dash.export-button />


                                    <div class="modal fade" id="exportModal" tabindex="-1"
                                        aria-labelledby="exportModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exportModalLabel">Filter dan Ekspor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form class="row g-3" id="exportForm"
                                                        action="{{ route('transactions.export', ['format' => 'pdf']) }}"
                                                        method="get">
                                                        @csrf
                                                        <div class="col-md-12">
                                                            <div class="form-floating form-floating-advance-select">
                                                                <label for="columns">Kolom yang akan diekspor</label>
                                                                <select class="form-select" id="columns"
                                                                    data-choices="data-choices" multiple="multiple"
                                                                    name="columns[]"
                                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                    @foreach ($columns as $column)
                                                                        <option value="{{ $column }}">
                                                                            {{ $columnLabels[$column] ?? $column }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-floating form-floating-advance-select ">
                                                                <label for="startDate">Tanggal Awal</label>
                                                                <input type="date" class="form-control"
                                                                    name="startDate" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-floating form-floating-advance-select ">
                                                                <label for="endDate">Tanggal akhir</label>
                                                                <input type="date" class="form-control" name="endDate"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-floating form-floating-advance-select ">
                                                                <label for="paperSize">Ukuran Kertas</label>
                                                                <select class="form-select" id="paperSize"
                                                                    name="paperSize" data-choices="data-choices"
                                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                    <option value="A0">A0</option>
                                                                    <option value="A1">A1</option>
                                                                    <option value="A2">A2</option>
                                                                    <option value="A3">A3</option>
                                                                    <option value="A4">A4</option>
                                                                    <option value="A5">A5</option>
                                                                    <option value="A6">A6</option>
                                                                    <option value="A7">A7</option>
                                                                    <option value="A8">A8</option>
                                                                    <option value="A9">A9</option>
                                                                    <option value="A10">A10</option>
                                                                    <option value="C4">C4</option>
                                                                    <option value="C5">C5</option>
                                                                    <option value="C6">C6</option>
                                                                    <option value="C7">C7</option>
                                                                    <option value="Letter">Letter</option>
                                                                    <option value="F4">F4</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-floating form-floating-advance-select ">
                                                                <label for="orientation">Orientasi Kertas</label>
                                                                <select class="form-select" id="orientation"
                                                                    name="orientation" data-choices="data-choices"
                                                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                                                    <option value="portrait">Portrait</option>
                                                                    <option value="landscape">Landscape</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="alert alert-danger fw-bold">
                                                                Abaikan ukuran dan orientasi kertas bila memilih format
                                                                Excel
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="format" id="exportFormat"
                                                            value="">
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="submitExport">Ekspor</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const exportButtons = document.querySelectorAll('.dropdown-item[data-bs-toggle="modal"]');
                                            const exportFormatInput = document.getElementById('exportFormat');
                                            const exportForm = document.getElementById('exportForm');
                                            const columnsSelect = document.getElementById('columns');
                                            const startDateInput = document.querySelector('input[name="startDate"]');
                                            const endDateInput = document.querySelector('input[name="endDate"]');

                                            exportButtons.forEach(button => {
                                                button.addEventListener('click', function() {
                                                    const format = this.getAttribute(
                                                        'data-format'); // Get the format from data attribute
                                                    exportFormatInput.value = format; // Set the format value
                                                    exportForm.action = "{{ route('transactions.export', '') }}/" +
                                                        format; // Set the form action
                                                });
                                            });

                                            document.getElementById('submitExport').addEventListener('click', function() {
                                                // Validate the form
                                                const selectedColumns = Array.from(columnsSelect.selectedOptions).map(option => option
                                                    .value);
                                                const startDate = startDateInput.value;
                                                const endDate = endDateInput.value;

                                                if (selectedColumns.length === 0) {
                                                    alert('Silakan pilih kolom yang akan diekspor.');
                                                    return;
                                                }

                                                if (!startDate) {
                                                    alert('Silakan masukkan tanggal awal.');
                                                    return;
                                                }

                                                if (!endDate) {
                                                    alert('Silakan masukkan tanggal akhir.');
                                                    return;
                                                }

                                                if (new Date(startDate) > new Date(endDate)) {
                                                    alert('Tanggal akhir harus lebih besar dari tanggal awal.');
                                                    return;
                                                }

                                                exportForm.submit(); // Submit the form if all validations pass
                                            });
                                        });
                                    </script>

                                    @push('header')
                                        <link href="{{ asset('backend') }}/vendors/choices/choices.min.css"
                                            rel="stylesheet" />
                                    @endpush
                                    @push('footer')
                                        <script src="{{ asset('backend/vendors/choices/choices.min.js') }}"></script>
                                    @endpush

                                @endcan
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive-sm scrollbar">
                        <table class="table table-bordered table-striped" id="yajra" width="100%">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th width="1%">No</th>
                                    @foreach ($columnDetail as $column => $details)
                                        <th class="text-center">{{ ucwords($details['label']) }}</th>
                                    @endforeach
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('footer')
        <script src="{{ asset('vendor/larapex-charts/apexcharts.js') }}"></script>
        <script>
            $(document).ready(function() {
                tableYajra();
            });

            // datatable serverside
            function tableYajra() {
                $('#yajra').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "/transactions/serverside/{{ $id }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: true,
                            searchable: true
                        },
                        @foreach ($columnDetail as $column => $details)
                            {
                                data: '{{ $column }}',
                                name: '{{ $column }}'
                            },
                        @endforeach {
                            data: 'action',
                            name: 'action',
                        }
                    ]
                });
            };

            const deleteData = (e) => {
                let id = e.getAttribute('data-id');

                Swal.fire({
                    title: "Apakah anda yakin?",
                    text: "Apakah anda ingin menghapus data ini?",
                    icon: "question",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    showCloseButton: true
                }).then((result) => {
                    if (result.value) {

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: "/transactions/" + id,
                            dataType: "json",
                            success: function(response) {
                                reloadTable();
                                toastSuccess(response.message);
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                    }
                })
            }
        </script>
        {{ $chart->script() }}
    @endpush
</x-dash.layout>

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

                                @can('user-create')
                                    <a class="btn btn-sm btn-primary" href="{{ route('users.create') }}">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah
                                    </a>
                                @endcan
                                @can('user-download')
                                    <x-dash.import-button />
                                    <x-dash.export-button />
                                    <x-dash.export-modal :columns="json_encode($columns)" :columnLabels="json_encode($columnLabels)" />
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
            let submit_method;

            $(document).ready(function() {
                tableYajra();
            });

            // datatable serverside
            function tableYajra() {
                $('#yajra').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "/users/serverside",
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
                            url: "/users/" + id,
                            dataType: "json",
                            success: function(response) {
                                reloadTable();
                                toastSuccess(response.message);
                            },
                            error: function(response) {
                                toastError(response.message);
                            }
                        });
                    }
                })
            }

            const editableColumns = [1, 2, 3];
            let currentEditableRow = null;

            $('table').on('click', '#btn-edit', function(e) {
                const userId = $(this).data('id');
                const currentRow = $(this).closest('tr');

                if (currentEditableRow && currentEditableRow !== currentRow) {
                    resetEditableRow(currentEditableRow);
                }
                makeEditableRow(currentRow);
                currentEditableRow = currentRow;

                currentRow.find('td:last').html(
                    '<button class="btn btn-sm btn-primary btn-save" data-id="' + userId +
                    '"><i class="fas fa-check"></i></button>'
                )

            });



            function makeEditableRow(currentRow) {
                currentRow.find('td').each(function(index) {
                    const currentCell = $(this);
                    const currentText = currentCell.text().trim();
                    if (editableColumns.includes(index)) {
                        currentCell.html('<input type="text" class="form-control editable-input"  value="' +
                            currentText + '" />');
                    }
                })
            }

            function resetEditableRow(currentEditableRow) {
                currentEditableRow.find('td').each(function(index) {
                    const currentCell = $(this);
                    if (editableColumns.includes(index)) {
                        const currentValue = currentCell.find('input').val();
                        currentCell.html(`${currentValue}`);
                    }
                })

                const userId = currentEditableRow.find('.btn-save').data('id');
                currentEditableRow.find('td:last').html(`
                <div class="btn-group mx-1">
                        <button id="btn-edit" type="button"  class="btn btn-sm btn-warning btn-save" data-id="' . ${userId} . '">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(this)" data-id="' . ${userId} . '">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                `);
            }

            $('table').on('click', '.btn-save', function(e) {
                const userId = $(this).data('id');
                const currentRow = $(this).closest('tr');
                const updatedUserData = {};
                currentRow.find('td').each(function(index) {
                    if (editableColumns.includes(index)) {
                        const inputValue = $(this).find('input').val();

                        if (index === 1)
                            updatedUserData.name = inputValue;
                        if (index === 2)
                            updatedUserData.email = inputValue;
                        if (index === 3)
                            updatedUserData.gender = inputValue;
                    }
                })

                $.ajax({
                    url: '{{ route('users.liveupdate') }}',
                    type: 'PUT',
                    data: {
                        id: userId,
                        name: updatedUserData.name,
                        email: updatedUserData.email,
                        gender: updatedUserData.gender,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        reloadTable();
                        toastSuccess(response.message);
                    },
                    error: function(response) {
                        console.log(response);
                        toastErrorOri(response.responseText);
                    }
                })
            })
        </script>
        {{ $chart->script() }}
    @endpush
</x-dash.layout>

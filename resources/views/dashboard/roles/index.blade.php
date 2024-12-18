<x-dash.layout>
    @push('header')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    @endpush
    @slot('title')
        {{ $title }}
    @endslot


    <div class="mb-9">
        <div id="{{ $title }}Data">
            <div class="card shadow-none border my-4" data-component-card="data-component-card">
                <div class="card-header p-4 border-bottom bg-body">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="mb-0">{{ $title }}<span class="fw-normal text-body-tertiary ms-3"></span>
                            </h4>
                        </div>
                        <div class="col col-md-auto">
                            <nav class="nav justify-content-end doc-tab-nav align-items-center" role="tablist">

                                @can('role-create')
                                    <a class="btn btn-sm btn-primary mx-2" href="{{ route('roles.create') }}">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah
                                    </a>
                                @endcan
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive-sm scrollbar d-print-none">
                        <table class="table table-bordered table-striped" id="yajra" width="100%">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    @foreach ($columnDetail as $column => $details)
                                        <th>{{ ucwords($details['label']) }}</th>
                                    @endforeach
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
        <script>
            let submit_method;

            $(document).ready(function() {
                roleTable();
            });

            // datatable serverside
            function roleTable() {
                $('#yajra').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "/roles/serverside",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        @foreach ($columnDetail as $column => $details)
                            {
                                data: '{{ $column }}',
                                name: '{{ $column }}'
                            },
                        @endforeach {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            searchable: true
                        },
                    ]
                });
            };

            const deleteData = (e) => {
                let id = e.getAttribute('data-id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to delete this article?",
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
                            url: "/roles/" + id,
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
    @endpush
</x-dash.layout>

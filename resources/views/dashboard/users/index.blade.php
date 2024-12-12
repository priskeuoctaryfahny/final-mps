<x-dash.layout>
    @push('header')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    @endpush
    @slot('title')
        {{ $title }}
    @endslot


    <div class="mb-9 d-print-none">
        <div id="projectSummary">
            <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">{{ $title }}<span class="fw-normal text-body-tertiary ms-3"></span></h2>
                </div>


                @can('user-download')
                    <div class="col-auto">
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="exportDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-file-export me-2"></i>Export
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                    <li>
                                        <form action="{{ route('users.export', 'pdf') }}" method="get" id="exportPdfForm">
                                            <button class="dropdown-item" type="submit">
                                                Export PDF
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('users.export', 'excel') }}" method="get"
                                            id="exportExcelForm">
                                            <button class="dropdown-item" type="submit">
                                                Export Excel
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" onclick="window.print()">
                                            Export Diagram
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>


            <div class="row g-3 justify-content-end align-items-end mb-4">
                <div class="col-md-12 mb-4">
                    <div class="p-6 m-20 bg-white rounded shadow" id="chart-container">
                        {!! $chart->container() !!}
                    </div>
                </div>
                @can('user-create')
                    <div class="col-auto"><a class="btn btn-sm btn-primary px-5" href="{{ route('users.create') }}"><i
                                class="fa-solid fa-plus me-2"></i>Add new user</a></div>
                @endcan
            </div>
            <div class="table-responsive-sm scrollbar">
                <table class="table table-bordered table-striped" id="yajra" width="100%">
                    <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('footer')
        <script src="https://code.jquery.com/jquery-4.0.0-beta.2.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('vendor/larapex-charts/apexcharts.js') }}"></script>
        <script src={{ asset('backend/js/helper.js') }}></script>
        <script src={{ asset('backend/js/dashboard/user.js') }}></script>
        {{ $chart->script() }}
    @endpush
</x-dash.layout>

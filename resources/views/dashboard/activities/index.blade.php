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

                                @can('user-download')
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
                activityTable();
            });

            // datatable serverside
            function activityTable() {
                $('#yajra').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: "/activities/serverside",
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
                        @endforeach
                    ]
                });
            };
        </script>
        {{ $chart->script() }}
    @endpush
</x-dash.layout>

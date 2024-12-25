<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="row gy-3 mb-6 justify-content-between">
        <div class="col-md-9 col-auto">
            <h2 class="mb-2 text-body-emphasis">{{ $sets->web_title ?? config('app.name') }} Dashboard</h2>
            <h5 class="text-body-tertiary fw-semibold">Kartu Informasi dan Grafik</h5>
        </div>
        <div class="col-md-3 col-auto">
            <input class="form-control ps-6" id="filterDashboard" type="date" />
        </div>
    </div>
    <div class="row mb-3 gy-6">
        <div class="col-12 col-xxl-12">
            <div class="row align-items-center g-3 g-xxl-0 h-100 align-content-between">
                <div class="col-3 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                    <div class="d-flex align-items-center"><span
                            class="fs-4 lh-1 uil uil-books text-primary-dark"></span>
                        <div class="ms-2">
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 me-2">{{ $incidents }}</h2><span
                                    class="fs-7 fw-semibold text-body">Insiden</span>
                            </div>
                            <p class="text-body-secondary fs-9 mb-0">Total Insiden</p>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                    <div class="d-flex align-items-center"><span
                            class="fs-4 lh-1 uil uil-users-alt text-success-dark"></span>
                        <div class="ms-2">
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 me-2">{{ $employees }}</h2><span
                                    class="fs-7 fw-semibold text-body">Pegawai</span>
                            </div>
                            <p class="text-body-secondary fs-9 mb-0">Pegawai yang terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                    <div class="d-flex align-items-center"><span
                            class ="fs-4 lh-1 uil uil-invoice text-warning-dark"></span>
                        <div class="ms-2">
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 me-2">{{ $units }}</h2><span
                                    class="fs-7 fw-semibold text-body">Unit</span>
                            </div>
                            <p class="text-body-secondary fs-9 mb-0">Unit Kerja yang terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-3 col-sm-6 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                    <div class="d-flex align-items-center"><span
                            class="fs-4 lh-1 uil uil-refresh text-danger-dark"></span>
                        <div class="ms-2">
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 me-2">{{ $stsps }}</h2><span
                                    class="fs-7 fw-semibold text-body">ST/SP</span>
                            </div>
                            <p class="text-body-secondary fs-9 mb-0">Status ST/SP</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-7 pb-3 border-y">
        <div class="row">
            <div class="col-12 col-xl-12 col-xxl-12">
                <div class="row g-3 mb-3">
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="card mb-4">
                            <div class="p-6 m-20 bg-inherit rounded shadow" id="chart-container">
                                {!! $stSpChart->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="card mb-4">
                            <div class="p-6 m-20 bg-inherit rounded shadow" id="chart-container">
                                {!! $severityChart->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="card mb-4">
                            <div class="p-6 m-20 bg-inherit rounded shadow" id="chart-container">
                                {!! $typeChart->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="card mb-4">
                            <div class="p-6 m-20 bg-inherit rounded shadow" id="chart-container">
                                {!! $consequenceChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('footer')
        <script src="{{ asset('vendor/larapex-charts/apexcharts.js') }}"></script>
        {!! $stSpChart->script() !!}
        {!! $severityChart->script() !!}
        {!! $typeChart->script() !!}
        {!! $consequenceChart->script() !!}
    @endpush
</x-dash.layout>

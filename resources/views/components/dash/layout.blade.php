<x-dash.header>
    {{ $title }}
</x-dash.header>

<x-dash.sidebar />

<x-dash.navbar>
    {{ Str::lower($title) }}
</x-dash.navbar>

{{ $slot }}

<x-dash.footer>
    {{ $title }}
    @slot('footer')
        <footer class="footer position-absolute">
            <div class="row g-0 justify-content-between align-items-center h-100">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 mt-2 mt-sm-0 text-body">
                        {{ $sets->web_title ? $sets->web_title : config('app.name') }}<span
                            class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br
                            class="d-sm-none" />2024 &copy; {{ __('text-ui.copyright') }}
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-body-tertiary text-opacity-85">v1.0.0 Beta</p>
                </div>
            </div>
        </footer>
    @endslot
</x-dash.footer>

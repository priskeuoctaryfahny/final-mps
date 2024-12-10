<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="d-flex flex-center content-min-h">
        <div class="text-center py-9"><img class="img-fluid mb-7 d-dark-none"
                src="{{ asset('backend') }}/assets/img/spot-illustrations/2.png" width="470" alt="" /><img
                class="img-fluid mb-7 d-light-none" src="{{ asset('backend') }}/assets/img/spot-illustrations/dark_2.png"
                width="470" alt="" />
            <h1 class="text-body-secondary fw-normal mb-5">Create Something Beautiful.</h1><a
                class="btn btn-lg btn-primary" href="{{ asset('backend') }}/documentation/getting-started.html">Getting
                Started</a>
        </div>
    </div>

</x-dash.layout>

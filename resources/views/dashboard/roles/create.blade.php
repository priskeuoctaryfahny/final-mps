<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    <h2 class="mb-4">{{ $title }}</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST" action="{{ route('roles.store') }}"
                onsubmit="showLoader()">
                @csrf
                <div class="col-sm-12 col-md-12">
                    <div class="form-floating">
                        <input class="form-control" id="floatingInputGrid" type="text" name="name"
                            placeholder="Name" required />
                        <label for="floatingInputGrid">Name</label>
                    </div>
                </div>
                <div class="col-12 gy-6">
                    <div class="form-floating form-floating-advance-select">
                        <label>Add Permission</label>
                        <select class="form-select" id="organizerMultiple" data-choices="data-choices"
                            multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}' required
                            name="permission[]">
                            <option hidden value="">Select Permission</option>
                            @foreach ($permission as $row)
                                <option value="{{ $row->id }}">{{ $row->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Cancel</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('header')
        <link rel="stylesheet" href="{{ asset('backend/vendors/choices/choices.min.css') }}">
    @endpush
    @push('footer')
        <script src="{{ asset('backend/vendors/choices/choices.min.js') }}"></script>
    @endpush
</x-dash.layout>

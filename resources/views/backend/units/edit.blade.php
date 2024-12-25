<x-dash.layout>
    @slot('title')
        Edit Unit
    @endslot
    <h2 class="mb-4">Edit Unit</h2>
    <div class="row">
        <div class="col-xl-9">
            <form class="row g-3 mb-6 needs-validation" novalidate="" method="POST"
                action="{{ route('units.update', $unit->id) }}" onsubmit="showLoader()">
                @csrf
                @method('PUT')

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text"
                            name="name" placeholder="Unit Name" value="{{ old('name', $unit->name) }}" required />
                        <label for="name">Unit Name</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="form-floating">
                        <input class="form-control @error('description') is-invalid @enderror" id="description"
                            type="text" name="description" placeholder="Description"
                            value="{{ old('description', $unit->description) }}" />
                        <label for="description">Description</label>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 gy-6">
                    <div class="row g-3 justify-content-end">
                        <div class="col-auto">
                            <button class="btn btn-phoenix-primary px-5" type="button"
                                onclick="window.history.back()">Cancel</button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary px-5 px-sm-15">Update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-dash.layout>

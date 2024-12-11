<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="row align-items-center justify-content-between g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">{{ $title }}</h2>
        </div>
    </div>
    <div class="mb-5" style="page-break-before: always">
        <form class="row gx-3 gy-4 mb-5" method="POST" enctype="multipart/form-data"
            action="{{ route('settings.update', $setting->id) }}" onsubmit="showLoader()">
            @csrf
            @method('PUT')
            <div class="col-12 col-lg-6">
                <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                    for="web_logo">{{ __('form.label.setting.web_logo') }}</label>
                <input class="form-control" id="web_logo" type="file" name="web_logo" accept="image/*" />
                <div class="text-center">
                    <img src="{{ $setting->web_logo ? Storage::url($setting->web_logo) : asset('backend/assets/img/default/nope.jpg') }}"
                        class="img-fluid p-2" style="width: 200px">
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                    for="web_favicon">{{ __('form.label.setting.web_favicon') }}</label>
                <input class="form-control" id="web_favicon" type="file" name="web_favicon" accept="image/*" />
                <div class="text-center">
                    <img src="{{ $setting->web_favicon ? Storage::url($setting->web_favicon) : asset('backend/assets/img/default/nope.jpg') }}"
                        class="img-fluid p-2" style="width: 200px">
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                    for="web_title">{{ __('form.label.setting.web_title') }}</label>
                <input class="form-control" id="web_title" type="text"
                    placeholder="{{ __('form.placeholder.setting.web_favicon') }}" name="web_title"
                    value="{{ $setting->web_title }}" />
            </div>
            <div class="col-12 col-lg-12">
                <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm" for="web_description">
                    {{ __('form.label.setting.web_description') }}
                </label>
                <textarea class="form-control" id="web_description"
                    placeholder="{{ __('form.placeholder.setting.web_description') }}"name="web_description">{{ $setting->web_description }}</textarea>
            </div>
            <div class="col-12 col-lg-6">
                <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                    for="web_email">{{ __('form.label.setting.web_email') }}</label>
                <input class="form-control" id="web_email" type="email"
                    placeholder="{{ __('form.placeholder.setting.web_email') }}" name="web_email"
                    value="{{ $setting->web_email }}" />
            </div>
            <div class="col-12 col-lg-6">
                <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                    for="web_phone">{{ __('form.label.setting.web_phone') }}</label>
                <input class="form-control" id="web_phone" type="tel"
                    placeholder="{{ __('form.placeholder.setting.web_phone') }}" name="web_phone"
                    value="{{ $setting->web_phone }}" />
            </div>
            <div class="col-12 col-lg-6">
                <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                    for="web_address">{{ __('form.label.setting.web_address') }}</label>
                <input class="form-control" id="web_address" type="text"
                    placeholder="{{ __('form.placeholder.setting.web_address') }}" name="web_address"
                    value="{{ $setting->web_address }}" />
            </div>
            <div class="col-12 col-lg-6">
                <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                    for="web_default_user_role">{{ __('form.label.setting.web_default_user_role') }}</label>
                <select class="form-select" id="web_default_user_role" name="web_default_user_role">
                    <option value="{{ $setting->role->id }}" hidden>
                        {{ $setting->role->name }}
                    </option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-end">
                <button class="btn btn-primary px-7">{{ __('form.button.update') }}</button>
            </div>
        </form>
    </div>

</x-dash.layout>

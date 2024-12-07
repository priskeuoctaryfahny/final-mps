<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot
    @if (request()->routeIs('profiles.edit'))
        <form method="post" action="{{ route('profiles.update', Auth::user()->id) }}"
            class="row g-3 mb-3 needs-validation" novalidate="" enctype="multipart/form-data" onsubmit="showLoader()">
            @csrf
            @method('patch')
    @endif

    <div class="row align-items-center justify-content-between g-3 mb-4">
        <div class="col-auto">
            <h2 class="mb-0">Profile</h2>
        </div>
        <div class="col-auto">
            <div class="row g-2 g-sm-3">
                @if (request()->routeIs('profiles.edit'))
                    <div class="col-auto">
                        <a href="{{ route('profiles.index') }}" class="btn btn-secondary btn-sm"
                            onclick="return confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')">
                            <i class="fas fa-arrow-left"></i> Go Back
                        </a>
                    </div>
                @else
                    <div class="col-auto d-print-none">
                        <button class="btn btn-phoenix-warning" href="#"
                            onclick="printAndRedirect('{{ route('profiles.index') }}')">
                            <span class="fas fa-print me-2"></span>Print
                        </button>
                    </div>

                    <script>
                        function printAndRedirect(pdfUrl) {
                            // Open the PDF in a new window
                            var printWindow = window.open(pdfUrl);

                            // Wait for the PDF to load
                            printWindow.onload = function() {
                                // Trigger the print dialog
                                printWindow.print();

                                // Close the current tab after printing or canceling (with a slight delay)
                                setTimeout(function() {
                                    window.close(); // Close the current tab
                                }, 1000); // Adjust delay if needed
                            };
                        }
                    </script>
                    <div class="col-auto d-print-none">
                        <a class="btn btn-phoenix-secondary" href="{{ route('profiles.edit', Auth::user()->id) }}"><span
                                class="fas fa-edit me-2"></span>Edit Profile</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row g-3 mb-6">
        <div class="col-12 col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="border-bottom border-dashed pb-4">
                        <div class="row align-items-center g-3 g-sm-5 text-center text-sm-start">
                            <div class="col-12 col-sm-auto d-flex justify-content-center">

                                @if (request()->routeIs('profiles.edit'))
                                    <input type="file" name="picture" class="d-none" id="picture" accept="image/*">
                                    <div class="hoverbox" style="width: 150px; height: 150px">
                                        <div class="hoverbox-content rounded-circle d-flex flex-center z-1"
                                            style="--phoenix-bg-opacity: .56;">
                                            <span class="fa-solid fa-camera fs-1 text-body-quaternary"></span>
                                        </div>
                                        <div
                                            class="position-relative bg-body-quaternary rounded-circle cursor-pointer d-flex flex-center mb-xxl-7">
                                            <div class="avatar avatar-5xl">
                                                <img class="rounded-circle text-center"
                                                    src="{{ $user->picture ? Storage::url($user->picture) : asset('assets/assets/img/team/1.webp') }}"
                                                    alt="Profile Picture" />
                                            </div>
                                            <label class="w-100 h-100 position-absolute z-1" for="picture"></label>
                                        </div>
                                    </div>
                                @else
                                    <div class="avatar avatar-5xl">
                                        <img class="rounded-circle text-center"
                                            src="{{ $user->picture ? Storage::url($user->picture) : asset('assets/assets/img/team/1.webp') }}"
                                            alt="Profile Picture" />
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-auto flex-1">
                                <h3>
                                    {{ auth()->user()->name }}
                                </h3>
                                <p class="text-body-secondary">
                                    {{ auth()->user()->email }}
                                </p>
                                <div>
                                    <a class="me-2" href="https://wa.me/62{{ substr(auth()->user()->whatsapp, 1) }}"
                                        target="_blank">
                                        <span
                                            class="fab fa-whatsapp text-body-quaternary text-opacity-75 text-primary-hover"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-between-center pt-4">
                        <div>
                            <h6 class="mb-2 text-body-secondary">Total Activities</h6>
                            <h4 class="fs-7 text-body-highlight mb-0">
                                {{ auth()->user()->activities->count() }}
                            </h4>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-2 text-body-secondary">Registered at</h6>
                            <h4 class="fs-7 text-body-highlight mb-0">
                                {{ date('d M Y', strtotime(auth()->user()->created_at)) }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="border-bottom border-dashed">
                        <h4 class="mb-3">
                            Additional Information
                        </h4>
                    </div>
                    <div class="pt-4 mb-7 mb-lg-4 mb-xl-7">
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <h5 class="text-body-highlight">Location</h5>
                            </div>
                            <div class="col-auto">
                                <p class="text-body-secondary">
                                    @if ($location)
                                        {{ $location->regionName }}
                                        <br>{{ $location->countryName }}
                                    @else
                                        Unknown
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="border-top border-dashed pt-4">
                        <div class="row flex-between-center mb-2">
                            <div class="col-auto">
                                <h5 class="text-body-highlight mb-0">Email</h5>
                            </div>
                            <div class="col-auto"><span class="lh-1">{{ $user->masked_email }}</span></div>
                        </div>
                        <div class="row flex-between-center">
                            <div class="col-auto">
                                <h5 class="text-body-highlight mb-0">Whatsapp</h5>
                            </div>
                            <div class="col-auto"><a href="tel:{{ $user->whatsapp }}">{{ $user->whatsapp }}</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5" style="page-break-before: always">
        <div class="scrollbar">
            <ul class="nav nav-underline fs-9 flex-nowrap mb-3 pb-1" id="myTab" role="tablist">
                @if (request()->routeIs('profiles.index'))
                    <li class="nav-item me-3"><a
                            class="nav-link text-nowrap {{ request()->routeIs('profiles.index') ? 'active' : '' }}"
                            id="activity-tab" data-bs-toggle="tab" href="#tab-orders" role="tab"
                            aria-controls="tab-orders" aria-selected="true"><span
                                class="fas fa-clock me-2"></span>Activity <span class="text-body-tertiary fw-normal">
                                ({{ auth()->user()->activities->count() }})</span></a>
                    </li>
                @endif
                <li class="nav-item d-print-none me-3">
                    <a class="nav-link text-nowrap {{ request()->routeIs('profiles.edit') ? 'active' : '' }}"
                        id="personal-info-tab" data-bs-toggle="tab" href="#tab-personal-info" role="tab"
                        aria-controls="tab-personal-info" aria-selected="true">
                        <span class="fas fa-user me-2"></span>
                        Personal info
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-print-none text-nowrap" id="password-tab" data-bs-toggle="tab"
                        href="#tab-password" role="tab" aria-controls="tab-password" aria-selected="true">
                        <span class="fas fa-key me-2"></span>
                        Change Password
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="profileTabContent">
            <div class="tab-pane fade {{ request()->routeIs('profiles.index') ? 'show active' : '' }}"
                id="tab-orders" role="tabpanel" aria-labelledby="activity-tab">
                <div class="border-top border-bottom border-translucent" id="profileOrdersTable"
                    data-list='{"valueNames":["id","description","agent","date"],"page":6,"pagination":true}'>
                    <div class="table-responsive scrollbar">
                        <table class="table fs-9 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort white-space-nowrap align-middle pe-3 ps-0" scope="col"
                                        data-sort="id" style="width:5%;">ID</th>
                                    <th class="sort align-middle pe-3 W-50" scope="col" data-sort="activity">
                                        ACTIVITY
                                    </th>
                                    <th class="sort align-middle text-end" scope="col" data-sort="agent">
                                        USER
                                        AGENT</th>
                                    <th class="sort align-middle pe-0 text-end" scope="col" data-sort="date">
                                        DATE
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="list" id="profile-order-table-body">
                                @foreach ($activity as $row)
                                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                        <td class="id align-middle white-space-nowrap py-2 ps-0">
                                            {{ ++$loop->index }}
                                        </td>
                                        <td
                                            class="activity align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2">
                                            {{ $row->description }}
                                        </td>
                                        <td class="agent align-middle text-body-tertiary text-end py-2">
                                            {{ $row->user_agent }}
                                        </td>
                                        <td class="date align-middle text-body-tertiary text-end py-2">
                                            {{ $row->created_at->diffForHumans() }} -
                                            {{ $row->created_at->format('d M Y H:i:s') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                        <div class="col-auto d-flex">
                            <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body"
                                data-list-info="data-list-info"></p><a class="fw-semibold" href="#!"
                                data-list-view="*">View all<span class="fas fa-angle-right ms-1"
                                    data-fa-transform="down-1"></span></a><a class="fw-semibold d-none"
                                href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1"
                                    data-fa-transform="down-1"></span></a>
                        </div>
                        <div class="col-auto d-flex">
                            <button class="page-link" data-list-pagination="prev"><span
                                    class="fas fa-chevron-left"></span></button>
                            <ul class="mb-0 pagination"></ul>
                            <button class="page-link pe-0" data-list-pagination="next"><span
                                    class="fas fa-chevron-right"></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade {{ request()->routeIs('profiles.edit') ? 'show active' : '' }}"
                id="tab-personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
                <div class="row gx-3 gy-4 mb-5">
                    <div class="col-12 col-lg-6">
                        <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                            for="name">Full name</label>
                        <input class="form-control" id="name" type="text" placeholder="Full name"
                            name="name" value="{{ $user->name }}"
                            {{ request()->routeIs('profiles.edit') ? 'required' : 'disabled' }} />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                            for="gender">Gender</label>
                        <select class="form-select" id="gender" name="gender"
                            {{ request()->routeIs('profiles.edit') ? 'required' : 'disabled' }}>
                            <option value="{{ $user->gender }}" hidden>{{ ucwords($user->gender) }}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label text-body-highlight fs-8 ps-0 text-capitalize lh-sm"
                            for="email">Email</label>
                        <input class="form-control" id="email" type="text" placeholder="Email Address"
                            name="email" value="{{ $user->email }}" disabled />
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="row g-2 gy-lg-0">
                            <label class="form-label text-body-highlight fs-8 ps-1 text-capitalize lh-sm mb-1">Date
                                of
                                birth</label>
                            <input class="form-control" id="date_of_birth" type="date"
                                placeholder="Email Address" name="date_of_birth"
                                value="{{ date('Y-m-d', strtotime($user->date_of_birth)) }}"
                                {{ request()->routeIs('profiles.edit') ? 'required' : 'disabled' }} />
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label text-body-highlight fw-bold fs-8 ps-0 text-capitalize lh-sm"
                            for="whatsapp">Whatsapp</label>
                        <input class="form-control" id="whatsapp" type="tel" placeholder="08xxxxxxxxx"
                            name="whatsapp" value="{{ $user->whatsapp }}"
                            {{ request()->routeIs('profiles.edit') ? 'required' : 'disabled' }} />
                    </div>
                </div>
                <div class="text-end">
                    @if (request()->routeIs('profiles.edit'))
                        <button class="btn btn-primary px-7">Save changes</button>
                    @else
                        <a class="btn btn-phoenix-secondary"
                            href="{{ route('profiles.edit', Auth::user()->id) }}"><span
                                class="fas fa-edit me-2"></span>Edit Profile</a>
                    @endif
                </div>
            </div>
            <div class="tab-pane fade" id="tab-password" role="tabpanel" aria-labelledby="password-tab">
                <div class="row gx-3 gy-4 mb-5">
                    <div class="col-12 col-lg-12">
                        <div class="form-floating">
                            <input id="update_password_current_password" name="current_password" type="password"
                                class="form-control" placeholder="Current Password" autocomplete="current-password"
                                {{ request()->routeIs('profiles.edit') ? '' : 'disabled' }} />
                            <label for="update_password_current_password">Current Password</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <div class="form-floating">
                            <input id="update_password_password" type="password" class="form-control"
                                placeholder="Current Password" name="password" autocomplete="new-password"
                                {{ request()->routeIs('profiles.edit') ? '' : 'disabled' }} />
                            <label for="update_password_password">New Password</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <div class="form-floating">
                            <input class="form-control" placeholder="Confirm Password"
                                id="update_password_password_confirmation" name="password_confirmation"
                                type="password" autocomplete="new-password"
                                {{ request()->routeIs('profiles.edit') ? '' : 'disabled' }} />
                            <label for="update_password_password_confirmation">Confirm Password</label>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    @if (request()->routeIs('profiles.edit'))
                        <button class="btn btn-primary px-7">Save changes</button>
                    @else
                        <a class="btn btn-phoenix-secondary"
                            href="{{ route('profiles.edit', Auth::user()->id) }}"><span
                                class="fas fa-edit me-2"></span>Edit Profile</a>
                    @endif
                </div>
            </div>
        </div>

    </div>
    @if (request()->routeIs('profiles.edit'))
        </form>
    @endif
</x-dash.layout>

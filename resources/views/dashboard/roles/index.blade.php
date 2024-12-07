<x-dash.layout>
    @slot('title')
        {{ $title }}
    @endslot

    <div class="mb-9">
        <div id="projectSummary" data-list='{"valueNames":["id","role"],"page":6,"pagination":true}'>
            <div class="row mb-4 gx-6 gy-3 align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">Roles<span class="fw-normal text-body-tertiary ms-3"></span></h2>
                </div>
                @can('role-create')
                    <div class="col-auto"><a class="btn btn-primary px-5" href="{{ route('roles.create') }}"><i
                                class="fa-solid fa-plus me-2"></i>Add new role</a>
                    </div>
                @endcan

            </div>
            <div class="row g-3 justify-content-end align-items-end mb-4">
                <div class="col-12 col-sm-auto">
                    <div class="d-flex align-items-center">
                        <div class="search-box me-3">
                            <form class="position-relative">
                                <input class="form-control search-input search" type="search" placeholder="Search"
                                    aria-label="Search" />
                                <span class="fas fa-search search-box-icon"></span>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive scrollbar">
                <table class="table fs-9 mb-0 border-top border-translucent">
                    <thead>
                        <tr>
                            <th class="sort align-middle ps-3" scope="col" data-sort="id" style="width:6%;">ID
                            </th>
                            <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="role"
                                style="width:80%;">Role</th>
                            @canany(['role-edit', 'role-delete'])
                                <th class="sort align-middle text-end" scope="col" style="width:14%;"></th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="list" id="project-list-table-body">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($roles as $row)
                            <tr class="position-static">
                                <td class="align-middle text-center time white-space-nowrap ps-0 id py-4">
                                    {{ ++$i }}
                                </td>
                                <td class="align-middle time white-space-nowrap ps-0 role py-4">
                                    {{ $row->name }}
                                </td>

                                @canany(['role-edit', 'role-delete'])
                                    <td class="align-middle text-end white-space-nowrap pe-0 action">
                                        <div class="btn-reveal-trigger position-static">
                                            <button
                                                class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span
                                                    class="fas fa-ellipsis-h fs-10"></span></button>
                                            <div class="dropdown-menu dropdown-menu-end py-2">
                                                @can('role-edit')
                                                    <a class="dropdown-item" href="{{ route('roles.edit', $row->id) }}">Edit</a>
                                                @endcan
                                                @can('role-delete')
                                                    <div class="dropdown-divider"></div>
                                                    <form method="POST" action="{{ route('roles.destroy', $row->id) }}"
                                                        style="display:inline">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="dropdown-item text-danger">
                                                            Remove</button>
                                                    </form>
                                                @endcan
                                            </div>

                                        </div>
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div
                class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs-9 border-bottom border-translucent">
                <div class="d-flex">
                    <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info">
                    </p><a class="fw-semibold" href="#!" data-list-view="*">View all<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a
                        class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span
                            class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="d-flex">
                    <button class="page-link" data-list-pagination="prev"><span
                            class="fas fa-chevron-left"></span></button>
                    <ul class="mb-0 pagination"></ul>
                    <button class="page-link pe-0" data-list-pagination="next"><span
                            class="fas fa-chevron-right"></span></button>
                </div>
            </div>
        </div>
    </div>
</x-dash.layout>

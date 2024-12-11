<?php

use Illuminate\Support\Str;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for(Str::lower(__('text-ui.breadcrumb.dashboard')), function (BreadcrumbTrail $trail) {
    $trail->push(__('text-ui.breadcrumb.dashboard'), route('dashboard'));
});

// Dashboard > Profile
Breadcrumbs::for(Str::lower(__('text-ui.breadcrumb.profile')), function (BreadcrumbTrail $trail) {
    $trail->parent(Str::lower(__('text-ui.breadcrumb.dashboard')));
    $trail->push(__('text-ui.breadcrumb.profile'), route('profiles.index'));
});

Breadcrumbs::for('surat masuk', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Surat Masuk', route('incoming-letters.index'));
});

Breadcrumbs::for('tambah surat masuk', function (BreadcrumbTrail $trail) {
    $trail->parent('surat masuk');
    $trail->push('Tambah', route('incoming-letters.create'));
});

Breadcrumbs::for('edit surat masuk', function (BreadcrumbTrail $trail) {
    $trail->parent('surat masuk');
    $trail->push('Edit');
});

Breadcrumbs::for('surat keluar', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Surat Keluar', route('outgoing-letters.index'));
});

Breadcrumbs::for('tambah surat keluar', function (BreadcrumbTrail $trail) {
    $trail->parent('surat keluar');
    $trail->push('Tambah', route('outgoing-letters.create'));
});

Breadcrumbs::for('edit surat keluar', function (BreadcrumbTrail $trail) {
    $trail->parent('surat keluar');
    $trail->push('Edit');
});

// Dashboard > Profile > Edit
Breadcrumbs::for('edit profile', function (BreadcrumbTrail $trail) {
    $trail->parent('profile');
    $trail->push('Edit');
});

// Dashboard > User
Breadcrumbs::for(Str::lower(__('text-ui.controller.user.index.title')), function (BreadcrumbTrail $trail) {
    $trail->parent(Str::lower(__('text-ui.breadcrumb.dashboard')));
    $trail->push(__('text-ui.breadcrumb.user.index'), route('users.index'));
});

// Dashboard > User > Edit
Breadcrumbs::for(Str::lower(__('text-ui.controller.user.edit.title')), function (BreadcrumbTrail $trail) {
    $trail->parent(Str::lower(__('text-ui.controller.user.index.title')));
    $trail->push(__('text-ui.breadcrumb.user.edit'));
});

// Dashboard > User > Add
Breadcrumbs::for(Str::lower(__('text-ui.controller.user.create.title')), function (BreadcrumbTrail $trail) {
    $trail->parent(Str::lower(__('text-ui.controller.user.index.title')));
    $trail->push(__('text-ui.breadcrumb.user.create'), route('users.create'));
});

// Dashboard > Role
Breadcrumbs::for(Str::lower(__('text-ui.controller.role.index.title')), function (BreadcrumbTrail $trail) {
    $trail->parent(Str::lower(__('text-ui.breadcrumb.dashboard')));
    $trail->push(__('text-ui.breadcrumb.role.index'), route('roles.index'));
});

// Dashboard > Role > Edit
Breadcrumbs::for(Str::lower(__('text-ui.controller.role.edit.title')), function (BreadcrumbTrail $trail) {
    $trail->parent(Str::lower(__('text-ui.controller.role.index.title')));
    $trail->push(__('text-ui.breadcrumb.role.edit'));
});

// Dashboard > Role > Tambah
Breadcrumbs::for(Str::lower(__('text-ui.controller.role.create.title')), function (BreadcrumbTrail $trail) {
    $trail->parent(Str::lower(__('text-ui.controller.role.index.title')));
    $trail->push(__('text-ui.breadcrumb.role.create'), route('roles.create'));
});

Breadcrumbs::for(Str::lower(__('text-ui.controller.web-setting.index.title')), function (BreadcrumbTrail $trail) {
    $trail->parent(Str::lower(__('text-ui.breadcrumb.dashboard')));
    $trail->push(__('text-ui.controller.web-setting.index.title'));
});

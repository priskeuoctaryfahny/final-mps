<?php

use Spatie\Permission\Models\Role;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('dashboard2', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard 2', route('dashboard2'));
});

// Dashboard > Profile
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Profil', route('profiles.index'));
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
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Pengguna', route('users.index'));
});

// Dashboard > User > Edit
Breadcrumbs::for('edit user', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Edit');
});

// Dashboard > User > Add
Breadcrumbs::for('create user', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Tambah', route('users.create'));
});

// Dashboard > User > Show
Breadcrumbs::for('show user', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Show');
});

// Dashboard > Role
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Role', route('roles.index'));
});

// Dashboard > Role > Edit
Breadcrumbs::for('edit role', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push('Edit');
});

// Dashboard > Role > Tambah
Breadcrumbs::for('create role', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push('Tambah', route('roles.create'));
});

// Dashboard > Role > Show
Breadcrumbs::for('show role', function (BreadcrumbTrail $trail) {
    $trail->parent('roles');
    $trail->push('Show');
});

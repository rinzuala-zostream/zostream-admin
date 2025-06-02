<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('movie', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('movie');

Route::get('episode', function () {
    return Inertia::render('Episode');
})->middleware(['auth', 'verified'])->name('episode');

Route::get('user', function () {
    return Inertia::render('User');
})->middleware(['auth', 'verified'])->name('user');

Route::get('device', function () {
    return Inertia::render('Device');
})->middleware(['auth', 'verified'])->name('device');

Route::get('subscribe', function () {
    return Inertia::render('Subscription');
})->middleware(['auth', 'verified'])->name('subscribe');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

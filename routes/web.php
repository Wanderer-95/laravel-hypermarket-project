<?php

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
require __DIR__.'/groups/admin.php';
require __DIR__.'/groups/client.php';

Route::get('/', function () {
    return Inertia('App');
})->name('home');

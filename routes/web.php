<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth');
});

Route::get('/tasks', function () {
    return view('tasks');
});


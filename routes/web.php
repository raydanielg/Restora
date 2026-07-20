<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/features', function () {
    return view('frontend.features');
})->name('features');

Route::get('/how-it-works', function () {
    return view('frontend.how-it-works');
})->name('how-it-works');

Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

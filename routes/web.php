<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MahasiswaController;

use App\Http\Controllers\MataKuliahController;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\QuestionController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\PegawaiController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\PelangganController;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('index');
});


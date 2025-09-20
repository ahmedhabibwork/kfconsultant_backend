<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Basic\HomeController;


Route::get('/', function () {
    return redirect()->route('filament.dashboard.auth.login');
});

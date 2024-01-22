<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::domain(env('APP_SUBDOMAIN_EXTERNAL'))->group(function () {
     Route::get('/{any}', [HomeController::class, 'externalHome'])->where('any', '.*')->name('externalHome');
});

Route::get('/{any}', [HomeController::class, 'home'])
    ->where('any', '.*')
    ->where('any', '^(?!telescope).*$')
    ->name('home');

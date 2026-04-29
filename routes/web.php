<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VatController;

Route::get('/', [VatController::class, 'index']);

Route::post('/calculate', [VatController::class, 'calculate'])
    ->name('vat.calculate');

    // NEW ROUTE
Route::get('/history', [VatController::class, 'history'])->name('vat.history');
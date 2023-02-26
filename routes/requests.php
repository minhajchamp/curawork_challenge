<?php

use Illuminate\Support\Facades\Route;

/*** Requests Routes ***/
Route::get('/', [App\Http\Controllers\RequestsController::class, 'index']);
Route::post('store', [App\Http\Controllers\RequestsController::class, 'store']);
Route::delete('destroy/{id}', [App\Http\Controllers\RequestsController::class, 'destroy']);
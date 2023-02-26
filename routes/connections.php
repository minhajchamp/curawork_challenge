<?php

use Illuminate\Support\Facades\Route;

/*** Connections Routes ***/
Route::get('/', [App\Http\Controllers\ConnectionsController::class, 'index']);
Route::get('show/{id}', [App\Http\Controllers\ConnectionsController::class, 'show']);
Route::delete('destroy/{id}', [App\Http\Controllers\ConnectionsController::class, 'destroy']);
<?php

use Illuminate\Support\Facades\Route;

/*** Suggestions Routes ***/
Route::get('/', [App\Http\Controllers\SuggestionsController::class, 'index']);
Route::post('send_request', [App\Http\Controllers\SuggestionsController::class, 'store']);
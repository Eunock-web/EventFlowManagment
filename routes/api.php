<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Events\EventsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(EventsController::class)
        ->prefix('events')
        ->group(function (){
            Route('/create', 'create');
        });
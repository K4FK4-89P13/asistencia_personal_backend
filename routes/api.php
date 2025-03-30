<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

Route::get('/students', [StudentController::class, 'index']);

Route::get('/students/{id}', [StudentController::class, 'show']);

Route::post('/students', [StudentController::class, 'store']);

Route::put('/students/{id}', [StudentController::class, 'update']);
Route::patch('/students/{id}', [StudentController::class, 'updatePartial']);

Route::delete('/students/{id}', [StudentController::class, 'destroy']);

// Personal
Route::controller(AreaController::class)->group(function() {
    Route::get('/area', 'index');
    Route::get('/area/{id}', 'show');
    Route::post('/area', 'store');
    Route::put('/area/{id}', 'update');
});

//Personal
Route::controller(PersonalController::class)->group(function() {
    Route::get('/personal', 'index');
    Route::get('/personal/{id}', 'show');
    Route::post('/personal', 'store');
    Route::put('/personal/{id}', 'update');
    Route::delete('/personal/{id}', 'destroy');
});

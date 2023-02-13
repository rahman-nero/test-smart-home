<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\SignUpController;
use App\Http\Controllers\Api\Equipment\EquipmentController;
use App\Http\Controllers\Api\Equipment\EquipmentTypeController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::get('login', [LoginController::class, 'login']);
    Route::post('register', [SignUpController::class, 'signup']);
});

Route::prefix('v1')
    ->middleware('auth:sanctum')->group(function () {

        // Getting user's data
        Route::get('user', [UserController::class, 'user']);

        // Getting equipments along with the opportunity to search
        Route::get('/equipment', [EquipmentController::class, 'index']);

        // Getting the concrete equipment
        Route::get('/equipment/{id}',[EquipmentController::class, 'show']);

        // Adding a new equipment
        Route::post('/equipment', [EquipmentController::class, 'create']);

        // Editing a equipment
        Route::put('/equipment/{id}', [EquipmentController::class, 'edit']);

        // Soft delete equipment
        Route::delete('/equipment/{id}', [EquipmentController::class, 'delete']);

        // Getting the list of equipment's type
        Route::get('/equipment-type', [EquipmentTypeController::class, 'index']);

});

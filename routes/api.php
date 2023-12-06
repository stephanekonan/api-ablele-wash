<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Employe\AuthEmployeController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Manager\LavageController;
use App\Http\Controllers\Manager\ProductController;

use App\Http\Controllers\Api\Client\VehiculeController;
use App\Http\Controllers\Api\Client\CommandeController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::get('/client/auth/login', []);

Route::middleware('auth:api')->group(function () {

    Route::get('/user', [UserController::class, 'getUser']);
    Route::get('/users', [UserController::class, 'users']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/lavages', [LavageController::class, 'index']);
    Route::post('/lavage/store', [LavageController::class, 'store']);
    Route::get('/lavage/show/{id}', [LavageController::class, 'show']);
    Route::put('/lavage/update/{id}', [LavageController::class, 'update']);
    Route::delete('/lavage/delete/{id}', [LavageController::class, 'delete']);

    Route::get('/products', [ProductController::class, 'allproducts']);
    Route::post('/product/store', [ProductController::class, 'store']);
    Route::get('/product/show/{id}', [ProductController::class, 'show']);
    Route::post('/product/update/{id}', [ProductController::class, 'update']);
    Route::delete('/product/delete/{id}', [ProductController::class, 'deleteProduct']);
    Route::delete('/product/photo/delete/{id}', [ProductController::class, 'deleteAlbumImage']);

    Route::get('/client/vehicules', [VehiculeController::class, 'index']);
    Route::post('/client/vehicule/store', [VehiculeController::class, 'store']);
    Route::get('/client/vehicule/show/{id}', [VehiculeController::class, 'show']);
    Route::put('/client/vehicule/update/{id}', [VehiculeController::class, 'update']);
    Route::delete('/client/vehicule/delete/{id}', [VehiculeController::class, 'destroy']);

    Route::get('/client/commandes', [CommandeController::class, 'index']);
    Route::post('/client/commande/store', [CommandeController::class, 'store']);
    Route::get('/client/commande/show/{id}', [CommandeController::class, 'show']);
    Route::put('/client/commande/update/{id}', [CommandeController::class, 'update']);
    Route::delete('/client/commande/delete/{id}', [CommandeController::class, 'destroy']);

});

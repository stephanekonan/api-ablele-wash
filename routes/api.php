<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Employe\AuthEmployeController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Manager\LavageController;
use App\Http\Controllers\Manager\ProductController;

Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {

    Route::get('/user', [UserController::class, 'getUser']);
    Route::get('/users', [UserController::class, 'users']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::post('/lavages', [LavageController::class, 'index']);
    Route::post('/lavage/store', [LavageController::class, 'store']);
    Route::get('/lavage/show/{id}', [LavageController::class, 'show']);
    Route::put('/lavage/update/{id}', [LavageController::class, 'update']);
    Route::delete('/lavage/delete/{id}', [LavageController::class, 'update']);

    Route::get('/products', [ProductController::class, 'allproducts']);
    Route::post('/product/store', [ProductController::class, 'store']);
    Route::post('/product/show/{id}', [ProductController::class, 'show']);
    Route::post('/product/update/{id}', [ProductController::class, 'update']);
    Route::post('/product/delete/{id}', [ProductController::class, 'deleteProduct']);
    Route::post('/product/photo/delete/{id}', [ProductController::class, 'deleteAlbumImage']);


});

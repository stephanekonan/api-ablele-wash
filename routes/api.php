<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\Client\CommentController;
use App\Http\Controllers\Api\Client\CommandeController;

use App\Http\Controllers\Api\Client\VehiculeController;
use App\Http\Controllers\Api\Employe\AppMobileController;
use App\Http\Controllers\Api\Manager\ApiLavageController;
use App\Http\Controllers\Api\Manager\ApiEmployeController;
use App\Http\Controllers\Api\Manager\ApiProductController;
use App\Http\Controllers\Api\Employe\AuthEmployeController;
use App\Http\Controllers\Api\Manager\ApiCategoryController;
use App\Http\Controllers\Api\Manager\ApiCommandeController;
use App\Http\Controllers\Api\Manager\ApiTypeLavageController;
use App\Http\Controllers\Api\Client\RatingController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'getUser']);
    Route::get('/users', [UserController::class, 'users']);
    Route::post('/client/auth/logout', [AuthController::class, 'logout']);
    // CLIENT ROUTES
    Route::get('/client/vehicules', [VehiculeController::class, 'index']);
    Route::post('/client/vehicule/store', [VehiculeController::class, 'store']);
    Route::get('/client/vehicule/show/{id}', [VehiculeController::class, 'show']);
    Route::put('/client/vehicule/update/{id}', [VehiculeController::class, 'update']);
    Route::delete('/client/vehicule/delete/{id}', [VehiculeController::class, 'destroy']);

    Route::get('/client/commandes', [CommandeController::class, 'index']);
    Route::post('/client/commande/store', [CommandeController::class, 'store']);
    Route::get('/client/commande/edit/{id}', [CommandeController::class, 'edit']);
    Route::get('/client/commande/show/{id}', [CommandeController::class, 'show']);
    Route::put('/client/commande/update/{id}', [CommandeController::class, 'update']);
    Route::delete('/client/commande/delete/{id}', [CommandeController::class, 'destroy']);

    Route::post('/client/comment/store', [CommentController::class, 'store']);
    Route::post('/client/comment/reply/{comment}', [CommentController::class, 'reply']);
    Route::delete('/client/comment/destroy/{id}', [CommentController::class, 'destroy']);
    Route::put('/client/comment/update/{id}', [CommentController::class, 'update']);

    Route::post('/client/rating/store', [RatingController::class, 'store']);
    Route::delete('/client/rating/delete/{id}', [RatingController::class, 'destroy']);
    Route::put('/client/rating/update/{id}', [RatingController::class, 'update']);

    // GERANT ROUTES
    Route::get('/gerant/products', [ApiProductController::class, 'index']);
    Route::post('/gerant/product/store', [ApiProductController::class, 'store']);
    Route::get('/gerant/product/show/{id}', [ApiProductController::class, 'show']);
    Route::post('/gerant/product/update/{id}', [ApiProductController::class, 'update']);
    Route::delete('/gerant/product/delete/{id}', [ApiProductController::class, 'deleteProduct']);
    Route::delete('/gerant/product/photo/delete/{id}', [ApiProductController::class, 'deleteAlbumImage']);

    Route::get('/gerant/lavages', [ApiLavageController::class, 'index']);
    Route::post('/gerant/lavage/store', [ApiLavageController::class, 'store']);
    Route::get('/gerant/lavage/edit/{id}', [ApiLavageController::class, 'edit']);
    Route::get('/gerant/lavage/show/{id}', [ApiLavageController::class, 'show']);
    Route::put('/gerant/lavage/update/{id}', [ApiLavageController::class, 'update']);
    Route::delete('/gerant/lavage/delete/{id}', [ApiLavageController::class, 'delete']);

    Route::get('/gerant/categories', [ApiCategoryController::class, 'index']);
    Route::post('/gerant/category/store', [ApiCategoryController::class, 'store']);
    Route::put('/gerant/category/update/{id}', [ApiCategoryController::class, 'update']);
    Route::delete('/gerant/category/delete/{id}', [ApiCategoryController::class, 'delete']);

    Route::get('/gerant/commandes', [ApiCommandeController::class, 'index']);
    Route::put('/gerant/commande/edit/{id}', [ApiCommandeController::class, 'edit']);
    Route::put('/gerant/commande/show/{id}', [ApiCommandeController::class, 'show']);
    Route::put('/gerant/commande/update/{id}', [ApiCommandeController::class, 'update']);
    Route::delete('/gerant/commande/delete/{id}', [ApiCommandeController::class, 'delete']);

    Route::get('/gerant/employes', [ApiEmployeController::class, 'index']);
    Route::put('/gerant/employe/edit/{id}', [ApiEmployeController::class, 'edit']);
    Route::put('/gerant/employe/store/{id}', [ApiEmployeController::class, 'store']);
    Route::put('/gerant/employe/update/{id}', [ApiEmployeController::class, 'update']);
    Route::delete('/gerant/employe/delete/{id}', [ApiEmployeController::class, 'delete']);

    Route::get('/gerant/typeslavage', [ApiTypeLavageController::class, 'index']);
    Route::put('/gerant/typelavage/store', [ApiTypeLavageController::class, 'store']);
    Route::delete('/gerant/typelavage/delete/{id}', [ApiTypeLavageController::class, 'delete']);


});

Route::post('/employe/auth/login', [AuthEmployeController::class, 'login']);
Route::delete('/employe/auth/logout', [AuthEmployeController::class, 'logout']);
Route::get('/employe/profil', [AuthEmployeController::class, 'profil']);

Route::get('/employe/commandes', [AppMobileController::class, 'commandes']);
Route::middleware('employe:api')->group(function () {
    Route::get('/employe/commande/edit/{id}', [AppMobileController::class, 'edit']);
    Route::put('/employe/commande/update/{id}', [AppMobileController::class, 'update']);
});

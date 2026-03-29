<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register' , [UserController::class,'register']);


Route::post('/login', [UserController::class, 'login']);


Route::get('/users', [UserController::class, 'userList']);


Route::post('/add-product', [ProductController::class, 'addProduct']);


Route::get('/productlist', [ProductController::class, 'getProducts']);


Route::get('/products/search', [ProductController::class, 'searchProducts']);

Route::get('/test', function () {
    return response()->json([
        'message' => 'API working 🚀'
    ]);
});
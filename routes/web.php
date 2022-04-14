<?php

use App\Http\Controllers\ManageController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('index');
//});

Route::get('/',[IndexController::class,'index']);
Route::get('/test',[IndexController::class,'test']);

Route::post('/login',[UserController::class,'login']);
Route::post('/register',[UserController::class,'register']);
Route::get('/logout',[UserController::class, 'logout']);

Route::get('/search',[SearchController::class,'search']);
Route::get('/search/detail/{id}',[SearchController::class,'searchDetail']);
Route::get('/genre',[SearchController::class,'genre']);

Route::post('/borrow',[RentalController ::class,'borrow']);

Route::get('/myrental',[RentalController::class,'myrental']);
Route::get('/myrental/pending',[RentalController::class,'myrental']);
Route::get('/myrental/accepted',[RentalController::class,'myrental']);
Route::get('/myrental/late',[RentalController::class,'myrental']);
Route::get('/myrental/rejected',[RentalController::class,'myrental']);
Route::get('/myrental/returned',[RentalController::class,'myrental']);

Route::get('/myrental/detail/{id}',[RentalController::class,'rentalDetail']);

Route::get('/addbook',[ManageController::class,'addBookPage']);
Route::post('/addbook/add',[ManageController::class,'addBook']);
Route::post('/photo',[ManageController::class,'photo']);

Route::post('/editbook',[ManageController::class,'editBook']);

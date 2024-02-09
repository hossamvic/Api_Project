<?php

use App\Http\Controllers\API\AdController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\DistrictController;
use App\Http\Controllers\API\DomainController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/////// Auth Module
Route::controller(AuthController::class)->group(
    function (){
         Route::post('register' , 'register');
         Route::post('login' , 'login');
         Route::post('logout' , 'logout')->middleware('auth:sanctum');
    }
);

///////   Setting Module 
Route::get('/settings', SettingController::class);

///////   Cities Module 
Route::get('/cities', CityController::class);

///////   Districts Module 
Route::get('/districts', DistrictController::class);

///////   Messages Module 
Route::post('/messages', MessageController::class);

///////   Domain Module 
Route::get('/domains', DomainController::class);

///////   Ads Module
Route::prefix('ads')->controller(AdController::class)->group(function(){
       Route::get('/' , 'index');
       Route::get('/latest' , 'latest');
       Route::get('/domain/{domain_id}' , 'domain');
       Route::get('/search' , 'search');
       /// Auth Add AD
Route::middleware('auth:sanctum')->group(function(){
       Route::post('/create' , 'create');
       Route::post('/update/{ad_id}' , 'update');
       Route::get('/delete/{ad_id}' , 'delete');
       Route::get('myads' , 'myads');
       });
}) ;

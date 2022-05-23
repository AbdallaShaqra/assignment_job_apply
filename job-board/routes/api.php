<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\ApplicationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('/login', [ApiAuthController::class , 'login'])->name('login.api');
    Route::post('/register',[ApiAuthController::class , 'register'])->name('register.api');

});
Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [ApiAuthController::class , 'logout'])->name('logout.api');
    Route::post('/storeJobApp', [ApplicationController::class , 'store'])->name('storeApp.api');

});

Route::middleware(['auth:api','is_admin'])->group(function () {

    Route::get('/getAllJobPosts', [JobPostController::class , 'index'])->name('index.api');
    Route::post('/addJobPost', [JobPostController::class , 'store'])->name('store.api');
    Route::post('/updateJobPost', [JobPostController::class , 'update'])->name('update.api');
    Route::get('/getJobPostById/{id}', [JobPostController::class , 'show'])->name('show.api');
    Route::get('/getAllApplications', [ApplicationController::class , 'getAllApplications'])->name('getAllApplications.api');
    Route::post('/getApplicationById', [ApplicationController::class , 'getApplicationById'])->name('getApplicationById.api');

});

Route::middleware(['auth:api','is_admin'])->get('/user', function (Request $request) {
    return $request->user();
});

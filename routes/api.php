<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\NewsApiController;
use App\Http\Controllers\RatingApiController;
use App\Http\Controllers\TeamateApiController;
use App\Http\Controllers\CarouselApiController;
use App\Http\Controllers\NewsreplyApiController;
use App\Http\Controllers\DestinationApiController;
use App\Http\Controllers\NewscommentApiController;
use App\Http\Controllers\NewscategoryApiController;
use App\Http\Controllers\FeaturedToursApiController;
use App\Http\Controllers\PopularActivitiesController;
use App\Http\Controllers\PopularActivitiesApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->group(function() {

    Route::post("/register",[AuthApiController::class,'register'])->name('api.register');
    Route::post("/login",[AuthApiController::class,'login'])->name('api.login');

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('/logout',[AuthApiController::class,'logout'])->name('api.logout');
        Route::post('/logout-all',[AuthApiController::class,'logoutAll'])->name('api.logout-all');
        Route::apiResource("carousels",CarouselApiController::class);
        Route::apiResource("popularActivities",PopularActivitiesApiController::class);
        Route::apiResource("FeaturedTours",FeaturedToursApiController::class);
        Route::apiResource("Ratings",RatingApiController::class);
        Route::apiResource("Newscategory",NewscategoryApiController::class);
        Route::apiResource("news",NewsApiController::class);
        Route::apiResource("newscomment",NewscommentApiController::class);
        Route::apiResource("newsreply",NewsreplyApiController::class);
        Route::apiResource("teamate",TeamateApiController::class);
        Route::apiResource("destination",DestinationApiController::class);
    });

});



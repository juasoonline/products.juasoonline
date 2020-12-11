<?php

use App\Http\Controllers\Group\GroupController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Subcategory\SubcategoryController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::group( [], function ()
{
    Route::apiResource( 'groups', GroupController::class );
    Route::apiResource( 'categories', CategoryController::class );
    Route::apiResource( 'subcategories', SubcategoryController::class );
    Route::apiResource( 'products', ProductController::class );
});

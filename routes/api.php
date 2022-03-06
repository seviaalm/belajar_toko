<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//LOGIN
Route::post('/register', 'userController@register');
Route::post('/login', 'userController@login');

Route::group(['middleware' => ['jwt.verify']], function(){

    Route::group(['middleware' => ['api.superadmin']], function(){
        Route::delete('/customers/{id}', 'customersController@destroy');
        Route::delete('/product/{id}', 'productController@destroy');
        Route::delete('/order/{id}', 'orderController@destroy');  
        Route::delete('/officer/{id}', 'officerController@destroy');
        Route::delete('/detailOrder/{id}', 'detailOrderController@destroy');

  
    });

    Route::group(['middleware' => ['api.admin']], function(){
        Route::post('/customers', 'customersController@store');
        Route::put('/customers/{id}', 'customersController@update');

        Route::post('/product', 'productController@store');
        Route::put('/product/{id}', 'productController@update');

        Route::post('/order', 'orderController@store');
        Route::put('/order/{id}', 'orderController@update');
    
        Route::post('/officer', 'officerController@store');
        Route::put('/officer/{id}', 'officerController@update');

        Route::post('/detailOrder', 'detailOrderController@store');
        Route::put('/detailOrder/{id}', 'detailOrderController@update');


    });
    

    //get start
    Route::get('/customers', 'customersController@show');
    Route::get('/customers/{id}', 'customersController@detail');

    Route::get('/officer', 'officerController@show');
    Route::get('/officer/{id}', 'officerController@detail');

    Route::get('/product', 'productController@show');
    Route::get('/product/{id}', 'productController@detail');

    Route::get('/order', 'orderController@show');
    Route::get('/order/{id}', 'orderController@detail');

    Route::get('/detailOrder', 'detailOrderController@show');
    Route::get('/detailOrder/{id}', 'detailOrderController@detail');


});






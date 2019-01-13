<?php

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

Route::match(['get', 'post'], '/', ['uses' => 'IndexController@index', 'as' => 'index']);

Route::group(['prefix' => 'web-development'], function () {
    Route::match(['get', 'post'], 'sites/{alias?}', ['uses' => 'WebDevelopmentController@sites', 'as' => 'sites']);
    Route::match(['get', 'post'], 'services/{alias?}', ['uses' => 'WebDevelopmentController@services', 'as' => 'services']);
    Route::match(['get', 'post'], 'animations/{alias?}', ['uses' => 'WebDevelopmentController@webAnimations', 'as' => 'webAnimations']);

//    Route::post('services/mailing/sending', ['uses' => 'ServiceMailingController@sending', 'as' => 'sending']);
});

Route::group(['prefix' => 'graphic-design'], function () {
    Route::match(['get', 'post'], 'branding/{alias?}', ['uses' => 'GraphicDesignController@branding', 'as' => 'branding']);
    Route::match(['get', 'post'], 'printing-products/{alias?}', ['uses' => 'GraphicDesignController@printing', 'as' => 'printing']);
    Route::match(['get', 'post'], 'animations/{alias?}', ['uses' => 'GraphicDesignController@graphicAnimations', 'as' => 'graphicAnimations']);
});

Route::match(['get', 'post'], 'skills', ['uses' => 'SkillsController@index', 'as' => 'skills']);
Route::match(['get', 'post'], 'cv', ['uses' => 'CVController@index', 'as' => 'cv']);
Route::post('cv/mail', ['uses' => 'CVController@mail', 'as' => 'mail']);
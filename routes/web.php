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

Route::get('/', ['uses' => 'IndexController@index', 'as' => 'index']);

Route::group(['prefix' => 'web-development'], function () {
    Route::get('sites/{alias?}', ['uses' => 'WebDevelopmentController@sites', 'as' => 'sites']);
    Route::get('services/{alias?}', ['uses' => 'WebDevelopmentController@services', 'as' => 'services']);
    Route::get('animations/{alias?}', ['uses' => 'WebDevelopmentController@animations', 'as' => 'webAnimations']);
});

Route::group(['prefix' => 'graphic-design'], function () {
    Route::match(['get', 'post'], 'branding/{alias?}', ['uses' => 'GraphicDesignController@branding', 'as' => 'branding']);
    Route::get('printing-products/{alias?}', ['uses' => 'GraphicDesignController@printing', 'as' => 'printing']);
    Route::get('animations/{alias?}', ['uses' => 'GraphicDesignController@animations', 'as' => 'graphicAnimations']);
});

Route::get('skills', ['uses' => 'SkillsController@index', 'as' => 'skills']);
Route::get('cv', ['uses' => 'CVController@index', 'as' => 'cv']);
Route::post('cv', ['uses' => 'CVController@mail', 'as' => 'cv']);
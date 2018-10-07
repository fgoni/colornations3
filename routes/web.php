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


Route::get('/', 'ViewController@getIndex');
Route::get('home', 'ViewController@getIndex');

Route::get('user/{id}', 'UserController@getUser');
Route::get('battlefield', 'ViewController@getBattlefield');
Route::get('rankings', 'ViewController@getRankings');
Route::get('gameinfo', 'ViewController@getGameinfo');
Route::get('history', 'ViewController@getHistory');

// Authentication routes...
Route::get('auth/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('auth/login', 'Auth\LoginController@login');
Route::get('auth/logout', 'Auth\LoginController@logout');

// Registration routes...
Route::get('auth/register', 'Auth\RegisterController@showRegistrationForm');
Route::post('auth/register', 'Auth\RegisterController@register');

Route::get('auth/google', 'Auth\GoogleAuthController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\GoogleAuthController@handleProviderCallback');

Route::get('auth/facebook', 'Auth\FacebookAuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\FacebookAuthController@handleProviderCallback');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard/settings', 'DashboardController@Settings');
    Route::get('dashboard/profile', 'DashboardController@Profile');
    Route::post('update-data', 'UserController@updateFirstTimeUser');
    Route::group(['middleware' => 'activated'], function () {
        Route::group([
            'prefix' => 'dashboard',
        ], function () {
            Route::get('events', 'DashboardController@Events');
            Route::get('headquarters', 'DashboardController@Headquarters');
            Route::get('techs', 'DashboardController@Techs');
            Route::get('training', 'DashboardController@Training');
            Route::get('combat-log', 'DashboardController@CombatLog');
            Route::get('economy', 'DashboardController@Economy');
            Route::get('rankings', 'DashboardController@Rankings');
            Route::get('intelligence', 'DashboardController@Intelligence');
        });
        Route::post('update-race', 'UserController@updateRace');
        Route::post('deposit', 'BankController@deposit');
        Route::post('withdraw', 'BankController@withdraw');
        Route::post('attack', 'UserController@postAttack');
        Route::post('spy', 'UserController@postSpy');
        Route::post('upgrade/siege', 'TechController@buyNextSiege');
        Route::post('upgrade/fort', 'TechController@buyNextFort');
        Route::post('upgrade/replication', 'TechController@buyNextReplication');
        Route::post('upgrade/autobanking', 'TechController@buyNextAutobanking');
        Route::post('upgrade/intelligence', 'TechController@buyNextIntelligence');
        Route::post('train', 'TrainController@train');
        Route::post('untrain', 'TrainController@untrain');
        Route::post('train/injured', 'TrainController@healInjured');
    });
});
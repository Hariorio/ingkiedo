<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Auth.login');
});

Route::get('/login', 'Auth\LoginController@index')->name('login');
Route::post('/authenticate', 'Auth\LoginController@authenticate')->name('authenticate');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/test', 'TestController@index')->name('test');
    Route::get('/test2', 'TestController@test2')->name('test2');

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'admin\HomeController@index')->name('home_admin');

        Route::group(['prefix' => 'member_list'], function () {
            Route::get('/', 'admin\MemberListController@index')->name('member_list');
            Route::get('/getData', 'admin\MemberListController@getData');
            Route::post('/addNewMember', 'admin\MemberListController@addNewMember');
            Route::post('/editMember', 'admin\MemberListController@editMember');
            Route::post('/deActivateUser', 'admin\MemberListController@deActivateUser');
            Route::post('/reActivateUser', 'admin\MemberListController@reActivateUser');
            Route::get('/getProvinceAndCity', 'admin\MemberListController@getProvinceAndCity');
            Route::get('/getCity', 'admin\MemberListController@getCity');
        });

        Route::group(['prefix' => 'budget_list'], function () {
            Route::get('/', 'admin\BudgetPlanController@index')->name('budget_list');
            Route::get('/getData', 'admin\BudgetPlanController@getData');
            Route::post('/validateSubmit', 'admin\BudgetPlanController@validateSubmit');
        });

        Route::group(['prefix' => 'list_promo'], function () {
            Route::get('/', 'admin\ListPromoController@index')->name('list_promo');
            Route::get('/getData', 'admin\ListPromoController@getData');
            Route::post('/newPromoSubmit', 'admin\ListPromoController@newPromoSubmit');
            Route::get('/getProvinceAndCity', 'admin\ListPromoController@getProvinceAndCity');
            Route::get('/getCity', 'admin\ListPromoController@getCity');
            Route::post('/editPromoSubmit', 'admin\ListPromoController@editPromoSubmit');
            Route::post('/deactivatePromo', 'admin\ListPromoController@deactivatePromo');
            Route::post('/reactivatePromo', 'admin\ListPromoController@reactivatePromo');
        });

    });

    Route::group(['prefix' => 'member'], function () {
        Route::get('/', 'member\HomeController@index')->name('home_member');

        Route::group(['prefix' => 'budget_list'], function () {
            Route::get('/', 'member\BudgetPlanController@index')->name('budget_list');
            Route::get('/getData', 'member\BudgetPlanController@getData');
            Route::post('/budgetPlanSubmit', 'member\BudgetPlanController@budgetPlanSubmit');
            Route::get('/getProvinceAndCity', 'member\BudgetPlanController@getProvinceAndCity');
            Route::get('/getCity', 'member\BudgetPlanController@getCity');
            Route::post('/deleteItem', 'member\BudgetPlanController@deleteItem');
        });

    });

});
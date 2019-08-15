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

Route::group(['middleware' => ['preventbackhistory']], function () {

    Route::group(['middleware' => ['checkislogin']], function () {
        Route::get('/', 'apiController@index');
        Route::get('/login', 'apiController@index')->name('login');
    });
    
    Route::group(['middleware' => ['checkisuser']], function () {
        Route::get('/main', 'pageController@index');
        Route::get('/main2', 'pageController@home');
        // Route::get('/dataManager', 'pageController@dataManager');
        Route::get('/updateMDC', 'pageController@updateMDC');
        Route::get('/dataAnalysis', 'pageController@dataAnalysis');
        Route::get('/getProducts', 'rSalesController@getProducts');
        Route::get('/gettherapeutic', 'rSalesController@gettherapeutic');
        Route::get('/getSpecialtySales', 'rSalesController@getSpecialtySales');
        Route::get('/getSalesPerFrequency', 'rSalesController@getSalesPerFrequency');
        Route::get('/getSalesPerDoctorClass', 'rSalesController@getSalesPerDoctorClass');
        Route::get('/getManager', 'rSalesController@getManager');
        Route::get('/getManager2', 'rSalesController@getManager2');
        Route::get('/getResultOnClick', 'rSalesController@getResultOnClick');
        Route::get('/getResultOnClick2', 'rSalesController@getResultOnClick2');
        Route::get('/loadSelection', 'rSalesController@loadSelection');
        Route::get('/dataAnalysisQuery', 'rSalesController@dataAnalysisQuery');
        Route::get('/getProduct', 'rSalesController@getProduct');
        Route::get('/getTc', 'rSalesController@getTc');
        Route::get('/getSpecialty', 'rSalesController@getSpecialty');
        Route::get('/getFrequency', 'rSalesController@getFrequency');
        Route::get('/getMdClass', 'rSalesController@getMdClass');
        Route::get('/getMDName', 'rSalesController@getMDName');
        Route::get('/getManagerName', 'rSalesController@getManagerName');
        Route::get('/getMedrepName', 'rSalesController@getMedrepName');
        Route::get('/dataAnlaysisModal', 'rSalesController@dataAnlaysisModal');
        // Route::get('/test', 'rSalesController@test');
    });

});

// Route::get('/main', 'pageController@index');
// Route::get('/main2', 'pageController@home');
// // Route::get('/dataManager', 'pageController@dataManager');
// Route::get('/updateMDC', 'pageController@updateMDC');
// Route::get('/getProducts', 'rSalesController@getProducts');
<?php

/*
|
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Cache\Repository as Cache;

Route::get('/', 'HomeController@index');

Route::get('/products', 'ProductsController@index');
Route::get('/product/{partNumber}', 'ProductsController@product')->name('products.product');
Route::get('/products/getProducts','ProductsController@getProducts');
Route::get('/products/live-search', 'ProductsController@liveSearch');
Route::post('/products/getProductsByCategory','ProductsController@getProductsByCategory');
Route::post('/products/getProductsByFilter','ProductsController@getProductsByFilter');
Route::post('/products/getProductsNoCategory','ProductsController@getProductsNoCategory');
Route::post('/products/setBackValue','ProductsController@setBackValue');


Route::get('about', 'HomeController@about');
Route::get('contact', 'HomeController@contact');
Route::get('resources/instructions', 'HomeController@instructions');
Route::get('resources/videos', 'HomeController@videos');
Route::get('privacy', 'HomeController@privacy');
Route::get('resources/catalogs', 'HomeController@catalogs');
Route::get('shipping', 'HomeController@shipping');
Route::get('merchandise', 'HomeController@merchandise');
Route::get('warranty', 'HomeController@warranty');
Route::get('faq', 'HomeController@faq');
Route::get('adas', 'HomeController@adas');
Route::get('installation', 'HomeController@installation');
Route::get('accessibility', 'HomeController@accessibility');

Route::get('news', 'BlogsController@index');
Route::get('news/view/{slug}', 'BlogsController@view');


Route::get('main_page=page&id=2', function () {
    return redirect('/faq');
});

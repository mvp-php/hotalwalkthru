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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
/********************************** Dashboard Links*********************************************************/
   Route::get('/dashboard', 'DashboardController@index');
/**********************************End**********************************************************************/
/**********************************Edit profile and update profile Link ************************************/
   Route::get('/profile', 'AdminProfileController@index');
   Route::post('/updateProfile', 'AdminProfileController@updateProfileById');
/**********************************End**********************************************************************/
/**********************************Change password Link ****************************************************/
   Route::get('/changePassword', 'AdminProfileController@changePasswrod');
   Route::post('/checkoldpassword', 'AdminProfileController@CheckOldPasswordById');
   Route::post('/updatePassword', 'AdminProfileController@UpdatePassword');
/**********************************End change password link*************************************************/
/*********************************Start category master Link************************************************/
	Route::get('/category', 'AdminCategoryController@show');
	Route::get('/category-add', 'AdminCategoryController@create');
	Route::post('/category-insert', 'AdminCategoryController@store');
    Route::get('/category-edit', 'AdminCategoryController@edit');
	Route::post('/category-update', 'AdminCategoryController@update');
	Route::get('/category-delete', 'AdminCategoryController@destroy');
	Route::get('/category_ajax', 'AdminCategoryController@ajax_list');

/*********************************End Category master link**************************************************/

/*********************************Start hotel master Link************************************************/
	Route::get('/hotel', 'AdminHotelController@index');
	Route::get('/hotel-delete', 'AdminHotelController@destroy');
	Route::get('/hotel-ajax', 'AdminHotelController@ajax_list');
	Route::get('/accountActiveOrDeactive', 'AdminHotelController@ActiveOrDeactive');

/*********************************End Category master link**************************************************/
	
	/*********************************Start Subscription master Link************************************************/
	Route::get('/subscription', 'AdminSubscriptionController@index');
	Route::get('/subscriptionAdd', 'AdminSubscriptionController@create');
	Route::post('/subscriptioninsert', 'AdminSubscriptionController@store');
    Route::get('/subscriptionEdit', 'AdminSubscriptionController@edit');
	Route::post('/subscriptionUpdate', 'AdminSubscriptionController@update');
	Route::get('/subscriptionDelete', 'AdminSubscriptionController@destroy');
	Route::get('/subscriptionAjax', 'AdminSubscriptionController@ajax_list');

/*********************************End Category master link**************************************************/
   Route::get('/logout', 'AdminProfileController@logout');
   
});
<?php

use Illuminate\Http\Request;

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

Route::post('/v1/signin', 'API\v1\ServiceController@login');
Route::post('/v1/signup', 'API\v1\ServiceController@signup');
Route::get('/v1/verify_account/{id}', 'API\v1\ServiceController@verify_account');
Route::post('/v1/forgot_password', 'API\v1\ServiceController@forgot_password');
Route::post('/v1/verify_otp', 'API\v1\ServiceController@verify_otp');
Route::post('/v1/resend_otp', 'API\v1\ServiceController@resend_otp');
Route::post('/v1/reset_password', 'API\v1\ServiceController@reset_password');
Route::get('/v1/hotel_list', 'API\v1\ServiceController@hotel_list');
Route::get('/v1/hotelDetailsById', 'API\v1\ServiceController@hotelDetailsById');
Route::post('/v1/hotelLikeUnlike', 'API\v1\ServiceController@likeUnlikeByVedioId');
Route::get('/v1/LikeVedioDetailByUserID', 'API\v1\ServiceController@LikeVedioDetailByUserID');
Route::post('/v1/social_login','API\v1\ServiceController@social_login');
Route::get('/v1/userEditProfileById','API\v1\ServiceController@userEditProfileById');
Route::post('/v1/updateUserById','API\v1\ServiceController@updateUserById');
Route::get('/v1/viewVideoById','API\v1\ServiceController@viewVideoByIds');



/********************************Hotel side web services ***********************/
Route::post('/v1/hotelSignup', 'API\v1\ServiceController@Hotelsignup');
Route::get('/v1/hotelverify_account/{id}', 'API\v1\ServiceController@hotelVerifyAccount');
Route::post('/v1/hotelSignin', 'API\v1\ServiceController@hotelLogin');
Route::post('/v1/hotelForgotPassword', 'API\v1\ServiceController@hotelForgotPassword');
Route::post('/v1/hotelVerifyOtp', 'API\v1\ServiceController@hotelVerifyOtpById');
Route::post('/v1/hotelResetPassword', 'API\v1\ServiceController@hotelResetPassword');
Route::get('/v1/categoryList', 'API\v1\ServiceController@categoryList');
Route::get('/v1/hotelEditProfileById', 'API\v1\ServiceController@hotelEditProfileById');
Route::post('/v1/hotelUpdateProfileById', 'API\v1\ServiceController@updateHotelById');
Route::post('/v1/hotelWiseUploadImageVedio', 'API\v1\ServiceController@hotelWiseUploadImageVedio');
Route::post('/v1/hoteWisePromoVideo', 'API\v1\ServiceController@hotelWisePromoVedio');
Route::get('/v1/categoryWiseHotelVideo', 'API\v1\ServiceController@categoryWiseHotelVideo');
Route::post('/v1/hotelsocialLogin', 'API\v1\ServiceController@hotel_social_login');
Route::get('/v1/deleteVideoByHotelId', 'API\v1\ServiceController@deleteMulitpleVideoByHotelId');




/*end Hotel side web services************************************************/

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

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/custommail', function () {
    return view('maildesign');
});

//Auth::routes(['register' => false]);
Auth::routes();
//Auth::routes(['verify' => true]);
//Route::get('/login', 'AdminController@adminlogin')->name('login');

Route::get('/pitches', 'TestController@pitches')->name('pitches');

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'admin'], function () { 

Route::get('/admin/users', 'AdminController@users')->name('users');

Route::post('admin/updateUser','AdminController@updateData')->name('updateUser');

Route::post('/deleteUser','AdminController@deleteUserPermanently');

Route::post('/change_password','AdminController@changePassword');

Route::get('/admin/orders', 'AdminController@orders')->name('orders');

Route::post('/getsuborders', 'AdminController@getSubOrderDetails');

Route::post('/ordersUpdate','AdminController@ordersUpdate')->name('ordersUpdate');

Route::post('/statusUpdate','AdminController@orderStatusUpdate');

Route::post('/orderDestroy','AdminController@orderDestroy');
Route::get('/admin/paid', 'AdminController@paid')->name('paid');
Route::get('/admin/pending', 'AdminController@pending')->name('pending');
Route::get('/admin/cancel', 'AdminController@cancel')->name('cancel');

Route::get('admin/player', 'AdminController@getplayers')->name('player');

Route::post('/updatePlayer','AdminController@updateData');

Route::post('/playerStatusUpdate','AdminController@playerStatusUpdate');

Route::post('/destroyPlayer','AdminController@destroyPlayer'); /* ajax request for delete user*/

Route::get('/admin/coach', 'AdminController@coachs')->name('coach');

Route::post('/updateCoach','AdminController@updateCoach')->name('updateCoach');

Route::post('/coachStatusUpdate','AdminController@coachStatusUpdate');

Route::post('/delete_stripe_data','AdminController@stripeDelete');


Route::get('/admin/review','AdminController@review')->name('review');
Route::get('/admin/reviewpublish','AdminController@reviewPublish')->name('review_publish');
Route::post('/admin/reviewpublishajax','AdminController@reviewPublishAjax'); 
Route::post('/admin/reviewunpublishajax','AdminController@reviewUnpublishAjax'); 
Route::get('/admin/reviewUnpublish','AdminController@reviewUnpublish')->name('review_unpublish');
Route::get('/admin/allReview','AdminController@allReview')->name('all_review');

Route::post('/reviewUpdate','AdminController@reviewUpdate')->name('reviewUpdate');

Route::post('/destroyReview','AdminController@destroyReview');

Route::post('/statusReviewUpdate','AdminController@statusUpdateReview');

Route::get('/admin/allContent','AdminController@allContent')->name('allContent');

Route::post('/contentUpdate','AdminController@contentUpdate')->name('contentUpdate');

Route::post('/deleteContent','AdminController@deleteContent');

Route::get('/admin/addContent','AdminController@addContent')->name('add_content');

Route::post('/admin/storeContent','AdminController@storeContent')->name('store_content');

Route::get('/admin/commission','AdminController@commissions')->name('commission');

Route::post('/commissionUpdate','AdminController@commissionUpdate')->name('commissionUpdate');

Route::get('/admin/paymentTransaction','AdminController@monthlyTransaction');

Route::get('/admin/media','AdminController@getMedia');

Route::post('/reportingStatusUpdate','AdminController@reportingStatus');
Route::get('/admin/media_publish','AdminController@mediaPublish');
Route::get('/admin/media_unpublish','AdminController@mediaUnpublish');

Route::get('admin/unverify/user','AdminController@getUnverifyUsers');
});
//Route::get('/logout','AdminController@logout');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/testimage', 'TestController@convertVideoToImage');


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

 Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); 

 Route::get('/test', function() {
		// If the Content-Type and Accept headers are set to 'application/json', 
		// this will return a JSON structure. This will be cleaned up later.
		//return Article::all();
		return response()->json(['success'=>"true"]);
	});

$router->get('/key', function() {
    return str_random(32);
});


$router->get('all', 'UserController@all');

/* routing for athlete/player */
$router->get('getreview/{coach_id}','UserController@getreview'); /* get_review */
$router->get('get_player/{coach_id}','UserController@getPlayer');  /* get_players */
$router->post('review','UserController@review'); /* add review */
$router->post('setaboutmeathlete','UserController@setAthleteProfile'); /* set aboutme athlete */ 
$router->get('getaboutmeathlete/{user_id}','UserController@getAthleteProfile'); /* get aboutme athlete  */
$router->get('athlete/information/{user_id}/{connect_user_id}','UserController@getIndividualAthleteInformation'); /* individual athlete information */
$router->get('player/orders/{player_id}','UserController@getPlayerAllOrders'); /* get player orders */
$router->post('player/coachlistnames','UserController@getListOfCoachNames');  /* player for coaches list */
$router->get('get_coaches/{player_id}','UserController@getCoach'); /* get coaches */
$router->get('player/ordersdetails/{order_id}','UserController@getOrderDetails'); /* order details */


/* Routing for StripePaymentController */
$router->post('athlete/createaccount', 'StripePaymentController@stripeAthleteAccount');  /* new customer for player */
$router->get('athlete/getcards/{user_id}', 'StripePaymentController@getAllCustomerCard'); /* get player all card */
$router->post('set/coachstripedetails', 'StripePaymentController@setCoachStripeDetails');  /* get/set coach stripe details */
$router->get('currentweek/earningstats/{coach_id}', 'StripePaymentController@getCoachCurrentWeekEarning');  /* coach earningstatus */
$router->post('specific/earningdaystats', 'StripePaymentController@getCoachSpecificDayEarning'); /* coach specific day earningstats */
$router->post('delete/playercard', 'StripePaymentController@deletePlayerCard');  /* delete player cards */
$router->post('refund/charge', 'StripePaymentController@refundPlayerCharge');

/* routing for order and booking */
$router->post('book/coach', 'StripePaymentController@bookCoachTime');  /* book coach */
$router->get('bookingdate/availabilty', 'StripePaymentController@isBookingDateSloteAvailable');
$router->get('listofbooking/{player_id}', 'StripePaymentController@getMyBookingList');  /* MyBookings */
$router->post('orders', 'UserController@coachOrders');  /* Orders */
$router->post('getavilable/timeslot', 'CoachController@getAvilableTimeSlotOfCoach');  /* coach avilable time slot */
$router->post('calendar', 'StripePaymentController@calendar');  /* Calendar */

/* Routing for settings */
$router->post('setupavailablity','UserController@setup_availability');  /* setup_availablity */
$router->post('coach/travelarea','CoachController@getSetCoachTravelArea');  /* coach travel area */
 
/* Routing for both player and coach  */
$router->post('createuser', 'UserController@create'); /* create account */
$router->post('userlogin', 'UserController@login'); /* login */
$router->post('verify/email', 'UserController@verifyOrResendOtp'); /* verify email/resend otp */
$router->post('sociallogin','UserController@sociallogin');  /* social_login */
$router->post('logout', 'UserController@logout'); /* logout */
$router->post('forgetpass','UserController@forgotpasswrd');  /* forgot password */
$router->post('changepass','UserController@changepasswrd');  /* change pasword */
$router->post('adduserdata','UserController@adduserdata');  /* add userdata */

$router->post('getuserdata','UserController@getuserdata');
$router->post('updatedata','UserController@updatedata');
$router->post('coachDetail','UserController@coachDetail');
$router->post('setPersonalInfo', 'UserController@setPersonalInfo'); /* set Personal Info */
$router->get('getPersonalInfo/{user_id}', 'UserController@getPersonalInfo'); /* get Personal Info */

$router->post('update/profile', 'UserController@updateProfile');  /* update coach/player Profile Picture */
$router->get('getprofile/{user_id}', 'UserController@getProfile');  /* get coach/player Profile Picture */
$router->post('likeunlike/media', 'UserController@likeOrUnlikeMedia'); /* like/unlike media */
$router->post('comments/media', 'UserController@postCommentsOnMedia'); /*  post comments on media */
$router->post('connect/disconnect','UserController@connectDisconnect');  /* connect/disconnect */
$router->post('getcoachplayer/pitches','CoachController@getPitchesListForCoachOrPlayer'); /* get pitches list for coach/player */
$router->get('get/comments/media/{media_id}', 'CoachController@getCommentsOfMedia');  /* get comments of media */
$router->get('allCoachPlayer/{user_id}','CoachController@getAllCoachAndPlayer'); /* all coach and player */
$router->get('searchplayerorcoach','CoachController@getSearchedPlayerOrCoach'); /* search player or coach */
$router->post('media/notification','UserController@notifyMediaOfPostedUser'); /* media notification */
$router->get('hashtag/{user_id}','UserController@getHashtagPlayerInformation'); /* hashtag */
$router->get('all/mediapost/{user_id}','UserController@getUserWithConnectedUserAllPost');  /* get all media post */


/*Routing for coach */
$router->post('aboutme','CoachController@aboutmeapi'); /* about_me */
$router->get('getaboutme/{user_id}','CoachController@getaboutmeapi'); /* get_about_me */
$router->get('individualCoach/{logged_id}/{coach_id}','CoachController@getIndividualCoachInformation'); /* IndividualCoach */
$router->post('report/review', 'CoachController@updateReportReview'); /* coach report review */
$router->get('coach/myaccount/{coach_id}', 'CoachController@getCoachAccountInfo');  /* coach/player my account info */ 
$router->post('/coachmedia','CoachController@addCoachMedia'); /* coach media images */
//$router->post('/getcoachmedia','CoachController@getCoachMedia'); api may not used
$router->post('coach/add/pitchesnew','CoachController@addNewCoachPitches');/* add pitches */
$router->post('coach/updatepitch','CoachController@updatePitchData');
$router->post('coach/delete/pitches','CoachController@deletePitchOfCoach'); /* delete pitches */
$router->get('coach/pitches/{coach_id}','CoachController@getCoachPitchesList'); /* get coach added pitches list */
$router->post('coach/reschedule/timeslot','CoachController@rescheduleTimeSlot'); /* reschedule  timeslot */
//$router->get('coach/hashtag/{logged_id}','CoachController@getHashtagCoachInformation'); api may not used
/* end of coach routing */


$router->group(
    ['middleware' => 'jwt.auth'], 
    function() use ($router) {
        $router->get('users', function() {
            $users = \App\User::all();
            return response()->json($users);
        });	
    }
);

/* for testing puropse */

$router->post('setaboutmeathlete/test','TestController@setAthleteProfile'); 
$router->post('coach/stripeAccount', 'TestController@stripeAccountCreateForCoach'); 
$router->post('adddata/stripe', 'TestController@addAddinationalDataToStripe');
$router->get('testingbase', 'TestController@TestingBase');
//end 

/* coach travel */
$router->post('/setCoachTravel','CoachController@setCoachTravel');
$router->get('/getCoachTravel/{coach_id}','CoachController@getCoachTravel');




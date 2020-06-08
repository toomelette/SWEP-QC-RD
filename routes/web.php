<?php


/** Auth **/
Route::group(['as' => 'auth.'], function () {
	
	Route::get('/', 'Auth\LoginController@showLoginForm')->name('showLogin');
	Route::post('/', 'Auth\LoginController@login')->name('login');
	Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
	Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

});




/** Dashboard **/
Route::group(['prefix'=>'dashboard', 'as' => 'dashboard.', 'middleware' => ['check.user_status', 'check.user_route']], function () {


	/** HOME **/	
	Route::get('/home', 'HomeController@index')->name('home');


	/** USER **/   
	Route::post('/user/activate/{slug}', 'UserController@activate')->name('user.activate');
	Route::post('/user/deactivate/{slug}', 'UserController@deactivate')->name('user.deactivate');
	Route::post('/user/logout/{slug}', 'UserController@logout')->name('user.logout');
	Route::get('/user/{slug}/reset_password', 'UserController@resetPassword')->name('user.reset_password');
	Route::patch('/user/reset_password/{slug}', 'UserController@resetPasswordPost')->name('user.reset_password_post');
	Route::resource('user', 'UserController');


	/** PROFILE **/
	Route::get('/profile', 'ProfileController@details')->name('profile.details');
	Route::patch('/profile/update_account_username/{slug}', 'ProfileController@updateAccountUsername')->name('profile.update_account_username');
	Route::patch('/profile/update_account_password/{slug}', 'ProfileController@updateAccountPassword')->name('profile.update_account_password');
	Route::patch('/profile/update_account_color/{slug}', 'ProfileController@updateAccountColor')->name('profile.update_account_color');


	/** MENU **/
	Route::resource('menu', 'MenuController');


	/** TRADERS **/
	Route::post('/trader_registration/store_from_tr', 'TraderController@storeFromTR')->name('trader.store_from_tr');
	Route::resource('trader', 'TraderController');


	/** TRADERS CATEGORY **/
	Route::get('/trader_registration/print/{slug}', 'TraderRegistrationController@print')->name('trader_registration.print');
	Route::get('/trader_registration/reports', 'TraderRegistrationController@reports')->name('trader_registration.reports');
	Route::get('/trader_registration/reports_output', 'TraderRegistrationController@reportsOutput')->name('trader_registration.reports_output');
	Route::get('/trader_registration/list_bcd', 'TraderRegistrationController@printListBDC')->name('trader_registration.print_list_bdc');
	Route::resource('trader_registration', 'TraderRegistrationController');
	
});






/** Testing **/
// Route::get('/dashboard/test', function(){

// 	$traders = App\Models\Trader::get(); 

// 	foreach ($traders as $data) {

// 		$trader_obj = App\Models\Trader::select('trader_id')->orderBy('trader_id', 'desc')->first();

// 		$id = "T1001";

// 	 	if($trader_obj != null){
// 	 	    if($trader_obj->trader_id != null){
// 	 	        $num = str_replace('T', '', $trader_obj->trader_id) + 1;
// 	 	        $id = 'T' . $num;
// 	 	    }
// 	 	}

// 		$emp = App\Models\Trader::find($data->id);
// 		$emp->trader_id = $id;
// 		$emp->save();

// 	}

// 	return 'Success';

// });


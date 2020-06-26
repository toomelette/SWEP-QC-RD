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
	Route::post('/user/activate/{slug}', 'UserController@activate')
		->name('user.activate');
	Route::post('/user/deactivate/{slug}', 'UserController@deactivate')
		->name('user.deactivate');
	Route::post('/user/logout/{slug}', 'UserController@logout')
		->name('user.logout');
	Route::get('/user/{slug}/reset_password', 'UserController@resetPassword')
		->name('user.reset_password');
	Route::patch('/user/reset_password/{slug}', 'UserController@resetPasswordPost')
		->name('user.reset_password_post');
	Route::resource('user', 'UserController');


	/** PROFILE **/
	Route::get('/profile', 'ProfileController@details')
		->name('profile.details');
	Route::patch('/profile/update_account_username/{slug}', 'ProfileController@updateAccountUsername')
		->name('profile.update_account_username');
	Route::patch('/profile/update_account_password/{slug}', 'ProfileController@updateAccountPassword')
		->name('profile.update_account_password');
	Route::patch('/profile/update_account_color/{slug}', 'ProfileController@updateAccountColor')
		->name('profile.update_account_color');


	/** MENU **/
	Route::resource('menu', 'MenuController');


	/** TRADERS **/
	Route::post('/trader/renew_license_post/{slug}', 'TraderController@renewLicensePost')
		->name('trader.renew_license_post');
	Route::get('/trader/renewal_history/{slug}', 'TraderController@renewalHistory')
		->name('trader.renewal_history');
	Route::get('/trader/reports', 'TraderController@reports')
		->name('trader.reports');
	Route::resource('trader', 'TraderController');


	/** TRADERS Registration **/
	Route::get('/trader_registration/reports_output', 'TraderRegistrationController@reportsOutput')
		->name('trader_registration.reports_output');
	Route::get('/trader_registration/dl_word_file/{slug}', 'TraderRegistrationController@downloadWordFile')
		->name('trader_registration.dl_word_file');
	Route::resource('trader_registration', 'TraderRegistrationController');


	/** MILLS **/
	Route::post('/mill/renew_license_post/{slug}', 'MillController@renewLicensePost')
		->name('mill.renew_license_post');
	Route::get('/mill/renewal_history/{slug}', 'MillController@renewalHistory')
		->name('mill.renewal_history');
	Route::resource('mill', 'MillController');


	/** MILLS Registration **/
	Route::get('/mill_registration/dl_cover/{slug}', 'MillRegistrationController@downloadCoverLetter')
		->name('mill_registration.dl_cover');
	Route::get('/mill_registration/dl_billing/{slug}', 'MillRegistrationController@downloadBillingStatement')
		->name('mill_registration.dl_billing');
	Route::resource('mill_registration', 'MillRegistrationController');
	
	
});






/** Testing **/
// Route::get('/dashboard/test', function(){

// 	$mills = App\Models\Mill::get(); 

// 	foreach ($mills as $data) {

// 		$trader_reg_obj = App\Models\TraderRegistration::select('trader_reg_id')->orderBy('trader_reg_id', 'desc')->first();

// 		$id = "TR1001";

// 	 	if($trader_reg_obj != null){
// 	 	    if($trader_reg_obj->trader_reg_id != null){
// 	 	        $num = str_replace('TR', '', $trader_reg_obj->trader_reg_id) + 1;
// 	 	        $id = 'TR' . $num;
// 	 	    }
// 	 	}
// 		$trader = App\Models\Trader::where('tin', $data->trader_id)->first();
// 		$mill = App\Models\Mill::find($data->id);
// 		$mill->slug = Illuminate\Support\Str::random(16);
// 		$mill->save();
	
// 	}

// 	return 'Success';

// });


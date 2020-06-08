<?php


// Submenu
Route::get('/submenu/select_submenu_byMenuId/{menu_id}',
		   'Api\ApiSubmenuController@selectSubmenuByMenuId')->name('selectSubmenuByMenuId');

// Trader
Route::get('/trader/select_trader_byTraderId/{trader_id}', 
		   'Api\ApiTraderController@selectTraderByTraderId')->name('selectTraderByTraderId');



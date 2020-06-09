<?php

namespace App\Providers;


use View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider{

    
    public function boot(){

        /** VIEW COMPOSERS  **/


        // USERMENU
        View::composer('layouts.admin-sidenav', 'App\Core\ViewComposers\UserMenuComposer');


        // USER SUBMENU
        View::composer(['*'], 'App\Core\ViewComposers\UserSubmenuComposer');


        // MENU
        View::composer(['dashboard.user.create', 
                        'dashboard.user.edit'], 'App\Core\ViewComposers\MenuComposer');
        

        // SUBMENU
        View::composer(['dashboard.user.create', 
                        'dashboard.user.edit'], 'App\Core\ViewComposers\SubmenuComposer');
        

        // REGION
        View::composer(['dashboard.trader.create', 
                        'dashboard.trader.edit',
                        'dashboard.trader_registration.create',
                        'dashboard.trader_registration.edit',
                        'printables.trader_registration.list_bcyc_br',], 'App\Core\ViewComposers\RegionComposer');
        

        // TRADER
        View::composer(['dashboard.trader_registration.create', 
                        'dashboard.trader_registration.edit', 
                        'dashboard.trader_registration.index'], 'App\Core\ViewComposers\TraderComposer');
        

        // TRADER CATEGORY
        View::composer(['dashboard.trader_registration.create', 
                        'dashboard.trader_registration.edit', 
                        'dashboard.trader_registration.index', 
                        'dashboard.trader_registration.reports'], 'App\Core\ViewComposers\TraderCategoryComposer');
        

        // Crop Year
        View::composer(['dashboard.trader_registration.create', 
                        'dashboard.trader_registration.edit', 
                        'dashboard.trader_registration.index', 
                        'dashboard.trader_registration.reports'], 'App\Core\ViewComposers\CropYearComposer');

        
    }

    




    
    public function register(){

      


    
    }




}

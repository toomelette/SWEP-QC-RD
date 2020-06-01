<?php

namespace App\Providers;
 
use Illuminate\Support\ServiceProvider;
 

class RepositoryServiceProvider extends ServiceProvider {
	


	public function register(){

		$this->app->bind('App\Core\Interfaces\UserInterface', 'App\Core\Repositories\UserRepository');

		$this->app->bind('App\Core\Interfaces\UserMenuInterface', 'App\Core\Repositories\UserMenuRepository');

		$this->app->bind('App\Core\Interfaces\UserSubmenuInterface', 'App\Core\Repositories\UserSubmenuRepository');


		$this->app->bind('App\Core\Interfaces\MenuInterface', 'App\Core\Repositories\MenuRepository');

		$this->app->bind('App\Core\Interfaces\SubmenuInterface', 'App\Core\Repositories\SubmenuRepository');

		$this->app->bind('App\Core\Interfaces\ProfileInterface', 'App\Core\Repositories\ProfileRepository');

		$this->app->bind('App\Core\Interfaces\TraderInterface', 'App\Core\Repositories\TraderRepository');

		$this->app->bind('App\Core\Interfaces\TraderCategoryInterface', 'App\Core\Repositories\TraderCategoryRepository');

		$this->app->bind('App\Core\Interfaces\TraderRegistrationInterface', 'App\Core\Repositories\TraderRegistrationRepository');

		$this->app->bind('App\Core\Interfaces\RegionInterface', 'App\Core\Repositories\RegionRepository');
		
	}



}
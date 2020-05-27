<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\TraderCategoryInterface;


class TraderCategoryComposer{
   

	protected $trader_cat_repo;


	public function __construct(TraderCategoryInterface $trader_cat_repo){
		$this->trader_cat_repo = $trader_cat_repo;
	}



    public function compose($view){
        $trader_categories = $this->trader_cat_repo->getAll();
    	$view->with('global_trader_categories_all', $trader_categories);
    }



}
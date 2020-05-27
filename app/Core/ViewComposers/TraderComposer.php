<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\TraderInterface;


class TraderComposer{
   

	protected $trader_repo;


	public function __construct(TraderInterface $trader_repo){
		$this->trader_repo = $trader_repo;
	}



    public function compose($view){
        $traders = $this->trader_repo->getAll();
    	$view->with('global_traders_all', $traders);
    }



}
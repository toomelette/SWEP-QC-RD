<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\RegionInterface;


class RegionComposer{
   

	protected $region_repo;


	public function __construct(RegionInterface $region_repo){
		$this->region_repo = $region_repo;
	}



    public function compose($view){
        $regions = $this->region_repo->getAll();
    	$view->with('global_regions_all', $regions);
    }




}
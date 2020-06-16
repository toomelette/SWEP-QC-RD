<?php

namespace App\Core\ViewComposers;


use View;
use App\Core\Interfaces\CropYearInterface;


class CropYearComposer{
   

	protected $crop_year_repo;


	public function __construct(CropYearInterface $crop_year_repo){
		$this->crop_year_repo = $crop_year_repo;
	}



    public function compose($view){
        
        $crop_years = $this->crop_year_repo->getAll();
        $current_cy = $this->crop_year_repo->currentCropYear();
    	
    	$view->with([
    		'global_crop_years_all' => $crop_years,
    		'global_current_cy' => $current_cy,
    	]);

    }




}
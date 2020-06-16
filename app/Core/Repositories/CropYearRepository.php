<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\CropYearInterface;

use App\Models\CropYear;


class CropYearRepository extends BaseRepository implements CropYearInterface {
	

    protected $crop_year;


	public function __construct(CropYear $crop_year){

        $this->crop_year = $crop_year;
        parent::__construct();

    }



    public function getAll(){

        $crop_years = $this->cache->remember('crop_years:getAll', 240, function(){
            return $this->crop_year->select('crop_year_id', 'name', 'is_active')
                                   ->orderBy('name', 'desc')
                                   ->get();
        });
        
        return $crop_years;

    }



    public function currentCropYear(){

        $crop_year = $this->cache->remember('crop_years:currentCropYear', 240, function(){
            return $this->crop_year->select('crop_year_id', 'name')
                                   ->where('is_active', 1)
                                   ->first();
        });
        
        return $crop_year;

    }





    public function findByCropYearId($cy_id){

        $crop_year = $this->cache->remember('crop_years:findByCYId:'. $cy_id, 240, function() use ($cy_id){
            return $this->crop_year->select('name')->where('crop_year_id', $cy_id)->first();
        });
        
        return $crop_year;

    }



}
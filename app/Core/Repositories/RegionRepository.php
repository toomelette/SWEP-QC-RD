<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\RegionInterface;

use App\Models\Region;


class RegionRepository extends BaseRepository implements RegionInterface {
	

    protected $region;


	public function __construct(Region $region){

        $this->region = $region;
        parent::__construct();

    }



    public function getAll(){

        $regions = $this->cache->remember('regions:getAll', 240, function(){
            return $this->region->select('region_id', 'name')->get();
        });
        
        return $regions;

    }



}
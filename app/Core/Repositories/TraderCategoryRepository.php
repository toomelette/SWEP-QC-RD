<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\TraderCategoryInterface;

use App\Models\TraderCategory;


class TraderCategoryRepository extends BaseRepository implements TraderCategoryInterface {
	

    protected $trader_cat;


	public function __construct(TraderCategory $trader_cat){

        $this->trader_cat = $trader_cat;
        parent::__construct();

    }



    public function getAll(){

        $trader_categories = $this->cache->remember('trader_categories:getAll', 240, function(){
            return $this->trader_cat->select('trader_cat_id', 'name')->get();
        });
        
        return $trader_categories;

    }



}
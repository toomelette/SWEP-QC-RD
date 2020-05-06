<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\TraderInterface;

use App\Models\Trader;


class TraderRepository extends BaseRepository implements TraderInterface {
	

    protected $trader;


	public function __construct(Trader $trader){

        $this->trader = $trader;
        parent::__construct();

    }




    // public function fetch($request){

    //     $key = str_slug($request->fullUrl(), '_');
    //     $entries = isset($request->e) ? $request->e : 20;

    //     $traders = $this->cache->remember('traders:fetch:' . $key, 240, function() use ($request, $entries){

    //         $trader = $this->trader->newQuery();
            
    //         if(isset($request->q)){
    //             $trader->where('name', 'LIKE', '%'. $request->q .'%');
    //         }

    //         return $trader->select('name', 'route', 'icon', 'slug')
    //                     ->sortable()
    //                     ->orderBy('updated_at', 'desc')
    //                     ->paginate($entries);

    //     });

    //     return $traders;

    // }




    // public function store($request){

    //     $trader = new Trader;
    //     $trader->trader_id = $this->getTraderIdInc();
    //     $trader->slug = $this->str->random(16);
    //     $trader->name = $request->name;
    //     $trader->route = $request->route;
    //     $trader->icon = $request->icon;
    //     $trader->is_trader = $this->__dataType->string_to_boolean($request->is_trader);
    //     $trader->is_dropdown = $this->__dataType->string_to_boolean($request->is_dropdown);
    //     $trader->created_at = $this->carbon->now();
    //     $trader->updated_at = $this->carbon->now();
    //     $trader->ip_created = request()->ip();
    //     $trader->ip_updated = request()->ip();
    //     $trader->user_created = $this->auth->user()->user_id;
    //     $trader->user_updated = $this->auth->user()->user_id;
    //     $trader->save();
        
    //     return $trader;

    // }




    // public function update($request, $slug){

    //     $trader = $this->findBySlug($slug);
    //     $trader->name = $request->name;
    //     $trader->route = $request->route;
    //     $trader->icon = $request->icon;
    //     $trader->is_trader = $this->__dataType->string_to_boolean($request->is_trader);
    //     $trader->is_dropdown = $this->__dataType->string_to_boolean($request->is_dropdown);
    //     $trader->updated_at = $this->carbon->now();
    //     $trader->ip_updated = request()->ip();
    //     $trader->user_updated = $this->auth->user()->user_id;
    //     $trader->save();

    //     $trader->subtrader()->delete();
        
    //     return $trader;

    // }




    // public function destroy($slug){

    //     $trader = $this->findBySlug($slug);
    //     $trader->delete();
    //     $trader->subtrader()->delete();

    //     return $trader;

    // }




    // public function findBySlug($slug){

    //     $trader = $this->cache->remember('traders:findBySlug:' . $slug, 240, function() use ($slug){
    //         return $this->trader->where('slug', $slug)->first();
    //     }); 
        
    //     if(empty($trader)){
    //         abort(404);
    //     }

    //     return $trader;

    // }




    // public function findByTraderId($trader_id){

    //     $trader = $this->cache->remember('traders:findByTraderId:' . $trader_id, 240, function() use ($trader_id){
    //         return $this->trader->where('trader_id', $trader_id)->first();
    //     });
        
    //     if(empty($trader)){
    //         abort(404);
    //     }
        
    //     return $trader;

    // }




    // public function getTraderIdInc(){

    //     $id = 'M10001';

    //     $trader = $this->trader->select('trader_id')->orderBy('trader_id', 'desc')->first();

    //     if($trader != null){

    //         if($trader->trader_id != null){
    //             $num = str_replace('M', '', $trader->trader_id) + 1;
    //             $id = 'M' . $num;
    //         }
        
    //     }
        
    //     return $id;
        
    // }




    // public function getAll(){

    //     $traders = $this->cache->remember('traders:getAll', 240, function(){
    //         return $this->trader->select('trader_id', 'name')
    //                           ->with('subtrader')
    //                           ->get();
    //     });
        
    //     return $traders;

    // }




}
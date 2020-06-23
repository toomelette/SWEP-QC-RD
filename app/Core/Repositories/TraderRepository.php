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




    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $traders = $this->cache->remember('traders:fetch:' . $key, 240, function() use ($request, $entries){

            $trader = $this->trader->newQuery();
            
            if(isset($request->q)){
                $trader->where('name', 'LIKE', '%'. $request->q .'%')
                       ->orWhere('address', 'LIKE', '%'. $request->q .'%')
                       ->orWhere('tin', 'LIKE', '%'. $request->q .'%')
                       ->orWhere('tel_no', 'LIKE', '%'. $request->q .'%')
                       ->orWhere('officer', 'LIKE', '%'. $request->q .'%')
                       ->orWhere('email', 'LIKE', '%'. $request->q .'%');
            }

            return $trader->select('name', 'trader_id', 'slug')
                          ->with('traderRegistration')
                          ->sortable()
                          ->orderBy('updated_at', 'desc')
                          ->paginate($entries);

        });

        return $traders;

    }




    public function store($request){

        $trader = new Trader;
        $trader->trader_id = $this->getTraderIdInc();
        $trader->slug = $this->str->random(16);
        $trader->name = $request->name;
        $trader->region_id = $request->region_id;
        $trader->address = $request->address;
        $trader->address_second = $request->address_second;
        $trader->address_third = $request->address_third;
        $trader->tin = $request->tin;
        $trader->tel_no = $request->tel_no;
        $trader->officer = $request->officer;
        $trader->email = $request->email;
        $trader->created_at = $this->carbon->now();
        $trader->updated_at = $this->carbon->now();
        $trader->ip_created = request()->ip();
        $trader->ip_updated = request()->ip();
        $trader->user_created = $this->auth->user()->user_id;
        $trader->user_updated = $this->auth->user()->user_id;
        $trader->save();
        
        return $trader;

    }




    public function update($request, $slug){

        $trader = $this->findBySlug($slug);
        $trader->name = $request->name;
        $trader->region_id = $request->region_id;
        $trader->address = $request->address;
        $trader->address_second = $request->address_second;
        $trader->address_third = $request->address_third;
        $trader->tin = $request->tin;
        $trader->tel_no = $request->tel_no;
        $trader->officer = $request->officer;
        $trader->email = $request->email;
        $trader->updated_at = $this->carbon->now();
        $trader->ip_updated = request()->ip();
        $trader->user_updated = $this->auth->user()->user_id;
        $trader->save();
        
        return $trader;

    }




    public function destroy($slug){

        $trader = $this->findBySlug($slug);
        $trader->delete();

        return $trader;

    }




    public function findBySlug($slug){

        $trader = $this->cache->remember('traders:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->trader->where('slug', $slug)->first();
        }); 
        
        if(empty($trader)){
            abort(404);
        }

        return $trader;

    }




    public function getByTraderId($trader_id){

        $trader = $this->cache->remember('traders:getByTraderId:'.$trader_id, 240, function() use ($trader_id){
            return $this->trader->where('trader_id', $trader_id)->get();
        });
        
        return $trader;

    }




    public function getTraderIdInc(){

        $id = 'T10001';

        $trader = $this->trader->select('trader_id')->orderBy('trader_id', 'desc')->first();

        if($trader != null){

            if($trader->trader_id != null){
                $num = str_replace('T', '', $trader->trader_id) + 1;
                $id = 'T' . $num;
            }
        
        }
        
        return $id;
        
    }




    public function getAll(){

        $traders = $this->cache->remember('traders:getAll', 240, function(){
            return $this->trader->select('trader_id', 'name')->get();
        });
        
        return $traders;

    }




}
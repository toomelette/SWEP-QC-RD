<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\TraderRegistrationInterface;

use App\Models\TraderRegistration;


class TraderRegistrationRepository extends BaseRepository implements TraderRegistrationInterface {
	

    protected $trader_reg;


	public function __construct(TraderRegistration $trader_reg){

        $this->trader_reg = $trader_reg;
        parent::__construct();

    }




    // public function fetch($request){

    //     $key = str_slug($request->fullUrl(), '_');
    //     $entries = isset($request->e) ? $request->e : 20;

    //     $trader_registrations = $this->cache->remember('trader_registrations:fetch:' . $key, 240, function() use ($request, $entries){

    //         $trader_reg = $this->trader_reg->newQuery();
            
    //         if(isset($request->q)){
    //             $trader_reg->where('name', 'LIKE', '%'. $request->q .'%')
    //                    ->orWhere('address', 'LIKE', '%'. $request->q .'%')
    //                    ->orWhere('tin', 'LIKE', '%'. $request->q .'%')
    //                    ->orWhere('tel_no', 'LIKE', '%'. $request->q .'%')
    //                    ->orWhere('officer', 'LIKE', '%'. $request->q .'%')
    //                    ->orWhere('email', 'LIKE', '%'. $request->q .'%');
    //         }

    //         return $trader_reg->select('name', 'slug')
    //                       ->sortable()
    //                       ->orderBy('updated_at', 'desc')
    //                       ->paginate($entries);

    //     });

    //     return $trader_registrations;

    // }




    public function store($request){

        $trader_reg = new TraderRegistration;
        $trader_reg->trader_reg_id = $this->getTraderRegIdInc();
        $trader_reg->slug = $this->str->random(16);
        $trader_reg->control_no = $request->control_no;
        $trader_reg->trader_id = $request->trader_id;
        $trader_reg->trader_cat_id = $request->trader_cat_id;
        $trader_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
        $trader_reg->created_at = $this->carbon->now();
        $trader_reg->updated_at = $this->carbon->now();
        $trader_reg->ip_created = request()->ip();
        $trader_reg->ip_updated = request()->ip();
        $trader_reg->user_created = $this->auth->user()->user_id;
        $trader_reg->user_updated = $this->auth->user()->user_id;
        $trader_reg->save();
        
        return $trader_reg;

    }




    // public function update($request, $slug){

    //     $trader_reg = $this->findBySlug($slug);
    //     $trader_reg->name = $request->name;
    //     $trader_reg->region_id = $request->region_id;
    //     $trader_reg->address = $request->address;
    //     $trader_reg->tin = $request->tin;
    //     $trader_reg->tel_no = $request->tel_no;
    //     $trader_reg->officer = $request->officer;
    //     $trader_reg->email = $request->email;
    //     $trader_reg->updated_at = $this->carbon->now();
    //     $trader_reg->ip_updated = request()->ip();
    //     $trader_reg->user_updated = $this->auth->user()->user_id;
    //     $trader_reg->save();
        
    //     return $trader_reg;

    // }




    // public function destroy($slug){

    //     $trader_reg = $this->findBySlug($slug);
    //     $trader_reg->delete();

    //     return $trader_reg;

    // }




    // public function findBySlug($slug){

    //     $trader_reg = $this->cache->remember('trader_registrations:findBySlug:' . $slug, 240, function() use ($slug){
    //         return $this->trader_reg->where('slug', $slug)->first();
    //     }); 
        
    //     if(empty($trader_reg)){
    //         abort(404);
    //     }

    //     return $trader_reg;

    // }




    // // public function findByTraderRegistrationId($trader_reg_id){

    // //     $trader_reg = $this->cache->remember('trader_registrations:findByTraderRegistrationId:' . $trader_reg_id, 240, function() use ($trader_reg_id){
    // //         return $this->trader_reg->where('trader_reg_id', $trader_reg_id)->first();
    // //     });
        
    // //     if(empty($trader_reg)){
    // //         abort(404);
    // //     }
        
    // //     return $trader_reg;

    // // }




    public function getTraderRegIdInc(){

        $id = 'TR10001';

        $trader_reg = $this->trader_reg->select('trader_reg_id')->orderBy('trader_reg_id', 'desc')->first();

        if($trader_reg != null){

            if($trader_reg->trader_reg_id != null){
                $num = str_replace('TR', '', $trader_reg->trader_reg_id) + 1;
                $id = 'TR' . $num;
            }
        
        }
        
        return $id;
        
    }




    // public function getAll(){

    //     $trader_registrations = $this->cache->remember('trader_registrations:getAll', 240, function(){
    //         return $this->trader_reg->select('trader_reg_id', 'name')->get();
    //     });
        
    //     return $trader_registrations;

    // }




}
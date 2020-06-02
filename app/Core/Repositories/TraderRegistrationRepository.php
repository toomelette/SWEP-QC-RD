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




    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $trader_registrations = $this->cache->remember('trader_registrations:fetch:' . $key, 240, 

            function() use ($request, $entries){

                $trader_reg = $this->trader_reg->newQuery();

                $df = $this->__dataType->date_parse($request->df, 'Y-m-d');
                $dt = $this->__dataType->date_parse($request->dt, 'Y-m-d');
                
                if(isset($request->q)){
                    $trader_reg->where('control_no', 'LIKE', '%'. $request->q .'%');
                }

                if(isset($request->t)){
                    $trader_reg->where('trader_id', $request->t);
                }

                if(isset($request->tc)){
                    $trader_reg->where('trader_cat_id', $request->tc);
                }

                if(isset($request->df) || isset($request->dt)){
                    $trader_reg->whereBetween('reg_date',[$df, $dt]);
                }

                return $trader_reg->select('trader_id', 'trader_cat_id', 'control_no', 'reg_date', 'slug')
                                  ->sortable()
                                  ->orderBy('reg_date', 'desc')
                                  ->paginate($entries);

        });

        return $trader_registrations;

    }




    public function store($request){

        $trader_reg = new TraderRegistration;
        $trader_reg->trader_reg_id = $this->getTraderRegIdInc();
        $trader_reg->slug = $this->str->random(16);
        $trader_reg->control_no = $request->control_no;
        $trader_reg->trader_id = $request->trader_id;
        $trader_reg->trader_cat_id = $request->trader_cat_id;
        $trader_reg->crop_year_id = $request->crop_year_id;
        $trader_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
        $trader_reg->signatory = $request->signatory;
        $trader_reg->created_at = $this->carbon->now();
        $trader_reg->updated_at = $this->carbon->now();
        $trader_reg->ip_created = request()->ip();
        $trader_reg->ip_updated = request()->ip();
        $trader_reg->user_created = $this->auth->user()->user_id;
        $trader_reg->user_updated = $this->auth->user()->user_id;
        $trader_reg->save();
        
        return $trader_reg;

    }




    public function update($request, $slug){

        $trader_reg = $this->findBySlug($slug);
        $trader_reg->control_no = $request->control_no;
        $trader_reg->trader_id = $request->trader_id;
        $trader_reg->trader_cat_id = $request->trader_cat_id;
        $trader_reg->crop_year_id = $request->crop_year_id;
        $trader_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
        $trader_reg->signatory = $request->signatory;
        $trader_reg->updated_at = $this->carbon->now();
        $trader_reg->ip_updated = request()->ip();
        $trader_reg->user_updated = $this->auth->user()->user_id;
        $trader_reg->save();
        
        return $trader_reg;

    }




    public function destroy($slug){

        $trader_reg = $this->findBySlug($slug);
        $trader_reg->delete();

        return $trader_reg;

    }




    public function findBySlug($slug){

        $trader_reg = $this->cache->remember('trader_registrations:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->trader_reg->where('slug', $slug)->first();
        }); 
        
        if(empty($trader_reg)){
            abort(404);
        }

        return $trader_reg;

    }




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




}
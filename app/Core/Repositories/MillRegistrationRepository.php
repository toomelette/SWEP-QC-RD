<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\MillRegistrationInterface;
use App\Core\Interfaces\CropYearInterface;

use App\Models\MillRegistration;


class MillRegistrationRepository extends BaseRepository implements MillRegistrationInterface {
	

    protected $mill_reg;
    protected $crop_year_repo;


	public function __construct(MillRegistration $mill_reg, CropYearInterface $crop_year_repo){

        $this->mill_reg = $mill_reg;
        $this->crop_year_repo = $crop_year_repo;
        parent::__construct();

    }




    public function fetchBymillId($request, $mill_id){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $mill_registrations = $this->cache->remember('mill_registrations:fetchByMillId:'. $mill_id .':'. $key, 240, 

            function() use ($request, $mill_id, $entries){

                $mill_reg = $this->mill_reg->newQuery();
            
                if(isset($request->q)){
                    $mill_reg->where('license_no', 'LIKE', '%'. $request->q .'%');
                }

                return $mill_reg->select('crop_year_id', 'license_no', 'reg_date', 'mt', 'lkg', 'milling_fee', 'payment_status', 'under_payment', 'excess_payment', 'balance_fee', 'rated_capacity', 'start_milling', 'end_milling', 'planter_share', 'mill_share', 'other_share', 'slug')
                                  ->with('cropYear')
                                  ->where('mill_id', $mill_id)
                                  ->sortable()
                                  ->orderBy('reg_date', 'desc')
                                  ->paginate($entries);

        });

        return $mill_registrations;

    }




    public function store($request, $mill){

        $mill_reg = new MillRegistration;
        $mill_reg->slug = $this->str->random(16);
        $mill_reg->mill_reg_id = $this->getMillRegIdInc();
        $mill_reg->mill_id = $mill->mill_id;
        $mill_reg->crop_year_id = $request->crop_year_id;
        $mill_reg->license_no = $this->getLicenseNoInc($request);
        $mill_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
        $mill_reg->mt = $this->__dataType->string_to_num($request->mt);
        $mill_reg->lkg = $this->__dataType->string_to_num($request->lkg);  
        $mill_reg->milling_fee = $this->__dataType->string_to_num($request->milling_fee);   
        $mill_reg->payment_status = $request->payment_status;    
        $mill_reg->under_payment = $this->__dataType->string_to_num($request->under_payment); 
        $mill_reg->excess_payment = $this->__dataType->string_to_num($request->excess_payment); 
        $mill_reg->balance_fee = $this->__dataType->string_to_num($request->balance_fee); 
        $mill_reg->rated_capacity = $this->__dataType->string_to_num($request->rated_capacity); 
        $mill_reg->start_milling = $this->__dataType->date_parse($request->start_milling);
        $mill_reg->end_milling = $this->__dataType->date_parse($request->end_milling);
        $mill_reg->planter_share = $this->__dataType->string_to_num($request->planter_share);
        $mill_reg->mill_share = $this->__dataType->string_to_num($request->mill_share);
        $mill_reg->other_share = $request->other_share;
        $mill_reg->created_at = $this->carbon->now();
        $mill_reg->updated_at = $this->carbon->now();
        $mill_reg->ip_created = request()->ip();
        $mill_reg->ip_updated = request()->ip();
        $mill_reg->user_created = $this->auth->user()->user_id;
        $mill_reg->user_updated = $this->auth->user()->user_id;
        $mill_reg->save();
        
        return $mill_reg;

    }




    public function update($request, $slug){

        $mill_reg = $this->findBySlug($slug);
        $mill_reg->crop_year_id = $request->crop_year_id;
        $mill_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
        $mill_reg->mt = $this->__dataType->string_to_num($request->mt);
        $mill_reg->lkg = $this->__dataType->string_to_num($request->lkg);  
        $mill_reg->milling_fee = $this->__dataType->string_to_num($request->milling_fee);   
        $mill_reg->payment_status = $request->payment_status;    
        $mill_reg->under_payment = $this->__dataType->string_to_num($request->under_payment); 
        $mill_reg->excess_payment = $this->__dataType->string_to_num($request->excess_payment); 
        $mill_reg->balance_fee = $this->__dataType->string_to_num($request->balance_fee); 
        $mill_reg->rated_capacity = $this->__dataType->string_to_num($request->rated_capacity); 
        $mill_reg->start_milling = $this->__dataType->date_parse($request->start_milling);
        $mill_reg->end_milling = $this->__dataType->date_parse($request->end_milling);
        $mill_reg->planter_share = $this->__dataType->string_to_num($request->planter_share);
        $mill_reg->mill_share = $this->__dataType->string_to_num($request->mill_share);
        $mill_reg->other_share = $request->other_share;
        $mill_reg->updated_at = $this->carbon->now();
        $mill_reg->ip_updated = request()->ip();
        $mill_reg->user_updated = $this->auth->user()->user_id;
        $mill_reg->save();
        
        return $mill_reg;

    }




    public function destroy($slug){

        $mill_reg = $this->findBySlug($slug);
        $mill_reg->delete();
        return $mill_reg;

    }




    public function findBySlug($slug){

        $mill_reg = $this->cache->remember('mill_registrations:findBySlug:' . $slug, 240, 
            function() use ($slug){
                return $this->mill_reg->where('slug', $slug)
                                      ->with('mill', 'cropYear')
                                      ->first();
            }
        ); 
        
        if(empty($mill_reg)){ abort(404); }

        return $mill_reg;

    }




    public function getMillRegIdInc(){

        $id = 'MR10001';
        $mill_reg = $this->mill_reg->select('mill_reg_id')->orderBy('mill_reg_id', 'desc')->first();

        if($mill_reg != null){
            if($mill_reg->mill_reg_id != null){
                $num = str_replace('MR', '', $mill_reg->mill_reg_id) + 1;
                $id = 'MR' . $num;
            }
        }
        
        return $id;
        
    }




    public function getLicenseNoInc($request){

        $crop_year = $this->crop_year_repo->findByCropYearId($request->crop_year_id);
        $crop_year_text = substr($crop_year->name, -4);
        $mill_license_no = $crop_year_text.'-01';

        $mill_reg = $this->mill_reg->select('license_no')
                                   ->where('crop_year_id', $request->crop_year_id)
                                   ->orderBy('license_no', 'desc')
                                   ->first();

         if($mill_reg != null){
            if($mill_reg->license_no != null){
                $num = str_replace($crop_year_text .'-', '', $mill_reg->license_no) + 01;
                $num = str_pad($num, 2, '0', STR_PAD_LEFT);
                $mill_license_no = $crop_year_text .'-' . $num; 
            }
        }

        return $mill_license_no;
        
    }




    public function isMillExistInCY($crop_year_id, $mill_id){

        $mill_reg = $this->cache->remember('mill_registrations:isMillExistInCY:'.$crop_year_id.':'.$mill_id, 240, 
            function() use ($crop_year_id, $mill_id){
                return $this->mill_reg->where('crop_year_id', $crop_year_id)
                                      ->where('mill_id', $mill_id)
                                      ->exists();
        }); 

        return $mill_reg;

    }




    public function getByRegDate($df, $dt){

        $mill_reg = $this->mill_reg->newQuery();

        if (isset($df) && isset($dt)) {
            $df = $this->__dataType->date_parse($df, 'Y-m-d');
            $dt = $this->__dataType->date_parse($dt, 'Y-m-d');
            $mill_reg->whereBetween('reg_date',[$df, $dt]);
        }

        return $mill_reg->select('mill_id', 'crop_year_id', 'license_no', 'reg_date', 'mt', 'lkg', 'milling_fee', 'payment_status', 'under_payment', 'excess_payment', 'balance_fee', 'rated_capacity', 'start_milling', 'end_milling')
                        ->with('mill', 'cropYear')
                        ->get();

    }




    public function getByCropYearId($cy_id){

        $mill_reg = $this->mill_reg->newQuery();

        if (isset($cy_id)) {
            $mill_reg->where('crop_year_id', $cy_id);
        }

        return $mill_reg->select('mill_id', 'crop_year_id', 'license_no', 'reg_date', 'mt', 'lkg', 'milling_fee', 'payment_status', 'under_payment', 'excess_payment', 'balance_fee', 'rated_capacity', 'start_milling', 'end_milling', 'planter_share', 'mill_share', 'other_share')
                        ->with('mill', 'cropYear')
                        ->get();
                          
    }





}
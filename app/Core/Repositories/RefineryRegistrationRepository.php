<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\RefineryRegistrationInterface;
use App\Core\Interfaces\CropYearInterface;

use App\Models\RefineryRegistration;


class RefineryRegistrationRepository extends BaseRepository implements RefineryRegistrationInterface {
	

    protected $refinery_reg;
    protected $crop_year_repo;


	public function __construct(RefineryRegistration $refinery_reg, CropYearInterface $crop_year_repo){
        $this->refinery_reg = $refinery_reg;
        $this->crop_year_repo = $crop_year_repo;
        parent::__construct();
    }




    public function fetchByRefineryId($request, $refinery_id){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $refinery_registrations = $this->cache->remember('refinery_registrations:fetchByRefineryId:'. $refinery_id .':'. $key, 240, 

            function() use ($request, $refinery_id, $entries){

                $refinery_reg = $this->refinery_reg->newQuery();
            
                if(isset($request->q)){
                    $refinery_reg->where('license_no', 'LIKE', '%'. $request->q .'%');
                }

                return $refinery_reg->select('crop_year_id', 'license_no', 'reg_date', 'rated_capacity', 'slug')
                                    ->with('cropYear')
                                    ->where('refinery_id', $refinery_id)
                                    ->sortable()
                                    ->orderBy('reg_date', 'desc')
                                    ->paginate($entries);

        });

        return $refinery_registrations;

    }




    public function store($request, $refinery){

        $refinery_reg = new RefineryRegistration;
        $refinery_reg->slug = $this->str->random(16);
        $refinery_reg->refinery_reg_id = $this->getRefineryRegIdInc();
        $refinery_reg->refinery_id = $refinery->refinery_id;
        $refinery_reg->crop_year_id = $request->crop_year_id;
        $refinery_reg->license_no = $this->getLicenseNoInc($request);
        $refinery_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
        $refinery_reg->rated_capacity = $this->__dataType->string_to_num($request->rated_capacity); 
        $refinery_reg->cover_letter_address = $refinery->cover_letter_address;
        $refinery_reg->license_address = $refinery->license_address;
        $refinery_reg->created_at = $this->carbon->now();
        $refinery_reg->updated_at = $this->carbon->now();
        $refinery_reg->ip_created = request()->ip();
        $refinery_reg->ip_updated = request()->ip();
        $refinery_reg->user_created = $this->auth->user()->user_id;
        $refinery_reg->user_updated = $this->auth->user()->user_id;
        $refinery_reg->save();
        
        return $refinery_reg;

    }




    public function update($request, $slug){

        $refinery_reg = $this->findBySlug($slug);
        $refinery_reg->license_no = $request->license_no;
        $refinery_reg->crop_year_id = $request->crop_year_id;
        $refinery_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
        $refinery_reg->rated_capacity = $this->__dataType->string_to_num($request->rated_capacity); 
        $refinery_reg->updated_at = $this->carbon->now();
        $refinery_reg->ip_updated = request()->ip();
        $refinery_reg->user_updated = $this->auth->user()->user_id;
        $refinery_reg->save();
        
        return $refinery_reg;

    }




    public function destroy($slug){

        $refinery_reg = $this->findBySlug($slug);
        $refinery_reg->delete();
        return $refinery_reg;

    }




    public function findBySlug($slug){

        $refinery_reg = $this->refinery_reg->where('slug', $slug)
                                           ->with('refinery', 'cropYear')
                                           ->first();
                                           
        if(empty($refinery_reg)){ abort(404); }

        return $refinery_reg;

    }




    public function getRefineryRegIdInc(){

        $id = 'RR10001';
        $refinery_reg = $this->refinery_reg->select('refinery_reg_id')
                                           ->orderBy('refinery_reg_id', 'desc')
                                           ->first();

        if($refinery_reg != null){
            if($refinery_reg->refinery_reg_id != null){
                $num = str_replace('RR', '', $refinery_reg->refinery_reg_id) + 1;
                $id = 'RR' . $num;
            }
        }
        
        return $id;
        
    }




    public function getLicenseNoInc($request){

        $crop_year = $this->crop_year_repo->findByCropYearId($request->crop_year_id);
        $crop_year_text = substr($crop_year->name, -4);
        $refinery_license_no = $crop_year_text.'-01';

        $refinery_reg = $this->refinery_reg->select('license_no')
                                           ->where('crop_year_id', $request->crop_year_id)
                                           ->orderBy('license_no', 'desc')
                                           ->first();

         if($refinery_reg != null){
            if($refinery_reg->license_no != null){
                $num = str_replace($crop_year_text .'-', '', $refinery_reg->license_no) + 01;
                $num = str_pad($num, 2, '0', STR_PAD_LEFT);
                $refinery_license_no = $crop_year_text .'-' . $num; 
            }
        }

        return $refinery_license_no;
        
    }





    public function isRefineryExistInCY($crop_year_id, $refinery_id){

        $refinery_reg = $this->cache->remember('refinery_registrations:isRefineryExistInCY:'.$crop_year_id.':'.$refinery_id, 240, 
            function() use ($crop_year_id, $refinery_id){
                return $this->refinery_reg->where('crop_year_id', $crop_year_id)
                                          ->where('refinery_id', $refinery_id)
                                          ->exists();
        }); 

        return $refinery_reg;

    }




    

    public function getByRegDate($df, $dt){

        $refinery_reg = $this->refinery_reg->newQuery();

        if (isset($df) && isset($dt)){
            $df = $this->__dataType->date_parse($df, 'Y-m-d');
            $dt = $this->__dataType->date_parse($dt, 'Y-m-d');
            $refinery_reg->whereBetween('reg_date',[$df, $dt]);
        }

        return $refinery_reg->select('refinery_id', 'crop_year_id', 'license_no', 'reg_date', 'rated_capacity')
                            ->with('refinery', 'cropYear')
                            ->get();

    }




    public function getByCropYearId($cy_id){

        $refinery_reg = $this->refinery_reg->newQuery();

        if (isset($cy_id)){
            $refinery_reg->where('crop_year_id', $cy_id);
        }

        return $refinery_reg->select('refinery_id', 'crop_year_id', 'license_no', 'reg_date', 'rated_capacity')
                            ->with('refinery', 'cropYear')
                            ->get();
                          
    }





}
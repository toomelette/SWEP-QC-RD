<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\RefineryRegistrationInterface;

use App\Models\RefineryRegistration;


class RefineryRegistrationRepository extends BaseRepository implements RefineryRegistrationInterface {
	

    protected $refinery_reg;


	public function __construct(RefineryRegistration $refinery_reg){

        $this->refinery_reg = $refinery_reg;
        parent::__construct();

    }




    public function fetchByRefineryId($request, $refinery_id){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $refinery_registrations = $this->cache->remember('refinery_registrations:fetchByRefineryId:'. $refinery_id .':'. $key, 240, 

            function() use ($request, $refinery_id, $entries){

                $refinery_reg = $this->refinery_reg->newQuery();

                return $refinery_reg->select('crop_year_id', 'license_no', 'reg_date', 'slug')
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
        $refinery_reg->license_no = $request->license_no;
        $refinery_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
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
        $refinery_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
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

        $refinery_reg = $this->cache->remember('refinery_registrations:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->refinery_reg->where('slug', $slug)
                                      ->with('refinery', 'cropYear')
                                      ->first();
        }); 
        
        if(empty($refinery_reg)){
            abort(404);
        }

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





    public function isRefineryExistInCY($crop_year_id, $refinery_id){

        $refinery_reg = $this->cache->remember('refinery_registrations:isRefineryExistInCY:'.$crop_year_id.':'.$refinery_id, 240, 
            function() use ($crop_year_id, $refinery_id){
                return $this->refinery_reg->where('crop_year_id', $crop_year_id)
                                          ->where('refinery_id', $refinery_id)
                                          ->exists();
        }); 

        return $refinery_reg;

    }




    // public function getByRegDate_Category($df, $dt, $tc_id){

    //     $refinery_reg = $this->refinery_reg->newQuery();

    //     if (isset($df) && isset($dt)) {
    //         $df = $this->__dataType->date_parse($df, 'Y-m-d');
    //         $dt = $this->__dataType->date_parse($dt, 'Y-m-d');
    //         $refinery_reg->whereBetween('reg_date',[$df, $dt]);
    //     }

    //     if (isset($tc_id)) {
    //         $refinery_reg->where('refinery_cat_id', $tc_id);
    //     }

    //     return $refinery_reg->select('refinery_id', 'refinery_cat_id', 'crop_year_id', 'refinery_officer', 'refinery_email', 'control_no', 'reg_date', 'signatory')
    //                       ->with('refinery','refinery.region', 'refineryCategory', 'cropYear')
    //                       ->get();

    // }




    // public function getByCropYearId_Category($cy_id, $tc_id){

    //     $refinery_reg = $this->refinery_reg->newQuery();

    //     if (isset($cy_id)) {
    //         $refinery_reg->where('crop_year_id', $cy_id);
    //     }

    //     if (isset($tc_id)) {
    //         $refinery_reg->where('refinery_cat_id', $tc_id);
    //     }

    //     return $refinery_reg->select('refinery_id', 'refinery_officer', 'refinery_email')
    //                       ->with('refinery', 'refinery.region')
    //                       ->get();
                          
    // }





}
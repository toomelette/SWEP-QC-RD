<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\TraderRegistrationInterface;
use App\Core\Interfaces\CropYearInterface;

use App\Models\TraderRegistration;


class TraderRegistrationRepository extends BaseRepository implements TraderRegistrationInterface {
	

    protected $trader_reg;
    protected $crop_year_repo;


	public function __construct(TraderRegistration $trader_reg, CropYearInterface $crop_year_repo){
        $this->trader_reg = $trader_reg;
        $this->crop_year_repo = $crop_year_repo;
        parent::__construct();
    }




    public function fetchByTraderId($request, $trader_id){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $trader_registrations = $this->cache->remember('trader_registrations:fetchByTraderId:'. $trader_id .':'. $key, 240, 

            function() use ($request, $trader_id, $entries){

                $trader_reg = $this->trader_reg->newQuery();
            
                if(isset($request->q)){
                    $trader_reg->where('control_no', 'LIKE', '%'. $request->q .'%');
                }

                return $trader_reg->select('crop_year_id', 'trader_cat_id', 'control_no', 'reg_date', 'slug')
                                  ->with('cropYear', 'traderCategory')
                                  ->where('trader_id', $trader_id)
                                  ->sortable()
                                  ->orderBy('reg_date', 'desc')
                                  ->paginate($entries);

        });

        return $trader_registrations;

    }




    public function store($request, $trader){

        $trader_reg = new TraderRegistration;
        $trader_reg->trader_reg_id = $this->getTraderRegIdInc();
        $trader_reg->slug = $this->str->random(16);
        $trader_reg->control_no = $this->getControlNoInc($request);
        $trader_reg->trader_cat_id = $request->trader_cat_id;
        $trader_reg->crop_year_id = $request->crop_year_id;
        $trader_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
        $trader_reg->trader_id = $trader->trader_id;
        $trader_reg->trader_officer = $trader->officer;
        $trader_reg->trader_email = $trader->email;
        $trader_reg->signatory = 'HERMENEGILDO R. SERAFICA';
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
        $trader_reg->trader_cat_id = $request->trader_cat_id;
        $trader_reg->crop_year_id = $request->crop_year_id;
        $trader_reg->reg_date = $this->__dataType->date_parse($request->reg_date);
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




    public function getControlNoInc($request){

        $crop_year = $this->crop_year_repo->findByCropYearId($request->crop_year_id);

        $crop_year_text = substr($crop_year->name, -4);

        $trader_reg = $this->trader_reg->select('control_no')
                                       ->where('crop_year_id', $request->crop_year_id)
                                       ->where('trader_cat_id', $request->trader_cat_id)
                                       ->orderBy('control_no', 'desc')
                                       ->first();
                                       

        if ($request->trader_cat_id == 'TC1001') {
            $sugar_dom_cn = 'ST-'.$crop_year_text.'-001';
             if($trader_reg != null){
                if($trader_reg->control_no != null){
                    $num = str_replace('ST-'.$crop_year_text.'-', '', $trader_reg->control_no) + 001;
                    if ($num < 100) {
                        $num = str_pad($num, 3, '0', STR_PAD_LEFT);
                    }elseif ($num >= 100) {
                        $num = str_pad($num, 1, '0', STR_PAD_LEFT);
                    }
                    $sugar_dom_cn = 'ST-'.$crop_year_text.'-' . $num; 
                }
            }
            return $sugar_dom_cn;
        }

                
        if ($request->trader_cat_id == 'TC1002') {
            $sugar_int_cn = 'ST-'.$crop_year_text.'-001-I';
            if($trader_reg != null){
                if($trader_reg->control_no != null){
                    $num = str_replace('ST-'.$crop_year_text.'-', '', $trader_reg->control_no);
                    $num = str_replace('-I', '', $num) + 001;
                    if ($num < 100) {
                        $num = str_pad($num, 3, '0', STR_PAD_LEFT);
                    }elseif ($num >= 100) {
                        $num = str_pad($num, 1, '0', STR_PAD_LEFT);
                    }
                    $sugar_int_cn = 'ST-'. $crop_year_text .'-'. $num .'-I'; 
                }
            }
            return $sugar_int_cn;
        }


        if ($request->trader_cat_id == 'TC1003') {
            $molasses_dom_cn = 'MT-'.$crop_year_text.'-001';
             if($trader_reg != null){
                if($trader_reg->control_no != null){
                    $num = str_replace('MT-'.$crop_year_text.'-', '', $trader_reg->control_no) + 001;
                    if ($num < 100) {
                        $num = str_pad($num, 3, '0', STR_PAD_LEFT);
                    }elseif ($num >= 100) {
                        $num = str_pad($num, 1, '0', STR_PAD_LEFT);
                    }
                    $molasses_dom_cn = 'MT-'.$crop_year_text.'-' . $num; 
                }
            }
            return $molasses_dom_cn;
        }

                
        if ($request->trader_cat_id == 'TC1004') {
            $molasses_int_cn = 'MT-'.$crop_year_text.'-001-I';
            if($trader_reg != null){
                if($trader_reg->control_no != null){
                    $num = str_replace('MT-'.$crop_year_text.'-', '', $trader_reg->control_no);
                    $num = str_replace('-I', '', $num) + 001;
                    if ($num < 100) {
                        $num = str_pad($num, 3, '0', STR_PAD_LEFT);
                    }elseif ($num >= 100) {
                        $num = str_pad($num, 1, '0', STR_PAD_LEFT);
                    }
                    $molasses_int_cn = 'MT-'. $crop_year_text .'-'. $num .'-I'; 
                }
            }
            return $molasses_int_cn;
        }


        if ($request->trader_cat_id == 'TC1005') {
            $molasses_dom_cn = 'MusT-'.$crop_year_text.'-001';
             if($trader_reg != null){
                if($trader_reg->control_no != null){
                    $num = str_replace('MusT-'.$crop_year_text.'-', '', $trader_reg->control_no) + 001;
                    if ($num < 100) {
                        $num = str_pad($num, 3, '0', STR_PAD_LEFT);
                    }elseif ($num >= 100) {
                        $num = str_pad($num, 1, '0', STR_PAD_LEFT);
                    }
                    $molasses_dom_cn = 'MusT-'.$crop_year_text.'-' . $num; 
                }
            }
            return $molasses_dom_cn;
        }

                
        if ($request->trader_cat_id == 'TC1006') {
            $molasses_int_cn = 'ST-'.$crop_year_text.'-001-F';
            if($trader_reg != null){
                if($trader_reg->control_no != null){
                    $num = str_replace('ST-'.$crop_year_text.'-', '', $trader_reg->control_no);
                    $num = str_replace('-F', '', $num) + 001;
                    if ($num < 100) {
                        $num = str_pad($num, 3, '0', STR_PAD_LEFT);
                    }elseif ($num >= 100) {
                        $num = str_pad($num, 1, '0', STR_PAD_LEFT);
                    }
                    $molasses_int_cn = 'ST-'. $crop_year_text .'-'. $num .'-F'; 
                }
            }
            return $molasses_int_cn;
        }
        

    }




    public function isTraderExistInCY_CAT($crop_year_id, $trader_id, $trader_cat_id){

        $trader_reg = $this->cache->remember('trader_registrations:isTraderExistInCY_CAT:'.$crop_year_id.':'.$trader_id.':'.$trader_cat_id, 240, 
            function() use ($crop_year_id, $trader_id, $trader_cat_id){
                return $this->trader_reg->where('crop_year_id', $crop_year_id)
                                        ->where('trader_id', $trader_id)
                                        ->where('trader_cat_id', $trader_cat_id)
                                        ->exists();
        }); 

        return $trader_reg;

    }




    public function getByRegDate_Category($df, $dt, $tc_id){

        $trader_reg = $this->trader_reg->newQuery();

        if (isset($df) && isset($dt)) {
            $df = $this->__dataType->date_parse($df, 'Y-m-d');
            $dt = $this->__dataType->date_parse($dt, 'Y-m-d');
            $trader_reg->whereBetween('reg_date',[$df, $dt]);
        }

        if (isset($tc_id)) {
            $trader_reg->where('trader_cat_id', $tc_id);
        }

        return $trader_reg->select('trader_id', 'trader_cat_id', 'crop_year_id', 'trader_officer', 'trader_email', 'control_no', 'reg_date', 'signatory')
                          ->with('trader','trader.region', 'traderCategory', 'cropYear')
                          ->get();

    }




    public function getByCropYearId_Category($cy_id, $tc_id){

        $trader_reg = $this->trader_reg->newQuery();

        if (isset($cy_id)) {
            $trader_reg->where('crop_year_id', $cy_id);
        }

        if (isset($tc_id)) {
            $trader_reg->where('trader_cat_id', $tc_id);
        }

        return $trader_reg->select('trader_id', 'trader_officer', 'trader_email')
                          ->with('trader', 'trader.region')
                          ->get();
                          
    }




    public function getByCropYearId($cy_id){

        $trader_reg = $this->trader_reg->newQuery();

        if (isset($cy_id)) {
            $trader_reg->where('crop_year_id', $cy_id);
        }

        return $trader_reg->select('trader_id', 'trader_cat_id', 'reg_date')
                          ->with('trader')
                          ->get();
                          
    }




    public function getByRegDate($df, $dt){

        $trader_reg = $this->trader_reg->newQuery();

        if (isset($df) && isset($dt)) {
            $df = $this->__dataType->date_parse($df, 'Y-m-d');
            $dt = $this->__dataType->date_parse($dt, 'Y-m-d');
            $trader_reg->whereBetween('reg_date',[$df, $dt]);
        }

        return $trader_reg->select('trader_id', 'trader_cat_id')
                          ->with('trader')
                          ->get();

    }




}
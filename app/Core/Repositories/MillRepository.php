<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\MillInterface;

use App\Models\Mill;


class MillRepository extends BaseRepository implements MillInterface {
	

    protected $mill;


	public function __construct(Mill $mill){

        $this->mill = $mill;
        parent::__construct();

    }




    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $mills = $this->cache->remember('mills:fetch:' . $key, 240, function() use ($request, $entries){

            $mill = $this->mill->newQuery();
            
            if(isset($request->q)){
                $mill->where('name', 'LIKE', '%'. $request->q .'%')
                     ->orWhere('address', 'LIKE', '%'. $request->q .'%')
                     ->orWhere('tel_no', 'LIKE', '%'. $request->q .'%')
                     ->orWhere('fax_no', 'LIKE', '%'. $request->q .'%')
                     ->orWhere('officer', 'LIKE', '%'. $request->q .'%')
                     ->orWhere('salutation', 'LIKE', '%'. $request->q .'%');
            }

            return $mill->select('name', 'mill_id', 'slug')
                        ->with('millRegistration')
                        ->sortable()
                        ->orderBy('updated_at', 'desc')
                        ->paginate($entries);

        });

        return $mills;

    }




    public function store($request){

        $mill = new Mill;
        $mill->slug = $this->str->random(16);
        $mill->mill_id = $this->getMillIdInc();
        $mill->name = $request->name;
        $mill->address = $request->address;
        $mill->address_second = $request->address_second;
        $mill->address_third = $request->address_third;
        $mill->tel_no = $request->tel_no;
        $mill->tel_no_second = $request->tel_no_second;
        $mill->fax_no = $request->fax_no;
        $mill->fax_no_second = $request->fax_no_second;
        $mill->email = $request->email;
        $mill->region_id = $request->region_id;
        $mill->report_region = $request->report_region;
        $mill->officer = $request->officer;
        $mill->position = $request->position;
        $mill->salutation = $request->salutation;
        $mill->cover_letter_address = $request->cover_letter_address;
        $mill->billing_address = $request->billing_address;
        $mill->license_address = $request->license_address;
        $mill->created_at = $this->carbon->now();
        $mill->updated_at = $this->carbon->now();
        $mill->ip_created = request()->ip();
        $mill->ip_updated = request()->ip();
        $mill->user_created = $this->auth->user()->user_id;
        $mill->user_updated = $this->auth->user()->user_id;
        $mill->save();
        
        return $mill;

    }




    public function update($request, $slug){

        $mill = $this->findBySlug($slug);
        $mill->name = $request->name;
        $mill->address = $request->address;
        $mill->address_second = $request->address_second;
        $mill->address_third = $request->address_third;
        $mill->tel_no = $request->tel_no;
        $mill->tel_no_second = $request->tel_no_second;
        $mill->fax_no = $request->fax_no;
        $mill->fax_no_second = $request->fax_no_second;
        $mill->email = $request->email;
        $mill->region_id = $request->region_id;
        $mill->report_region = $request->report_region;
        $mill->officer = $request->officer;
        $mill->position = $request->position;
        $mill->salutation = $request->salutation;
        $mill->cover_letter_address = $request->cover_letter_address;
        $mill->billing_address = $request->billing_address;
        $mill->license_address = $request->license_address;
        $mill->updated_at = $this->carbon->now();
        $mill->ip_updated = request()->ip();
        $mill->user_updated = $this->auth->user()->user_id;
        $mill->save();
        
        return $mill;

    }




    public function destroy($slug){

        $mill = $this->findBySlug($slug);
        $mill->delete();

        return $mill;

    }




    public function findBySlug($slug){

        $mill = $this->cache->remember('mills:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->mill->where('slug', $slug)->first();
        }); 
        
        if(empty($mill)){ abort(404); }

        return $mill;

    }




    public function getMillIdInc(){

        $id = 'M1001';
        $mill = $this->mill->select('mill_id')->orderBy('mill_id', 'desc')->first();

        if($mill != null){
            if($mill->mill_id != null){
                $num = str_replace('M', '', $mill->mill_id) + 1;
                $id = 'M' . $num;
            }
        }
        
        return $id;
        
    }




}
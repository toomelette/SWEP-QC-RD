<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\RefineryInterface;

use App\Models\Refinery;


class RefineryRepository extends BaseRepository implements RefineryInterface {
	

    protected $refinery;


	public function __construct(Refinery $refinery){

        $this->refinery = $refinery;
        parent::__construct();

    }




    public function fetch($request){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $refineries = $this->cache->remember('refineries:fetch:' . $key, 240, function() use ($request, $entries){

            $refinery = $this->refinery->newQuery();
            
            if(isset($request->q)){
                $refinery->where('name', 'LIKE', '%'. $request->q .'%')
                         ->orWhere('address', 'LIKE', '%'. $request->q .'%')
                         ->orWhere('tel_no', 'LIKE', '%'. $request->q .'%')
                         ->orWhere('fax_no', 'LIKE', '%'. $request->q .'%')
                         ->orWhere('officer', 'LIKE', '%'. $request->q .'%')
                         ->orWhere('salutation', 'LIKE', '%'. $request->q .'%');
            }

            return $refinery->select('name', 'refinery_id', 'slug')
                            ->with('refineryRegistration')
                            ->sortable()
                            ->orderBy('updated_at', 'desc')
                            ->paginate($entries);

        });

        return $refineries;

    }




    public function store($request){

        $refinery = new Refinery;
        $refinery->slug = $this->str->random(16);
        $refinery->refinery_id = $this->getRefineryIdInc();
        $refinery->name = $request->name;
        $refinery->address = $request->address;
        $refinery->address_second = $request->address_second;
        $refinery->address_third = $request->address_third;
        $refinery->tel_no = $request->tel_no;
        $refinery->tel_no_second = $request->tel_no_second;
        $refinery->fax_no = $request->fax_no;
        $refinery->fax_no_second = $request->fax_no_second;
        $refinery->officer = $request->officer;
        $refinery->position = $request->position;
        $refinery->salutation = $request->salutation;
        $refinery->created_at = $this->carbon->now();
        $refinery->updated_at = $this->carbon->now();
        $refinery->ip_created = request()->ip();
        $refinery->ip_updated = request()->ip();
        $refinery->user_created = $this->auth->user()->user_id;
        $refinery->user_updated = $this->auth->user()->user_id;
        $refinery->save();
        
        return $refinery;

    }




    public function update($request, $slug){

        $refinery = $this->findBySlug($slug);
        $refinery->name = $request->name;
        $refinery->address = $request->address;
        $refinery->address_second = $request->address_second;
        $refinery->address_third = $request->address_third;
        $refinery->tel_no = $request->tel_no;
        $refinery->tel_no_second = $request->tel_no_second;
        $refinery->fax_no = $request->fax_no;
        $refinery->fax_no_second = $request->fax_no_second;
        $refinery->officer = $request->officer;
        $refinery->position = $request->position;
        $refinery->salutation = $request->salutation;
        $refinery->updated_at = $this->carbon->now();
        $refinery->ip_updated = request()->ip();
        $refinery->user_updated = $this->auth->user()->user_id;
        $refinery->save();
        
        return $refinery;

    }




    public function destroy($slug){

        $refinery = $this->findBySlug($slug);
        $refinery->delete();

        return $refinery;

    }




    public function findBySlug($slug){

        $refinery = $this->cache->remember('refineries:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->refinery->where('slug', $slug)->first();
        }); 
        
        if(empty($refinery)){ abort(404); }

        return $refinery;

    }




    public function getRefineryIdInc(){

        $id = 'R1001';
        $refinery = $this->refinery->select('refinery_id')->orderBy('refinery_id', 'desc')->first();

        if($refinery != null){
            if($refinery->refinery_id != null){
                $num = str_replace('R', '', $refinery->refinery_id) + 1;
                $id = 'R' . $num;
            }
        }
        
        return $id;
        
    }




}
<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\TraderFileInterface;

use App\Models\TraderFile;


class TraderFileRepository extends BaseRepository implements TraderFileInterface {
	

    protected $trader_file;


	public function __construct(TraderFile $trader_file){

        $this->trader_file = $trader_file;
        parent::__construct();

    }




    public function fetchByTraderId($request, $trader_id){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $trader_files = $this->cache->remember('trader_files:fetchByTraderId:'. $trader_id .':'. $key, 240, 
            
            function() use ($request, $trader_id, $entries){

                $trader_file = $this->trader_file->newQuery();

                if (isset($request->q)) {
                    $trader_file->where('filename', 'LIKE', '%'. $request->q .'%');
                }

                return $trader_file->select('filename', 'file_location', 'updated_at', 'slug')
                                   ->where('trader_id', $trader_id)
                                   ->sortable()
                                   ->orderBy('updated_at', 'desc')
                                   ->paginate($entries);

        });

        return $trader_files;

    }




    public function store($trader_id, $filename, $file_location){

        $trader_file = new TraderFile;
        $trader_file->slug = $this->str->random(16);
        $trader_file->trader_file_id = $this->getTraderRegIdInc();
        $trader_file->trader_id = $trader_id;
        $trader_file->filename = $filename;
        $trader_file->file_location = $file_location;
        $trader_file->created_at = $this->carbon->now();
        $trader_file->updated_at = $this->carbon->now();
        $trader_file->ip_created = request()->ip();
        $trader_file->ip_updated = request()->ip();
        $trader_file->user_created = $this->auth->user()->user_id;
        $trader_file->user_updated = $this->auth->user()->user_id;
        $trader_file->save();
        
        return $trader_file;

    }




    public function update($filename, $file_location, $slug){

        $trader_file = $this->findBySlug($slug);
        $trader_file->filename = $filename;
        $trader_file->file_location = $file_location;
        $trader_file->updated_at = $this->carbon->now();
        $trader_file->ip_updated = request()->ip();
        $trader_file->user_updated = $this->auth->user()->user_id;
        $trader_file->save();
        
        return $trader_file;

    }




    public function destroy($trader_file){

        $trader_file->delete();
        return $trader_file;

    }




    public function findBySlug($slug){

        $trader_file = $this->cache->remember('trader_files:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->trader_file->where('slug', $slug)->with('trader')->first();
        }); 
        
        if(empty($trader_file)){abort(404);}

        return $trader_file;

    }




    public function getTraderRegIdInc(){

        $id = 'TF10001';
        $trader_file = $this->trader_file->select('trader_file_id')->orderBy('trader_file_id', 'desc')->first();

        if($trader_file != null){
            if($trader_file->trader_file_id != null){
                $num = str_replace('TF', '', $trader_file->trader_file_id) + 1;
                $id = 'TF' . $num;
            }
        }
        
        return $id;
        
    }





}
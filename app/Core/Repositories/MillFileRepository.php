<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\MillFileInterface;

use App\Models\MillFile;


class MillFileRepository extends BaseRepository implements MillFileInterface {
	

    protected $mill_file;


	public function __construct(MillFile $mill_file){

        $this->mill_file = $mill_file;
        parent::__construct();

    }




    public function fetchByMillId($request, $mill_id){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $mill_files = $this->cache->remember('mill_files:fetchByMillId:'. $mill_id .':'. $key, 240, 
            
            function() use ($request, $mill_id, $entries){

                $mill_file = $this->mill_file->newQuery();

                if (isset($request->q)) {
                    $mill_file->where('filename', 'LIKE', '%'. $request->q .'%');
                }

                return $mill_file->select('filename', 'file_location', 'updated_at', 'slug')
                                   ->where('mill_id', $mill_id)
                                   ->sortable()
                                   ->orderBy('updated_at', 'desc')
                                   ->paginate($entries);

        });

        return $mill_files;

    }




    public function store($mill_id, $filename, $file_location){

        $mill_file = new MillFile;
        $mill_file->slug = $this->str->random(16);
        $mill_file->mill_file_id = $this->getMillRegIdInc();
        $mill_file->mill_id = $mill_id;
        $mill_file->filename = $filename;
        $mill_file->file_location = $file_location;
        $mill_file->created_at = $this->carbon->now();
        $mill_file->updated_at = $this->carbon->now();
        $mill_file->ip_created = request()->ip();
        $mill_file->ip_updated = request()->ip();
        $mill_file->user_created = $this->auth->user()->user_id;
        $mill_file->user_updated = $this->auth->user()->user_id;
        $mill_file->save();
        
        return $mill_file;

    }




    public function update($filename, $file_location, $slug){

        $mill_file = $this->findBySlug($slug);
        $mill_file->filename = $filename;
        $mill_file->file_location = $file_location;
        $mill_file->updated_at = $this->carbon->now();
        $mill_file->ip_updated = request()->ip();
        $mill_file->user_updated = $this->auth->user()->user_id;
        $mill_file->save();
        
        return $mill_file;

    }




    public function destroy($mill_file){

        $mill_file->delete();
        return $mill_file;

    }




    public function findBySlug($slug){

        $mill_file = $this->cache->remember('mill_files:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->mill_file->where('slug', $slug)->with('mill')->first();
        }); 
        
        if(empty($mill_file)){abort(404);}

        return $mill_file;

    }




    public function getMillRegIdInc(){

        $id = 'MF10001';
        $mill_file = $this->mill_file->select('mill_file_id')->orderBy('mill_file_id', 'desc')->first();

        if($mill_file != null){
            if($mill_file->mill_file_id != null){
                $num = str_replace('MF', '', $mill_file->mill_file_id) + 1;
                $id = 'MF' . $num;
            }
        }
        
        return $id;
        
    }





}
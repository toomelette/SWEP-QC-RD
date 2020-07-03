<?php

namespace App\Core\Repositories;
 
use App\Core\BaseClasses\BaseRepository;
use App\Core\Interfaces\RefineryFileInterface;

use App\Models\RefineryFile;


class RefineryFileRepository extends BaseRepository implements RefineryFileInterface {
	

    protected $refinery_file;


	public function __construct(RefineryFile $refinery_file){

        $this->refinery_file = $refinery_file;
        parent::__construct();

    }




    public function fetchByRefineryId($request, $refinery_id){

        $key = str_slug($request->fullUrl(), '_');
        $entries = isset($request->e) ? $request->e : 20;

        $refinery_files = $this->cache->remember('refinery_files:fetchByRefineryId:'. $refinery_id .':'. $key, 240, 
            
            function() use ($request, $refinery_id, $entries){

                $refinery_file = $this->refinery_file->newQuery();

                if (isset($request->q)) {
                    $refinery_file->where('filename', 'LIKE', '%'. $request->q .'%');
                }

                return $refinery_file->select('filename', 'file_location', 'updated_at', 'slug')
                                   ->where('refinery_id', $refinery_id)
                                   ->sortable()
                                   ->orderBy('updated_at', 'desc')
                                   ->paginate($entries);

        });

        return $refinery_files;

    }




    public function store($refinery_id, $filename, $file_location){

        $refinery_file = new RefineryFile;
        $refinery_file->slug = $this->str->random(16);
        $refinery_file->refinery_file_id = $this->getRefineryRegIdInc();
        $refinery_file->refinery_id = $refinery_id;
        $refinery_file->filename = $filename;
        $refinery_file->file_location = $file_location;
        $refinery_file->created_at = $this->carbon->now();
        $refinery_file->updated_at = $this->carbon->now();
        $refinery_file->ip_created = request()->ip();
        $refinery_file->ip_updated = request()->ip();
        $refinery_file->user_created = $this->auth->user()->user_id;
        $refinery_file->user_updated = $this->auth->user()->user_id;
        $refinery_file->save();
        
        return $refinery_file;

    }




    public function update($filename, $file_location, $slug){

        $refinery_file = $this->findBySlug($slug);
        $refinery_file->filename = $filename;
        $refinery_file->file_location = $file_location;
        $refinery_file->updated_at = $this->carbon->now();
        $refinery_file->ip_updated = request()->ip();
        $refinery_file->user_updated = $this->auth->user()->user_id;
        $refinery_file->save();
        
        return $refinery_file;

    }




    public function destroy($refinery_file){

        $refinery_file->delete();
        return $refinery_file;

    }




    public function findBySlug($slug){

        $refinery_file = $this->cache->remember('refinery_files:findBySlug:' . $slug, 240, function() use ($slug){
            return $this->refinery_file->where('slug', $slug)->with('refinery')->first();
        }); 
        
        if(empty($refinery_file)){abort(404);}

        return $refinery_file;

    }




    public function getRefineryRegIdInc(){

        $id = 'RF10001';
        $refinery_file = $this->refinery_file->select('refinery_file_id')->orderBy('refinery_file_id', 'desc')->first();

        if($refinery_file != null){
            if($refinery_file->refinery_file_id != null){
                $num = str_replace('RF', '', $refinery_file->refinery_file_id) + 1;
                $id = 'RF' . $num;
            }
        }
        
        return $id;
        
    }





}
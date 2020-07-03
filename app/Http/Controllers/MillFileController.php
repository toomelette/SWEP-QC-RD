<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\MillInterface;
use App\Core\Interfaces\MillFileInterface;
use App\Http\Requests\MillFile\MillFileFormRequest;
use App\Http\Requests\MillFile\MillFileRenameRequest;

use File;

class MillFileController extends Controller{



    protected $mill_repo;
    protected $mill_file_repo;



    public function __construct(MillInterface $mill_repo, 
                                MillFileInterface $mill_file_repo){
        $this->mill_repo = $mill_repo;
        $this->mill_file_repo = $mill_file_repo;
        parent::__construct();
    }


   

    public function store(MillFileFormRequest $request){

        $mill = $this->mill_repo->findBySlug($request->s);

        foreach ($request->file('files') as $data) {

            $file_ext = File::extension($data->getClientOriginalName());
            $trimmed_file_name = trim($data->getClientOriginalName(), '.'. $file_ext);
            $file_name = $this->__dataType::fileFilterReservedChar($trimmed_file_name .'-'. $this->str->random(8), '.'. $file_ext);
            $file_location = 'MILL/'.$mill->name.'/'.$file_name;
            $dir = 'MILL/'.$mill->name;
            $data->storeAs($dir, $file_name);

            $this->mill_file_repo->store($mill->mill_id, $data->getClientOriginalName(), $file_location);
            
        }


        $this->event->fire('mill_file.store', $mill);
        return redirect()->back();

    }




    public function update(MillFileRenameRequest $request, $slug){

        $mill_file = $this->mill_file_repo->findBySlug($slug);

        $file_ext = File::extension($mill_file->filename);
        $new_trimmed_file_name = trim($request->filename, '.'. $file_ext);
        $new_file_name = $this->__dataType::fileFilterReservedChar($new_trimmed_file_name .'-'. $this->str->random(8), '.'. $file_ext);

        $dir = 'MILL/'.optional($mill_file->mill)->name;
        $new_file_location = $dir.'/'.$new_file_name;

        if(!is_null($mill_file->file_location)){
            if ($this->storage->disk('local')->exists($mill_file->file_location)) {
                $this->storage->disk('local')->move($mill_file->file_location, $new_file_location);
            }
        }

        $mill_file = $this->mill_file_repo->update($new_trimmed_file_name.'.'.$file_ext, $new_file_location, $slug);

        $this->event->fire('mill_file.update', $mill_file);
        return redirect()->back();

    }

    


    public function destroy($slug){

        $mill_file = $this->mill_file_repo->findBySlug($slug);

        if(!is_null($mill_file->file_location)){
            if ($this->storage->disk('local')->exists($mill_file->file_location)) {
                $this->storage->disk('local')->delete($mill_file->file_location);
            }
        }

        $mill_file = $this->mill_file_repo->destroy($mill_file);
        $this->event->fire('mill_file.destroy', $mill_file);
        return redirect()->back();

    }



    
}

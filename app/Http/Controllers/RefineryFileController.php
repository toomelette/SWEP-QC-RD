<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\RefineryInterface;
use App\Core\Interfaces\RefineryFileInterface;
use App\Http\Requests\RefineryFile\RefineryFileFormRequest;
use App\Http\Requests\RefineryFile\RefineryFileRenameRequest;

use File;

class RefineryFileController extends Controller{



    protected $refinery_repo;
    protected $refinery_file_repo;



    public function __construct(RefineryInterface $refinery_repo, 
                                RefineryFileInterface $refinery_file_repo){
        $this->refinery_repo = $refinery_repo;
        $this->refinery_file_repo = $refinery_file_repo;
        parent::__construct();
    }


   

    public function store(RefineryFileFormRequest $request){

        $refinery = $this->refinery_repo->findBySlug($request->s);

        foreach ($request->file('files') as $data) {

            $file_ext = File::extension($data->getClientOriginalName());
            $trimmed_file_name = trim($data->getClientOriginalName(), '.'. $file_ext);
            $file_name = $this->__dataType::fileFilterReservedChar($trimmed_file_name .'-'. $this->str->random(8), '.'. $file_ext);
            $file_location = 'REFINERY/'.$refinery->name.'/'.$file_name;
            $dir = 'REFINERY/'.$refinery->name;
            $data->storeAs($dir, $file_name);

            $this->refinery_file_repo->store($refinery->refinery_id, $data->getClientOriginalName(), $file_location);
            
        }


        $this->event->fire('refinery_file.store', $refinery);
        return redirect()->back();

    }




    public function update(RefineryFileRenameRequest $request, $slug){

        $refinery_file = $this->refinery_file_repo->findBySlug($slug);

        $file_ext = File::extension($refinery_file->filename);
        $new_trimmed_file_name = trim($request->filename, '.'. $file_ext);
        $new_file_name = $this->__dataType::fileFilterReservedChar($new_trimmed_file_name .'-'. $this->str->random(8), '.'. $file_ext);

        $dir = 'REFINERY/'.optional($refinery_file->refinery)->name;
        $new_file_location = $dir.'/'.$new_file_name;

        if(!is_null($refinery_file->file_location)){
            if ($this->storage->disk('local')->exists($refinery_file->file_location)) {
                $this->storage->disk('local')->move($refinery_file->file_location, $new_file_location);
            }
        }

        $refinery_file = $this->refinery_file_repo->update($new_trimmed_file_name.'.'.$file_ext, $new_file_location, $slug);

        $this->event->fire('refinery_file.update', $refinery_file);
        return redirect()->back();

    }

    


    public function destroy($slug){

        $refinery_file = $this->refinery_file_repo->findBySlug($slug);

        if(!is_null($refinery_file->file_location)){
            if ($this->storage->disk('local')->exists($refinery_file->file_location)) {
                $this->storage->disk('local')->delete($refinery_file->file_location);
            }
        }

        $refinery_file = $this->refinery_file_repo->destroy($refinery_file);
        $this->event->fire('refinery_file.destroy', $refinery_file);
        return redirect()->back();

    }



    
}

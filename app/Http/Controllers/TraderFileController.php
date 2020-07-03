<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\TraderInterface;
use App\Core\Interfaces\TraderFileInterface;
use App\Http\Requests\TraderFile\TraderFileFormRequest;
use App\Http\Requests\TraderFile\TraderFileRenameRequest;

use File;

class TraderFileController extends Controller{



    protected $trader_repo;
    protected $trader_file_repo;



    public function __construct(TraderInterface $trader_repo, 
                                TraderFileInterface $trader_file_repo){
        $this->trader_repo = $trader_repo;
        $this->trader_file_repo = $trader_file_repo;
        parent::__construct();
    }


   

    public function store(TraderFileFormRequest $request){

        $trader = $this->trader_repo->findBySlug($request->s);

        foreach ($request->file('files') as $data) {

            $file_ext = File::extension($data->getClientOriginalName());
            $trimmed_file_name = trim($data->getClientOriginalName(), '.'. $file_ext);
            $file_name = $this->__dataType::fileFilterReservedChar($trimmed_file_name .'-'. $this->str->random(8), '.'. $file_ext);
            $file_location = 'TRADER/'.$trader->name.'/'.$file_name;
            $dir = 'TRADER/'.$trader->name;
            $data->storeAs($dir, $file_name);

            $this->trader_file_repo->store($trader->trader_id, $data->getClientOriginalName(), $file_location);
            
        }


        $this->event->fire('trader_file.store', $trader);
        return redirect()->back();

    }




    public function update(TraderFileRenameRequest $request, $slug){

        $trader_file = $this->trader_file_repo->findBySlug($slug);

        $file_ext = File::extension($trader_file->filename);
        $new_trimmed_file_name = trim($request->filename, '.'. $file_ext);
        $new_file_name = $this->__dataType::fileFilterReservedChar($new_trimmed_file_name .'-'. $this->str->random(8), '.'. $file_ext);

        $dir = 'TRADER/'.optional($trader_file->trader)->name;
        $new_file_location = $dir.'/'.$new_file_name;

        if(!is_null($trader_file->file_location)){
            if ($this->storage->disk('local')->exists($trader_file->file_location)) {
                $this->storage->disk('local')->move($trader_file->file_location, $new_file_location);
            }
        }

        $trader_file = $this->trader_file_repo->update($new_trimmed_file_name.'.'.$file_ext, $new_file_location, $slug);

        $this->event->fire('trader_file.update', $trader_file);
        return redirect()->back();

    }

    


    public function destroy($slug){

        $trader_file = $this->trader_file_repo->findBySlug($slug);

        if(!is_null($trader_file->file_location)){
            if ($this->storage->disk('local')->exists($trader_file->file_location)) {
                $this->storage->disk('local')->delete($trader_file->file_location);
            }
        }

        $trader_file = $this->trader_file_repo->destroy($trader_file);
        $this->event->fire('trader_file.destroy', $trader_file);
        return redirect()->back();

    }



    
}

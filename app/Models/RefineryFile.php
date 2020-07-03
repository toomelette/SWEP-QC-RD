<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use File;

class RefineryFile extends Model{


    use Sortable;
    protected $table = 'refinery_files';
    protected $dates = ['created_at', 'updated_at'];    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'refinery_file_id' => '',
        'refinery_id' => '',
        'filename' => '',
        'file_location' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];

    
    public function refinery() {
        return $this->belongsTo('App\Models\Refinery','refinery_id','refinery_id');
    }


    public function getTrimmedFilenameAttribute(){

        $file_ext = File::extension($this->filename);
        return trim($this->filename, '.'. $file_ext);

    }




}

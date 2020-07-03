<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use File;

class MillFile extends Model{


    use Sortable;
    protected $table = 'mill_files';
    protected $dates = ['created_at', 'updated_at'];    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'mill_file_id' => '',
        'mill_id' => '',
        'filename' => '',
        'file_location' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];

    
    public function mill() {
        return $this->belongsTo('App\Models\Mill','mill_id','mill_id');
    }


    public function getTrimmedFilenameAttribute(){

        $file_ext = File::extension($this->filename);
        return trim($this->filename, '.'. $file_ext);

    }




}

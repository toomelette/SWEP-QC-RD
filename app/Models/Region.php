<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Region extends Model{


    use Sortable;
    protected $table = 'regions';
    protected $dates = ['created_at', 'updated_at'];    
	public $timestamps = false;

    

}

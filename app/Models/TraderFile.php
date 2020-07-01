<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class TraderFile extends Model{


    use Sortable;
    protected $table = 'trader_files';
    protected $dates = ['created_at', 'updated_at'];    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'trader_file_id' => '',
        'trader_id' => '',
        'file_location' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];

    
    public function trader() {
        return $this->belongsTo('App\Models\Trader','trader_id','trader_id');
    }

    





}

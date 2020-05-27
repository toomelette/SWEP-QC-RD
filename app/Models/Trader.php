<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Trader extends Model{


    use Sortable;
    protected $table = 'traders';
    protected $dates = ['created_at', 'updated_at'];    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'trader_id' => '',
        'region_id' => '',
        'name' => '',
        'address' => '',
        'tin' => '',
        'tel_no' => '',
        'officer' => '',
        'email' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];




    /** RELATIONSHIPS **/
    // public function user() {
    // 	return $this->belongsTo('App\Models\User','user_id','user_id');
   	// }

    





}

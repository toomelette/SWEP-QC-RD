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
        'address_second' => '',
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
    public function region() {
    	return $this->belongsTo('App\Models\Region','region_id','region_id');
   	}

    public function traderRegistration() {
        return $this->hasMany('App\Models\TraderRegistration','trader_id','trader_id');
    }

    





}

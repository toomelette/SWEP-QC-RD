<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class TraderRegistration extends Model{


    use Sortable;
    protected $table = 'trader_registration';
    protected $dates = ['created_at', 'updated_at', 'reg_date'];    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'trader_reg_id' => '',
        'trader_id' => '',
        'trader_cat_id' => '',
        'control_no' => '',
        'reg_date' => null,
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

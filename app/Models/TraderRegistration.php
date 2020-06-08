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
        'crop_year_id' => '',
        'trader_cat_id' => '',
        'trader_id' => '',
        'trader_officer' => '',
        'trader_email' => '',
        'control_no' => '',
        'reg_date' => null,
        'signatory' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];




    /** RELATIONSHIPS **/
    public function trader() {
    	return $this->belongsTo('App\Models\Trader','trader_id','trader_id');
   	}

    public function traderCategory() {
        return $this->belongsTo('App\Models\TraderCategory','trader_cat_id','trader_cat_id');
    }

    public function cropYear() {
        return $this->belongsTo('App\Models\CropYear','crop_year_id','crop_year_id');
    }

    





}

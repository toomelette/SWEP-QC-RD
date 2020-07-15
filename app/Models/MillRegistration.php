<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class MillRegistration extends Model{


    use Sortable;
    protected $table = 'mill_registration';
    protected $dates = ['created_at', 'updated_at', 'reg_date', 'start_milling', 'end_milling'];    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'mill_reg_id' => '',
        'mill_id' => '',
        'crop_year_id' => '',
        'license_no' => '',
        'reg_date' => null,
        'mt' => 0.00,
        'lkg' => 0.00,
        'milling_fee' => 0.00,
        'payment_status' => '',
        'under_payment' => 0.00,
        'excess_payment' => 0.00,
        'balance_fee' => 0.00,
        'rated_capacity' => 0.00,
        'start_milling' => null,
        'end_milling' => null,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];




    /** RELATIONSHIPS **/
    public function mill() {
    	return $this->belongsTo('App\Models\Mill','mill_id','mill_id');
   	}

    public function cropYear() {
        return $this->belongsTo('App\Models\CropYear','crop_year_id','crop_year_id');
    }




}

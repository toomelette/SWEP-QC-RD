<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Mill extends Model{


    use Sortable;
    protected $table = 'mills';
    protected $dates = ['created_at', 'updated_at'];    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'mill_id' => '',
        'region_id' => '',
        'name' => '',
        'address' => '',
        'address_second' => '',
        'address_third' => '',
        'tel_no' => '',
        'tel_no_second' => '',
        'fax_no' => '',
        'fax_no_second' => '',
        'email' => '',
        'officer' => '',
        'position' => '',
        'salutation' => '',
        'cover_letter_address' => 1,
        'license_address' => 1,
        'billing_address' => 1,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];


    public function millRegistration() {
        return $this->hasMany('App\Models\MillRegistration','mill_id','mill_id');
    }


    public function region() {
        return $this->belongsTo('App\Models\Region','region_id','region_id');
    }




    public function displayLicensesStatusSpan($cy_id){

        $mill_reg = $this->millRegistration->where('crop_year_id', $cy_id)->first();

        if (!empty($mill_reg)) {
            if ($mill_reg->is_registered == true) {
                return '<span class="badge bg-green">Registered - '. $mill_reg->license_no .'</span>';
            }
        }

        return '<span class="badge bg-red">Not Registered</span>';

    }




    public function licensesStatus($cy_id){

        $mill_reg = $this->MillRegistration->where('crop_year_id', $cy_id)->first();

        if (!empty($mill_reg)) {
            if ($mill_reg->is_registered == true) {
                return $mill_reg->is_registered;
            }
        }

        return false;

    }




    public function billingStatus($cy_id){

        $mill_reg = $this->MillRegistration->where('crop_year_id', $cy_id)->first();

        if (!empty($mill_reg)) {
            if ($mill_reg->is_billed == true) {
                return true;
            }
        }

        return false;

    }




    public function millShareStatus($cy_id){

        $mill_reg = $this->MillRegistration->where('crop_year_id', $cy_id)->first();

        if (!empty($mill_reg)) {
            if ($mill_reg->is_mill_share == true) {
                return true;
            }
        }

        return false;

    }




}

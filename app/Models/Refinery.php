<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Refinery extends Model{


    use Sortable;
    protected $table = 'refineries';
    protected $dates = ['created_at', 'updated_at'];    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'refinery_id' => '',
        'region_id' => '',
        'name' => '',
        'address' => '',
        'address_second' => '',
        'address_third' => '',
        'tel_no' => '',
        'tel_no_second' => '',
        'fax_no' => '',
        'fax_no_second' => '',
        'officer' => '',
        'position' => '',
        'email' => '',
        'salutation' => '',
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];

    public function refineryRegistration() {
        return $this->hasMany('App\Models\RefineryRegistration','refinery_id','refinery_id');
    }




    public function displayLicensesStatusSpan($cy_id){

        $refinery_reg = $this->refineryRegistration->where('crop_year_id', $cy_id)->first();

        if (!empty($refinery_reg)) {
            return '<span class="badge bg-green">Registered - '.$refinery_reg->license_no.'</span>';
        }

        return '<span class="badge bg-red">Not Registered</span>';

    }




    public function licensesStatus($cy_id){

        $refinery_reg = $this->refineryRegistration->where('crop_year_id', $cy_id);

        if (!$refinery_reg->isEmpty()) {
            return true;
        }

        return false;

    }





}

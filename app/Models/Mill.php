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
        'name' => '',
        'address' => '',
        'address_second' => '',
        'address_third' => '',
        'tel_no' => '',
        'tel_no_second' => '',
        'fax_no' => '',
        'fax_no_second' => '',
        'officer' => '',
        'salutation' => '',
        'salutation_pos' => '',
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




    public function displayLicensesStatus($cy_id){

        $mill_reg = $this->MillRegistration->where('crop_year_id', $cy_id);

        if (!$mill_reg->isEmpty()) {
            return '<span class="badge bg-green">Registered</span>';
        }

        return '<span class="badge bg-red">Not Registered</span>';

    }





}

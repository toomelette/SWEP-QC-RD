<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class RefineryRegistration extends Model{


    use Sortable;
    protected $table = 'refinery_registration';
    protected $dates = ['created_at', 'updated_at', 'reg_date'];    
	public $timestamps = false;



    protected $attributes = [

        'slug' => '',
        'refinery_reg_id' => '',
        'refinery_id' => '',
        'crop_year_id' => '',
        'license_no' => '',
        'reg_date' => null,
        'created_at' => null,
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];




    /** RELATIONSHIPS **/
    public function refinery() {
    	return $this->belongsTo('App\Models\Refinery','refinery_id','refinery_id');
   	}

    public function cropYear() {
        return $this->belongsTo('App\Models\CropYear','crop_year_id','crop_year_id');
    }




}

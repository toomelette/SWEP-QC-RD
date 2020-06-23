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
        'address_third' => '',
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




    public function currentCropYearLicenses($cy_id){

        $cat = [
            'TC1001' => 'Sugar Trader (Domestic)',
            'TC1002' => 'Sugar Trader (International)',
            'TC1003' => 'Molasses (Domestic)',
            'TC1004' => 'Molasses (International)',
            'TC1005' => 'Muscovado',
            'TC1006' => 'HFSC',
        ];

        $list_of_tr_current_cy = $this->traderRegistration->where('crop_year_id', $cy_id);

        if (!$list_of_tr_current_cy->isEmpty()) {
            $list = '';
            foreach ($list_of_tr_current_cy as $data) {
                $list .= '<span class="badge bg-green">'. $cat[$data->trader_cat_id] .' - '. $data->control_no .'</span><br>';
            }
            return $list;
        }

        return '<span class="badge bg-red">Not Registered</span>';

    }




    /** RELATIONSHIPS **/
    public function region() {
    	return $this->belongsTo('App\Models\Region','region_id','region_id');
   	}

    public function traderRegistration() {
        return $this->hasMany('App\Models\TraderRegistration','trader_id','trader_id');
    }




}

<?php

namespace App\Core\Helpers;



class __static{


    // Profile
    public static function user_colors(){

        return [

	      'Blue/Dark' => 'sidebar-mini skin-blue',
	      'White/Dark' => 'sidebar-mini skin-black',
	      'Purple/Dark' => 'sidebar-mini skin-purple',
	      'Green/Dark' => 'sidebar-mini skin-green',
	      'Red/Dark' => 'sidebar-mini skin-red',
	      'Yellow/Dark' => 'sidebar-mini skin-yellow',
	      'Blue/Light' => 'sidebar-mini skin-blue-light',
	      'White/Light' => 'sidebar-mini skin-black-light',
	      'Purple/Light' => 'sidebar-mini skin-purple-light',
	      'Green/Light' => 'sidebar-mini skin-green-light',
	      'Red/Light' => 'sidebar-mini skin-red-light',
	      'Yellow/Light' => 'sidebar-mini skin-yellow-light',

	    ];

    
    }




    // File Directory
    public static function archive_dir(){

        return '/swep_qc_rd_storage';
    
    }




    // Report Regions
    public static function report_regions(){

        return [

	      'LUZON' => 'LUZ',
	      'NEGROS' => 'NEG',
	      'PANAY' => 'PAN',
	      'EASTERN VISAYAS' => 'EV',
	      'MINDANAO' => 'MIN',

	    ];
    
    }


}
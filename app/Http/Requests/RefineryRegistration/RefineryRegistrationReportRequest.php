<?php

namespace App\Http\Requests\RefineryRegistration;

use Illuminate\Foundation\Http\FormRequest;

class RefineryRegistrationReportRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [

            'ft'=>'required|string|max:5',

            // Refinery Directory
            'rd_cy'=>'sometimes|required|string|max:11',
            
            // Rated Capacity
            'rc_cy'=>'sometimes|required|string|max:11',

            // Count By Crop Year
            'cbcy_cy'=>'sometimes|required|string|max:11',

            // List of Registered Refinery by Date
            'bd_df'=>'sometimes|required|date_format:"m/d/Y"',
            'bd_dt'=>'sometimes|required|date_format:"m/d/Y"',

            // List of Registered Refinery by Crop Year
            'bcy_cy'=>'sometimes|required|string|max:11',

        ];

    }



}

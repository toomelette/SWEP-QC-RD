<?php

namespace App\Http\Requests\MillRegistration;

use Illuminate\Foundation\Http\FormRequest;

class MillRegistrationReportRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [

            'ft'=>'required|string|max:5',

            // Mill Directory
            'md_cy'=>'sometimes|required|string|max:11',

            // Rated Capacity
            'rc_cy'=>'sometimes|required|string|max:11',

            // Mill Participition
            'mp_cy'=>'sometimes|required|string|max:11',

            // Count By Crop Year
            'cbcy_cy'=>'sometimes|required|string|max:11',

            // Mill Library
            'ml_t'=>'sometimes|required|string|max:2',
            'ml_field'=>'sometimes|nullable|array|max:12',
            'ml_cy'=>'sometimes|required|string|max:11',

            // List of Registered Mills by Date
            'bd_df'=>'sometimes|required|date_format:"m/d/Y"',
            'bd_dt'=>'sometimes|required|date_format:"m/d/Y"',

            // List of Registered Mills by Crop Year
            'bcy_cy'=>'sometimes|required|string|max:11',

        ];

    }



}

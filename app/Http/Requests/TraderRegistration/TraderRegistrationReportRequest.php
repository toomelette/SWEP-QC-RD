<?php

namespace App\Http\Requests\TraderRegistration;

use Illuminate\Foundation\Http\FormRequest;

class TraderRegistrationReportRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [

            'ft'=>'required|string|max:5',
            
            'bdc_t'=>'sometimes|required|string|max:5',
            'bdc_df'=>'sometimes|required|date_format:"m/d/Y"',
            'bdc_dt'=>'sometimes|required|date_format:"m/d/Y"',
            'bdc_tc'=>'sometimes|nullable|string|max:11',

            'bcyc_cy'=>'sometimes|required|string|max:11',
            'bcyc_tc'=>'sometimes|nullable|string|max:11',
            'bcyc_rt'=>'sometimes|required|string|max:11',

        ];

    }



}

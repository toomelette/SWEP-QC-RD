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

            'fd_cy'=>'sometimes|required|string|max:11',

            'rc_cy'=>'sometimes|required|string|max:11',

            'mp_cy'=>'sometimes|required|string|max:11',

            'bd_df'=>'sometimes|required|date_format:"m/d/Y"',
            'bd_dt'=>'sometimes|required|date_format:"m/d/Y"',

            'bcy_cy'=>'sometimes|required|string|max:11',

        ];

    }



}

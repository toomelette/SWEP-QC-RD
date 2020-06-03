<?php

namespace App\Http\Requests\TraderRegistration;

use Illuminate\Foundation\Http\FormRequest;

class TraderRegistrationReportRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
            
            'df'=>'required|date_format:"m/d/Y"',
            'dt'=>'required|date_format:"m/d/Y"',
            'tc'=>'nullable|string|max:11',
            'ft'=>'nullable|string|max:5',
            't'=>'nullable|string|max:5',

        ];

    }



}

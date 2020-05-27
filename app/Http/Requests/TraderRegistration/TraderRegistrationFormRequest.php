<?php

namespace App\Http\Requests\TraderRegistration;

use Illuminate\Foundation\Http\FormRequest;

class TraderRegistrationFormRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
            
            'control_no'=>'required|string|max:45',
            'trader_id'=>'required|string|max:11',
            'trader_cat_id'=>'required|string|max:11',
            'reg_date' => 'required|date_format:"m/d/Y"',

        ];

    }




}

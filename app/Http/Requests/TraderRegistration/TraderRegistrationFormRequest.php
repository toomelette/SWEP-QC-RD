<?php

namespace App\Http\Requests\TraderRegistration;

use Illuminate\Foundation\Http\FormRequest;

class TraderRegistrationFormRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
            
            'control_no'=>'nullable|string|max:45|unique:trader_registration,control_no,'.$this->route('trader_registration').',slug',
            'trader_cat_id'=>'nullable|string|max:11',
            'crop_year_id'=>'nullable|string|max:11',
            'trader_id'=>'nullable|string|max:11',
            'trader_officer'=>'nullable|string|max:90',
            'trader_email'=>'nullable|string|max:90',
            'reg_date' => 'nullable|date_format:"m/d/Y"',

        ];

    }




}

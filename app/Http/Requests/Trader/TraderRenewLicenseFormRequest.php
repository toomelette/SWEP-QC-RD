<?php

namespace App\Http\Requests\Trader;

use Illuminate\Foundation\Http\FormRequest;

class TraderRenewLicenseFormRequest extends FormRequest{


    public function authorize(){
        return true;    
    }

    
    public function rules(){

        return [
            
            'crop_year_id'=>'required|string|max:11',
            'trader_cat_id'=>'required|string|max:11',
            'control_no'=>'required|string|max:45',
            'reg_date' => 'nullable|date_format:"m/d/Y"',

        ];

    }



}

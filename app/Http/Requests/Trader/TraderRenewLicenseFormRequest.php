<?php

namespace App\Http\Requests\Trader;

use Illuminate\Foundation\Http\FormRequest;

class TraderRenewLicenseFormRequest extends FormRequest{


    public function authorize(){
        return true;    
    }

    
    public function rules(){

        return [
            

            'control_no'=>'nullable|string|max:45',
            'crop_year_id'=>'required|string|max:11',
            'trader_cat_id'=>'nullable|string|max:11',
            'reg_date' => 'nullable|date_format:"m/d/Y"',

        ];

    }



}

<?php

namespace App\Http\Requests\Mill;

use Illuminate\Foundation\Http\FormRequest;

class MillRenewLicenseFormRequest extends FormRequest{


    public function authorize(){
        return true;    
    }

    
    public function rules(){

        return [
            
            'crop_year_id'=>'required|string|max:11',
            'reg_date' => 'required|date_format:"m/d/Y"',
            'mt'=>'nullable|string|max:21',
            'lkg'=>'nullable|string|max:21',
            'milling_fee'=>'nullable|string|max:21',
            'payment_status'=>'nullable|string|max:5',
            'under_payment'=>'nullable|string|max:21',
            'excess_payment'=>'nullable|string|max:21',
            'balance_fee'=>'nullable|string|max:21',
            'rated_capacity'=>'nullable|string|max:21',
            'start_milling' => 'nullable|date_format:"m/d/Y"',
            'end_milling' => 'nullable|date_format:"m/d/Y"',
            'mill_share'=>'nullable|string|max:6',
            'planter_share'=>'nullable|string|max:6',
            'other_share'=>'nullable|string|max:90',

        ];

    }


}

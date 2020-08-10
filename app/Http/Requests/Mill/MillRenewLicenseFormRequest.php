<?php

namespace App\Http\Requests\Mill;

use Illuminate\Foundation\Http\FormRequest;

class MillRenewLicenseFormRequest extends FormRequest{


    public function authorize(){
        return true;    
    }

    
    public function rules(){

        return [

            'license_no'=>'sometimes|nullable|string|max:45',
            'crop_year_id'=>'required|string|max:11',
            'reg_date' => 'sometimes|required|date_format:"m/d/Y"',
            'mt'=>'sometimes|nullable|string|max:21',
            'lkg'=>'sometimes|nullable|string|max:21',
            'milling_fee'=>'sometimes|nullable|string|max:21',
            'payment_status'=>'sometimes|nullable|string|max:5',
            'under_payment'=>'sometimes|nullable|string|max:21',
            'excess_payment'=>'sometimes|nullable|string|max:21',
            'balance_fee'=>'sometimes|nullable|string|max:21',
            'rated_capacity'=>'sometimes|nullable|string|max:21',
            'start_milling' => 'sometimes|nullable|date_format:"m/d/Y"',
            'end_milling' => 'sometimes|nullable|date_format:"m/d/Y"',
            'mill_share'=>'sometimes|nullable|string|max:6',
            'planter_share'=>'sometimes|nullable|string|max:6',
            'other_share'=>'sometimes|nullable|string|max:90',

        ];

    }


}

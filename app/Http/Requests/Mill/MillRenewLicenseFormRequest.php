<?php

namespace App\Http\Requests\Mill;

use Illuminate\Foundation\Http\FormRequest;

class MillRenewLicenseFormRequest extends FormRequest{


    public function authorize(){
        return true;    
    }

    
    public function rules(){
        return [
            'license_no'=>'required|string|max:45',
            'reg_date' => 'required|date_format:"m/d/Y"',
            'mt'=>'required|string|max:21',
            'lkg'=>'required|string|max:21',
            'milling_fee'=>'required|string|max:21',
            'payment_status'=>'required|string|max:5',
            'under_payment'=>'nullable|string|max:21',
            'excess_payment'=>'nullable|string|max:21',
            'balance_fee'=>'nullable|string|max:21',
            'rated_capacity'=>'nullable|string|max:21',
            'start_milling' => 'nullable|date_format:"m/d/Y"',
            'end_milling' => 'nullable|date_format:"m/d/Y"',
        ];
    }


}

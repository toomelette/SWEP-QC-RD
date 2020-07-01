<?php

namespace App\Http\Requests\Refinery;

use Illuminate\Foundation\Http\FormRequest;

class RefineryRenewLicenseFormRequest extends FormRequest{


    
    public function authorize(){
        return true;
    }
    


    public function rules(){

        return [
            
            'license_no'=>'required|string|max:45',
            'reg_date' => 'nullable|date_format:"m/d/Y"',
        
        ];

    }




}

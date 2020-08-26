<?php

namespace App\Http\Requests\Refinery;

use Illuminate\Foundation\Http\FormRequest;

class RefineryRenewLicenseFormRequest extends FormRequest{


    
    public function authorize(){
        return true;
    }
    


    public function rules(){

        return [
            
            'license_no'=>'nullable|string|max:45',
            'crop_year_id'=>'nullable|string|max:11',
            'reg_date' => 'nullable|date_format:"m/d/Y"',
            'rated_capacity'=>'nullable|string|max:21',
        
        ];

    }




}

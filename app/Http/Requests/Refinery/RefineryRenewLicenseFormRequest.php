<?php

namespace App\Http\Requests\Refinery;

use Illuminate\Foundation\Http\FormRequest;

class RefineryRenewLicenseFormRequest extends FormRequest{


    
    public function authorize(){
        return true;
    }
    


    public function rules(){

        return [
            
            'crop_year_id'=>'required|string|max:11',
            'reg_date' => 'nullable|date_format:"m/d/Y"',
        
        ];

    }




}

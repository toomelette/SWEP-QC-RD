<?php

namespace App\Http\Requests\Refinery;

use Illuminate\Foundation\Http\FormRequest;

class RefineryRenewLicenseFormRequest extends FormRequest{


    
    public function authorize(){
        return true;
    }
    


    public function rules(){

        return [
        
        ];

    }




}

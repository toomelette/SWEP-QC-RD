<?php

namespace App\Http\Requests\Mill;

use Illuminate\Foundation\Http\FormRequest;

class MillRenewalHistoryFilterRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
        	

        ];

    }




}

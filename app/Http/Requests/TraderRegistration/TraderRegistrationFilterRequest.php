<?php

namespace App\Http\Requests\TraderRegistration;

use Illuminate\Foundation\Http\FormRequest;

class TraderRegistrationFilterRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
            
            'q'=>'nullable|string|max:90',
            't'=>'nullable|string|max:11',
            'tc'=>'nullable|string|max:11',
            'cy'=>'nullable|string|max:11',

        ];

    }




}

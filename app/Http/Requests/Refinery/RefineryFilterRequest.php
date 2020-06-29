<?php

namespace App\Http\Requests\Refinery;

use Illuminate\Foundation\Http\FormRequest;

class RefineryFilterRequest extends FormRequest{


    
    public function authorize(){
        return true;
    }
    


    public function rules(){

        return [
        
            'q'=>'nullable|string|max:90',
        
        ];

    }




}

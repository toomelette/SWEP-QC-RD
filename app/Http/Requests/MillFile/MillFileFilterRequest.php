<?php

namespace App\Http\Requests\MillFile;

use Illuminate\Foundation\Http\FormRequest;

class MillFileFilterRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
        	

        ];

    }




}

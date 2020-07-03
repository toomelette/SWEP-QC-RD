<?php

namespace App\Http\Requests\RefineryFile;

use Illuminate\Foundation\Http\FormRequest;

class RefineryFileFilterRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
        	

        ];

    }




}

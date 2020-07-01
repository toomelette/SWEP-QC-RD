<?php

namespace App\Http\Requests\TraderFile;

use Illuminate\Foundation\Http\FormRequest;

class TraderFileFilterRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
        	

        ];

    }




}

<?php

namespace App\Http\Requests\Mill;

use Illuminate\Foundation\Http\FormRequest;

class MillFormRequest extends FormRequest{


    

    public function authorize(){

        return true;
    
    }

    


    public function rules(){

        return [
        


        ];

    }







}

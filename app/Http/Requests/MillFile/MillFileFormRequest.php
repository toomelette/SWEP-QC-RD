<?php

namespace App\Http\Requests\MillFile;


use Illuminate\Foundation\Http\FormRequest;


class MillFileFormRequest extends FormRequest{



    public function authorize(){

        return true;
        
    }


    

    public function rules(){

        return [
            
            'files'=>'required|array',

        ];

    }





}

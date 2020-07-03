<?php

namespace App\Http\Requests\MillFile;


use Illuminate\Foundation\Http\FormRequest;


class MillFileRenameRequest extends FormRequest{



    public function authorize(){

        return true;
        
    }


    

    public function rules(){

        return [
            
            'filename'=>'required|string|max:255',

        ];

    }





}

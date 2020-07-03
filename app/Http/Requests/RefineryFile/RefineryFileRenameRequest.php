<?php

namespace App\Http\Requests\RefineryFile;


use Illuminate\Foundation\Http\FormRequest;


class RefineryFileRenameRequest extends FormRequest{



    public function authorize(){

        return true;
        
    }


    

    public function rules(){

        return [
            
            'filename'=>'required|string|max:255',

        ];

    }





}

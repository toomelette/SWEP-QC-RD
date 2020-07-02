<?php

namespace App\Http\Requests\TraderFile;


use Illuminate\Foundation\Http\FormRequest;


class TraderFileRenameRequest extends FormRequest{



    public function authorize(){

        return true;
        
    }


    

    public function rules(){

        return [
            
            'filename'=>'required|string|max:255',

        ];

    }





}

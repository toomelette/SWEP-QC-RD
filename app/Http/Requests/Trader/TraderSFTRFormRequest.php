<?php

namespace App\Http\Requests\Trader;

use Illuminate\Foundation\Http\FormRequest;

class TraderSFTRFormRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
            
            'tr_name'=>'nullable|string|max:255',
            'tr_region_id'=>'required|string|max:11',
            'tr_address'=>'nullable|string|max:255',
            'tr_address_second'=>'nullable|string|max:255',
            'tr_tin'=>'nullable|string|max:45',
            'tr_tel_no'=>'nullable|string|max:45',
            'tr_officer'=>'nullable|string|max:90',
            'tr_email'=>'nullable|string|max:90',

        ];

    }




}

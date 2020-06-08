<?php

namespace App\Http\Requests\Trader;

use Illuminate\Foundation\Http\FormRequest;

class TraderFormRequest extends FormRequest{



    public function authorize(){
        return true;    
    }

    

    public function rules(){

        return [
            
            'name'=>'required|string|max:255',
            'region_id'=>'required|string|max:11',
            'address'=>'required|string|max:255',
            'address_second'=>'nullable|string|max:255',
            'tin'=>'required|string|max:45',
            'tel_no'=>'nullable|string|max:45',
            'officer'=>'nullable|string|max:90',
            'email'=>'nullable|string|max:90',

        ];

    }




}

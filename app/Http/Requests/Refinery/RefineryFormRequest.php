<?php

namespace App\Http\Requests\Refinery;

use Illuminate\Foundation\Http\FormRequest;

class RefineryFormRequest extends FormRequest{


    
    public function authorize(){
        return true;
    }
    


    public function rules(){

        return [
        
            'name'=>'required|string|max:255',
            'address'=>'required|string|max:255',
            'address_second'=>'nullable|string|max:255',
            'address_third'=>'nullable|string|max:255',
            'tel_no'=>'nullable|string|max:45',
            'tel_no_second'=>'nullable|string|max:45',
            'fax_no'=>'nullable|string|max:45',
            'fax_no_second'=>'nullable|string|max:45',
            'officer'=>'nullable|string|max:90',
            'salutation'=>'nullable|string|max:90',
            'position'=>'nullable|string|max:90',
        
        ];

    }




}

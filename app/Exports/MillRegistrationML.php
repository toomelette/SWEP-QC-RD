<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MillRegistrationML implements FromView{
    

    private $mill_registrations;
    private $crop_year;
    private $request;


    public function __construct($mill_registrations, $crop_year, $request){

    	$this->mill_registrations = $mill_registrations;
        $this->crop_year = $crop_year;
        $this->request = $request;

    }


    public function view(): View{

        return view('exports.mill.mill_library', [
            'mill_registrations' =>  $this->mill_registrations,
            'crop_year' => $this->crop_year,
            'fields' => $this->request->ml_field
        ]);


    }



}
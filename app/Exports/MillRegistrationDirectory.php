<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MillRegistrationDirectory implements FromView{
    

    private $mill_registrations;
    private $crop_year;


    public function __construct($mill_registrations, $crop_year){

    	$this->mill_registrations = $mill_registrations;
        $this->crop_year = $crop_year;

    }


    public function view(): View{

        return view('exports.mill.mill_directory', [
            'mill_registrations' =>  $this->mill_registrations,
            'crop_year' => $this->crop_year,
        ]);


    }



}
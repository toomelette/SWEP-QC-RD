<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RefineryRegistrationDirectory implements FromView{
    

    private $refinery_registrations;
    private $crop_year;


    public function __construct($refinery_registrations, $crop_year){

    	$this->refinery_registrations = $refinery_registrations;
        $this->crop_year = $crop_year;

    }


    public function view(): View{

        return view('exports.refinery.refinery_directory', [
            'refinery_registrations' =>  $this->refinery_registrations,
            'crop_year' => $this->crop_year,
        ]);


    }



}
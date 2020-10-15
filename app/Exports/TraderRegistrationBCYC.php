<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TraderRegistrationBCYC implements FromView{
    

    private $trader_registrations;
    private $crop_year;
    private $request;


    public function __construct($trader_registrations, $crop_year, $request){

    	$this->trader_registrations = $trader_registrations;
        $this->crop_year = $crop_year;
        $this->request = $request;

    }


    public function view(): View{

        if ($this->request->bcyc_rt == 'A') {

            return view('exports.trader.bcyc_alpha', [
                'trader_registrations' =>  $this->trader_registrations,
                'crop_year' => $this->crop_year
            ]);
            
        }elseif ($this->request->bcyc_rt == 'BR') {

            return view('exports.trader.bcyc_by_region', [
                'trader_registrations' =>  $this->trader_registrations,
                'crop_year' => $this->crop_year,
                'request' => $this->request,
            ]);
            
        }


    }



}
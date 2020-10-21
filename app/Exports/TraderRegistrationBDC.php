<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TraderRegistrationBDC implements FromView{
    

    private $trader_registrations;
    private $request;


    public function __construct($trader_registrations, $request){

    	$this->trader_registrations = $trader_registrations;
        $this->request = $request;

    }


    public function view(): View{

        if ($this->request->bdc_rt == 'A') {

            return view('exports.trader.bdc_alpha', [ 
                'trader_registrations' =>  $this->trader_registrations,
                'request' => $this->request,
            ]);
            
        }elseif ($this->request->bdc_rt == 'BR') {

            return view('exports.trader.bdc_by_region', [
                'trader_registrations' =>  $this->trader_registrations,
                'request' => $this->request,
            ]);
            
        }

    }



}
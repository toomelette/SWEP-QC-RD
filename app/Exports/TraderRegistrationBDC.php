<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TraderRegistrationBDC implements ShouldAutoSize, FromArray, WithHeadings{
    

    private $trader_registrations;


    public function __construct($trader_registrations){

    	$this->trader_registrations = $trader_registrations;

    }


    public function array(): array{

        $list = [];

        foreach ($this->trader_registrations as $data) {

            $list[] = [

                'Crop Year' => optional($data->cropYear)->name,
                'Category' => optional($data->traderCategory)->name,
                'Control No' => $data->control_no,
                'Registration Date' => optional($data->reg_date)->format('m/d/Y'),
                'Trader Name' => optional($data->trader)->name,
                'Trader Address' => optional($data->trader)->address,
                'Trader Second Address' => optional($data->trader)->address_second,
                'Trader Third Address' => optional($data->trader)->address_third,
                'Region' => optional(optional($data->trader)->region)->name,
                'TIN' => optional($data->trader)->tin,
                'Tel No' => optional($data->trader)->tel_no,
                'Officer' => $data->trader_officer,
                'Email' => $data->trader_email,

            ];

        }

    	return $list;

    }



    public function headings(): array{

        return [
            'Crop Year', 
            'Category', 
            'Control No', 
            'Registration Date', 
            'Trader Name', 
            'Trader Address', 
            'Trader Second Address',
            'Trader Third Address',
            'Region', 
            'TIN', 
            'Tel No', 
            'Officer', 
            'Email'
        ];
        
    }



}
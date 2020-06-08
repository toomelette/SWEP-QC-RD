<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TraderRegistrationBDC implements FromArray, WithHeadings{
    

    private $trader_registrations;


    public function __construct($trader_registrations){

    	$this->trader_registrations = $trader_registrations;

    }


    public function array(): array{

        $list = [];

        foreach ($this->trader_registrations->sortBy('trader.name') as $data) {
                
            $list[] = [

                'Crop Year' => $data->cropYear->name,
                'Category' => $data->traderCategory->name,
                'Control No' => $data->control_no,
                'Registration Date' => $data->reg_date->format('m/d/Y'),
                'Trader Name' => $data->trader->name,
                'Trader Address' => $data->trader->address,
                'Trader Second Address' => $data->trader->address_second,
                'Region' => $data->trader->region->name,
                'TIN' => $data->trader->tin,
                'Tel No' => $data->trader->tel_no,
                'Officer' => $data->trader->officer,
                'Email' => $data->trader->email,

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
            'Region', 
            'TIN', 
            'Tel No', 
            'Officer', 
            'Email'
        ];
        
    }



}
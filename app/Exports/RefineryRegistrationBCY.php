<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RefineryRegistrationBCY implements FromArray, WithHeadings{
    

    private $refinery_registrations;


    public function __construct($refinery_registrations){

    	$this->refinery_registrations = $refinery_registrations;

    }


    public function array(): array{

        $list = [];

        foreach ($this->refinery_registrations as $data) {

            $list[] = [

                'Crop Year' => optional($data->cropYear)->name,
                'License No.' => $data->license_no,
                'Registration Date' => optional($data->reg_date)->format('m/d/Y'),
                'Refinery Name' => optional($data->refinery)->name,
                'Refinery Address' => optional($data->refinery)->address,
                'Refinery Second Address' => optional($data->refinery)->address_second,
                'Refinery Third Address' => optional($data->refinery)->address_third,
                'Refinery Tel No.' => optional($data->refinery)->tel_no,
                'Refinery Second Tel No.' => optional($data->refinery)->tel_no_second,
                'Refinery Fax No.' => optional($data->refinery)->fax_no,
                'Refinery Second Fax No.' => optional($data->refinery)->fax_no_second,
                'Officer' => optional($data->refinery)->officer,
                'Position' => optional($data->refinery)->position,
                'Salutation' => optional($data->refinery)->salutation,
                'Rated Capacity' => $data->rated_capacity,

            ];

        }

    	return $list;

    }



    public function headings(): array{

        return [

            'Crop Year',
            'License No.',
            'Registration Date',
            'Refinery Name',
            'Refinery Address',
            'Refinery Second Address',
            'Refinery Third Address',
            'Refinery Tel No.',
            'Refinery Second Tel No.',
            'Refinery Fax No.',
            'Refinery Second Fax No.',
            'Officer',
            'Position',
            'Salutation',
            'Rated Capacity',

        ];
        
    }



}
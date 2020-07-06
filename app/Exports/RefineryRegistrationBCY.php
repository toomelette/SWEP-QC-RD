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
                'Mill Name' => optional($data->refinery)->name,
                'Mill Address' => optional($data->refinery)->address,
                'Mill Second Address' => optional($data->refinery)->address_second,
                'Mill Third Address' => optional($data->refinery)->address_third,
                'Mill Tel No.' => optional($data->refinery)->tel_no,
                'Mill Second Tel No.' => optional($data->refinery)->tel_no_second,
                'Mill Fax No.' => optional($data->refinery)->fax_no,
                'Mill Second Fax No.' => optional($data->refinery)->fax_no_second,
                'Officer' => optional($data->refinery)->officer,
                'Position' => optional($data->refinery)->position,
                'Salutation' => optional($data->refinery)->salutation,

                'MT' => $data->mt,
                'LKG' => $data->lkg,
                'Milling Fee' => $data->refinerying_fee,
                'Payment Status' => $data->payment_status,
                'Underpayment' => $data->under_payment,
                'Excess Payment' => $data->excess_payment,
                'Balance' => $data->balance_fee,
                'Rated Capacity' => $data->rated_capacity,
                'Start of Milling' => optional($data->start_refinerying)->format('m/d/Y'),
                'End of Milling' => optional($data->end_refinerying)->format('m/d/Y'),

            ];

        }

    	return $list;

    }



    public function headings(): array{

        return [

                'Crop Year',
                'License No.',
                'Registration Date',
                'Mill Name',
                'Mill Address',
                'Mill Second Address',
                'Mill Third Address',
                'Mill Tel No.',
                'Mill Second Tel No.',
                'Mill Fax No.',
                'Mill Second Fax No.',
                'Officer',
                'Position',
                'Salutation',

                'MT',
                'LKG',
                'Milling Fee',
                'Payment Status',
                'Underpayment',
                'Excess Payment',
                'Balance',
                'Rated Capacity',
                'Start of Milling',
                'End of Milling',

        ];
        
    }



}
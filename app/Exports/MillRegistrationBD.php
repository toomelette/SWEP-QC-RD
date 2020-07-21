<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MillRegistrationBD implements FromArray, WithHeadings{
    

    private $mill_registrations;


    public function __construct($mill_registrations){

    	$this->mill_registrations = $mill_registrations;

    }


    public function array(): array{

        $list = [];

        foreach ($this->mill_registrations as $data) {

            $list[] = [

                'Crop Year' => optional($data->cropYear)->name,
                'License No.' => $data->license_no,
                'Registration Date' => optional($data->reg_date)->format('m/d/Y'),
                'Mill Name' => optional($data->mill)->name,
                'Mill Address' => optional($data->mill)->address,
                'Mill Second Address' => optional($data->mill)->address_second,
                'Mill Third Address' => optional($data->mill)->address_third,
                'Mill Tel No.' => optional($data->mill)->tel_no,
                'Mill Second Tel No.' => optional($data->mill)->tel_no_second,
                'Mill Fax No.' => optional($data->mill)->fax_no,
                'Mill Second Fax No.' => optional($data->mill)->fax_no_second,
                'Officer' => optional($data->mill)->officer,
                'Position' => optional($data->mill)->position,
                'Salutation' => optional($data->mill)->salutation,

                'MT' => $data->mt,
                'LKG' => $data->lkg,
                'Milling Fee' => $data->milling_fee,
                'Payment Status' => $data->payment_status,
                'Underpayment' => $data->under_payment,
                'Excess Payment' => $data->excess_payment,
                'Balance' => $data->balance_fee,
                'Rated Capacity' => $data->rated_capacity,
                'Start of Milling' => optional($data->start_milling)->format('m/d/Y'),
                'End of Milling' => optional($data->end_milling)->format('m/d/Y'),

                'Mill Share' => $data->mill_share,
                'Planter Share' => $data->planter_share,
                'Other Shares' => $data->other_share,

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

                'Mill Share',
                'Planter Share',
                'Other Shares',

        ];
        
    }



}
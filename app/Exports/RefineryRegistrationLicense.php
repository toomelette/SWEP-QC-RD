<?php

namespace App\Exports;
use App\Core\Helpers\__dataType;

class RefineryRegistrationLicense{
    

    const ADMINISTRATOR = 'HERMENEGILDO R. SERAFICA';


    // Mill License
    public static function license($refinery_reg){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $par_bold = ['name' => 'Cambria', 'size' => 12, 'bold' => true];
        $par = ['name' => 'Cambria','size' => 12];
        $title_bold = ['name' => 'Cambria','size' => 14, 'bold' => true];
        $title_bold_u = ['name' => 'Cambria','size' => 14, 'bold' => true, 'underline' => 'single'];

        // page format
        $section = $phpWord->addSection([
            'paperSize' => 'Legal',
            'marginTop' => 6300,
            'marginRight' => 1700,
            'marginLeft' => 1700 
        ]);


        // refinery name
        $textrun = $section->addTextRun();
        $refinery_name = self::stringFilter(optional($refinery_reg->refinery)->name);
        $textrun->addText($refinery_name, $title_bold_u);
        $textrun->setParagraphStyle(array('align' => 'center', 'lineHeight' => 1.3));


        // refinery address
        if (isset($refinery_reg->license_address)) {
            
            if ($refinery_reg->license_address == 1) {
                $textrun = $section->addTextRun();
                $refinery_address = ' of '.self::stringFilter(optional($refinery_reg->refinery)->address);
                $textrun->addText($refinery_address, $par);           
            }elseif ($refinery_reg->license_address == 2) {
                $textrun = $section->addTextRun();
                $refinery_address = ' of '.self::stringFilter(optional($refinery_reg->refinery)->address_second);
                $textrun->addText($refinery_address, $par);  
            }elseif ($refinery_reg->license_address == 3) {
                $textrun = $section->addTextRun();
                $refinery_address = ' of '.self::stringFilter(optional($refinery_reg->refinery)->address_third);
                $textrun->addText($refinery_address, $par);  
            }

        }else{

            $textrun = $section->addTextRun();
            $refinery_address = ' of '.self::stringFilter(optional($refinery_reg->refinery)->address);
            $textrun->addText($refinery_address, $par);  

        }


        // crop year
        $crop_year = ' is hereby granted this license to operate a refinery for CY '.optional($refinery_reg->cropYear)->name;
        $textrun->addText($crop_year, $par);

        // txt
        $txt = ', and to have the refined sugar manufactured store in its refinerysite/subsidiary warehouses.  The withdrawal of sugar from the refinerysite/subsidiary warehouse shall be in accordance with SRA Sugar Order No. 8, dated 23 July 1992, and related rules and regulations issued by this office.';
        $textrun->addText($txt, $par);

        $textrun->setParagraphStyle(array('align' => 'both'));



        // 2nd Paragraph
        $textrun = $section->addTextRun();

        $txt = '               ';
        $textrun->addText($txt);

        // txt
        $txt = 'The SRA reserves the right to suspend/cancel/revoke this license or impose a penalty in lieu thereof  for non-observance or violation of any SRA rules and regulations, sugar order, circular letter, memorandum, etc., pertinent to the manufacture and withdrawal of refined sugar, understatement of production, non-quedaning of refined sugar or non-payment of monitoring fees.';
        $textrun->addText($txt, $par);

        $textrun->setParagraphStyle(array('align' => 'both'));



        // 3rd Paragraph
        $textrun = $section->addTextRun();

        $txt = '               ';
        $textrun->addText($txt);

        // txt
        $txt = 'This REFINING LICENSE shall be posted conspicuously at the refinery/warehouse and shall be presented and/or surrendered to competent authorities upon demand.';
        $textrun->addText($txt, $par);

        $textrun->setParagraphStyle(array('align' => 'both'));



        // 4th Paragraph
        $textrun = $section->addTextRun();

        $txt = '               ';
        $textrun->addText($txt);

        // txt
        $txt = 'NOT VALID WITHOUT OFFICIAL SEAL OF THIS OFFICE.';
        $textrun->addText($txt, $par);

        $textrun->setParagraphStyle(array('align' => 'both'));


        // 5th Paragraph
        $textrun = $section->addTextRun();

        $txt = '               ';
        $textrun->addText($txt);

        // txt
        $txt = 'Given this ' . __dataType::date_parse($refinery_reg->reg_date, "jS") .' day of '. __dataType::date_parse($refinery_reg->reg_date, "F Y") .'.';;
        $textrun->addText($txt, $par);

        $section->addTextBreak(3);
        


        // Signatory
        $textrun = $section->addTextRun();

        $txt = '                                                       '.self::ADMINISTRATOR;
        $textrun->addText($txt, $title_bold);
            
        $textrun->addTextBreak();

        $txt = '                                                                      Administrator';
        $textrun->addText($txt, ['name' => 'Cambria','size' => 14]);

        $textrun->addTextBreak(3);  


        // License
        $txt = 'REFINERY LICENSE';
        $textrun->addText($txt, $title_bold);

        $textrun->addTextBreak(); 

        $txt = 'No. ';
        $textrun->addText($txt, $title_bold);

        $txt = $refinery_reg->license_no;
        $textrun->addText($txt, $title_bold_u);




        // Export
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('refinery_license.docx'));
        } catch (Exception $e) {
            abort(500);
        }

        return response()->download(storage_path('refinery_license.docx'));

    }




    private static function stringFilter($string){

        if(strpos($string, '&') == true){
            $string = htmlentities($string);
        }

        return $string;

    }




}
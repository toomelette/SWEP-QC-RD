<?php

namespace App\Exports;
use App\Core\Helpers\__dataType;

class MillRegistrationLicense{
    

    const ADMINISTRATOR = 'HERMENEGILDO R. SERAFICA';


    // Mill License
    public static function license($mill_reg){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->addParagraphStyle('p2Style', array('align'=>'both', 'spaceAfter'=>100));

        // page format
        $section = $phpWord->addSection(['paperSize' => 'Legal','marginTop' => 6000,'marginRight' => 1700,'marginLeft' => 1700 ]);


        // 1st Paragraph
        $section = $section->addTextRun();

        // txt
        $txt = '               ';
        $section->addText($txt);

        // mill name
        $mill_name = optional($mill_reg->mill)->name;
        $section->addText($mill_name, 
            [
                'name' => 'Cambria', 
                'size' => 15, 
                'underline' => 'single',
                'bold' => true,
                'bold' => true,
            ]
        );

        // mill address
        $mill_address = ' of '.optional($mill_reg->mill)->address;
        $section->addText($mill_address, ['name' => 'Cambria', 'size' => 12]);

        // crop year
        $crop_year = ' is hereby granted this license to operate a sugar mill for CY '.optional($mill_reg->cropYear)->name;
        $section->addText($crop_year, ['name' => 'Cambria', 'size' => 12]);

        // txt
        $txt = ', and to have the centrifugal sugar manufactured store in its millsite/subsidiary warehouses.  The withdrawal of sugar from the millsite/subsidiary warehouse shall be in accordance with SRA Sugar Order No. 8, dated 23 July 1992, and related rules and regulations issued by this office.';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        
        $section->addTextBreak();
        $section->addTextBreak();


        // 2nd Paragraph
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'The SRA reserves the right to suspend/cancel/revoke this license or impose a penalty in lieu thereof  for non-observance or violation of any SRA rules and regulations, sugar order, circular letter, memorandum, etc., pertinent to the manufacture and withdrawal of sugar.';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $section->addTextBreak();
        $section->addTextBreak();


        // 3rd Paragraph
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'This MILLING LICENSE shall be posted conspicuously at the mill/warehouse and shall be presented and/or surrendered to competent authorities upon demand.';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        
        $section->addTextBreak();
        $section->addTextBreak();


        // 4th Paragraph
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'NOT VALID WITHOUT OFFICIAL SEAL OF THIS OFFICE.';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        
        $section->addTextBreak();
        $section->addTextBreak();


        // 5th Paragraph
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'Given this ' . __dataType::date_parse($mill_reg->reg_date, "jS") .' day of '. __dataType::date_parse($mill_reg->reg_date, "F Y") .'.';;
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        

        // Signatory
        $txt = '                                                                                            '.self::ADMINISTRATOR;
        $section->addText($txt, ['name' => 'Cambria','size' => 12,'bold' => true]);
            
        $section->addTextBreak();

        $txt = '                                                                                                           Administrator';
        $section->addText($txt, ['name' => 'Cambria','size' => 12]);

        $section->addTextBreak();  
        $section->addTextBreak(); 


        // License
        $txt = 'MILLING LICENSE';
        $section->addText($txt, ['name' => 'Cambria','size' => 12, 'bold' => true]);

        $section->addTextBreak(); 

        $txt = 'No. ';
        $section->addText($txt, ['name' => 'Cambria','size' => 12, 'bold' => true]);

        $txt = $mill_reg->license_no;
        $section->addText($txt, ['name' => 'Cambria','size' => 12, 'bold' => true, 'underline' => 'single',]);




        // Export
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('mill_license.docx'));
        } catch (Exception $e) {
            abort(500);
        }

        return response()->download(storage_path('mill_license.docx'));

    }






}
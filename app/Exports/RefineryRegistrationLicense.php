<?php

namespace App\Exports;
use App\Core\Helpers\__dataType;

class RefineryRegistrationLicense{
    

    const ADMINISTRATOR = 'HERMENEGILDO R. SERAFICA';


    // Mill License
    public static function license($refinery_reg){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->addParagraphStyle('p2Style', array('align'=>'both', 'spaceAfter'=>100));

        // page format
        $section = $phpWord->addSection(['paperSize' => 'Legal','marginTop' => 6000,'marginRight' => 1700,'marginLeft' => 1700 ]);


        // 1st Paragraph
        $section = $section->addTextRun();

        // txt
        $txt = '               ';
        $section->addText($txt);

        // refinery name
        $refinery_name = optional($refinery_reg->refinery)->name;
        $section->addText($refinery_name, 
            [
                'name' => 'Cambria', 
                'size' => 15, 
                'underline' => 'single',
                'bold' => true,
                'bold' => true,
            ]
        );

        // refinery address
        $refinery_address = ' of '.optional($refinery_reg->refinery)->address;
        $section->addText($refinery_address, ['name' => 'Cambria', 'size' => 12]);

        // crop year
        $crop_year = ' is hereby granted this license to operate a refinery for CY '.optional($refinery_reg->cropYear)->name;
        $section->addText($crop_year, ['name' => 'Cambria', 'size' => 12]);

        // txt
        $txt = ', and to have the refined sugar manufactured store in its refinerysite/subsidiary warehouses.  The withdrawal of sugar from the refinerysite/subsidiary warehouse shall be in accordance with SRA Sugar Order No. 8, dated 23 July 1992, and related rules and regulations issued by this office.';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        
        $section->addTextBreak();
        $section->addTextBreak();


        // 2nd Paragraph
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'The SRA reserves the right to suspend/cancel/revoke this license or impose a penalty in lieu thereof  for non-observance or violation of any SRA rules and regulations, sugar order, circular letter, memorandum, etc., pertinent to the manufacture and withdrawal of refined sugar, understatement of production, non-quedaning of refined sugar or non-payment of monitoring fees.';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $section->addTextBreak();
        $section->addTextBreak();


        // 3rd Paragraph
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'This REFINING LICENSE shall be posted conspicuously at the refinery/warehouse and shall be presented and/or surrendered to competent authorities upon demand.';
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
        $txt = 'Given this ' . __dataType::date_parse($refinery_reg->reg_date, "jS") .' day of '. __dataType::date_parse($refinery_reg->reg_date, "F Y") .'.';;
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
        $txt = 'REFINERY LICENSE';
        $section->addText($txt, ['name' => 'Cambria','size' => 12, 'bold' => true]);

        $section->addTextBreak(); 

        $txt = 'No. ';
        $section->addText($txt, ['name' => 'Cambria','size' => 12, 'bold' => true]);

        $txt = $refinery_reg->license_no;
        $section->addText($txt, ['name' => 'Cambria','size' => 12, 'bold' => true, 'underline' => 'single',]);




        // Export
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('license.docx'));
        } catch (Exception $e) {
            abort(500);
        }

        return response()->download(storage_path('license.docx'));

    }






}
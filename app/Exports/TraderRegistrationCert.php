<?php

namespace App\Exports;
use App\Core\Helpers\__dataType;

class TraderRegistrationCert{
    

    const ADMINISTRATOR = 'HERMENEGILDO R. SERAFICA';


    // TRADER CERTIFICATE
    public static function cert($trader_reg){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->addParagraphStyle('p2Style', array('align'=>'both', 'spaceAfter'=>100));

        // page format
        $section = $phpWord->addSection(['paperSize' => 'Legal','marginTop' => 6000,'marginRight' => 1700,'marginLeft' => 1700 ]);


        // 1st Paragraph
        $section = $section->addTextRun();

        // txt
        $txt = '               ';
        $section->addText($txt);

        // trader name
        $trader_name = ''.optional($trader_reg->trader)->name;
        $section->addText($trader_name, ['name' => 'Cambria', 'size' => 12, 'underline' => 'single','bold' => true,]);

        // txt
        $txt = ' of';
        $section->addText($txt, ['name' => 'Cambria','size' => 12,]);

        // trader address
        $trader_address = ' '.optional($trader_reg->trader)->address;
        $section->addText($trader_address, ['name' => 'Cambria', 'size' => 12, 'bold' => true,]);

        // txt
        if ($trader_reg->trader_cat_id == "TC1001") {

            $txt = ', is hereby licensed with this Office to operate as a DOMESTIC SUGAR TRADER during the ';
            $section->addText($txt, ['name' => 'Cambria','size' => 12,]);

        }elseif ($trader_reg->trader_cat_id == "TC1002") {

            $txt = ', is hereby licensed with this Office to operate as INTERNATIONAL (EXPORT/IMPORT) SUGAR TRADER during the ';
            $section->addText($txt, ['name' => 'Cambria','size' => 12,]);

        }elseif ($trader_reg->trader_cat_id == "TC1003") {

            $txt = ', is hereby licensed with this Office to operate as DOMESTIC MOLASSES TRADER during the ';
            $section->addText($txt, ['name' => 'Cambria','size' => 12,]);

        }elseif ($trader_reg->trader_cat_id == "TC1004") {

            $txt = ', is hereby licensed with this Office to operate as INTERNATIONAL MOLASSES TRADER during the ';
            $section->addText($txt, ['name' => 'Cambria','size' => 12,]);

        }elseif ($trader_reg->trader_cat_id == "TC1005") {

            $txt = ', is hereby licensed with this Office to operate as MUSCOVADO TRADER during the ';
            $section->addText($txt, ['name' => 'Cambria','size' => 12,]);

        }elseif ($trader_reg->trader_cat_id == "TC1006") {

            $txt = ', is hereby licensed with this Office to operate as INTERNATIONAL SUGAR TRADER for Chemically Pure Fructose and High Fructose Corn Syrup during the ';
            $section->addText($txt, ['name' => 'Cambria','size' => 12,]);

        }

        // crop year
        $cy = ' '.optional($trader_reg->cropYear)->name;
        $section->addText($cy, ['name' => 'Cambria','size' => 12,'bold' => true]);

        // txt
        if ($trader_reg->trader_cat_id == "TC1001" || $trader_reg->trader_cat_id == "TC1002") {

            $txt = ' Crop Year. Said Trader is hereby authorized to';
            $section->addText($txt, ['name' => 'Cambria','size' => 12]);

            $txt = ' withdraw purchased';
            $section->addText($txt, ['name' => 'Cambria','size' => 12,'bold' => true]);

            $txt = ' sugar from the warehouse of any mill or refinery subject to rules and regulations issued by this Office pursuant thereto.';
            $section->addText($txt, ['name' => 'Cambria','size' => 12]);
            
        }elseif ($trader_reg->trader_cat_id == "TC1003" || $trader_reg->trader_cat_id == "TC1004") {

            $txt = ' Crop Year. Said Trader is hereby authorized to';
            $section->addText($txt, ['name' => 'Cambria','size' => 12]);

            $txt = ' withdraw purchased';
            $section->addText($txt, ['name' => 'Cambria','size' => 12,'bold' => true]);

            $txt = ' molasses from the warehouse of any mill or refinery subject to rules and regulations issued by this Office pursuant thereto.';
            $section->addText($txt, ['name' => 'Cambria','size' => 12]);
            
        }elseif($trader_reg->trader_cat_id == "TC1005"){

            $txt = ' Crop Year. Said Trader is hereby authorized to';
            $section->addText($txt, ['name' => 'Cambria','size' => 12]);
            
            $txt = ' withdraw purchased';
            $section->addText($txt, ['name' => 'Cambria','size' => 12,'bold' => true]);

            $txt = ' muscovado from the warehouse of any muscovado mill.';
            $section->addText($txt, ['name' => 'Cambria','size' => 12]);

        }elseif($trader_reg->trader_cat_id == "TC1006"){

            $txt = ' Crop Year.';
            $section->addText($txt, ['name' => 'Cambria','size' => 12]);

        }


        // 2nd Paragraph
        $section->addTextBreak();
        $section->addTextBreak();

        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'The licensed/registered trader is required to submit a semi-annual report of its trading activities ';
        $section->addText($txt, ['name' => 'Cambria','size' => 12]);

        // txt
        $txt = 'and such other report/s as maybe required by SRA. For its failure to submit the same, the trader shall be subject to the provision ';
        $section->addText($txt, ['name' => 'Cambria','size' => 12, 'bold' => true]);

        // txt
        $txt = 'of SRA Sugar Order No.10, Series of 2009-2010, dated February 26, 2010 ';
        $section->addText($txt, ['name' => 'Cambria','size' => 12]);

        // txt
        $txt = 'and other pertinent SRA rules and regulations.';
        $section->addText($txt, ['name' => 'Cambria','size' => 12, 'bold' => true]);


        // 3rd Paragraph
        $section->addTextBreak();
        $section->addTextBreak();

        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'This license shall be posted conspicuously at the place where business/warehouse is located and shall be presented and/or   surrendered to concerned authorities upon demand. In case of closure of business, this License to Operate must be surrendered to this Office for official retirement.';
        $section->addText($txt, ['name' => 'Cambria','size' => 12]);


        // 4th Paragraph
        $section->addTextBreak();
        $section->addTextBreak();
        
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'Any erasure/alteration on this certificate/license will invalidate same. NOT TRANSFERABLE AND NOT VALID WITHOUT OFFICIAL SEAL OF THIS OFFICE.';
        $section->addText($txt, ['name' => 'Cambria','size' => 12]);


        // 5th Paragraph
        $section->addTextBreak();
        $section->addTextBreak();
        
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'Given this ' . __dataType::date_parse($trader_reg->reg_date, "jS") .' day of '. __dataType::date_parse($trader_reg->reg_date, "F Y") .'.';
        $section->addText($txt, ['name' => 'Cambria','size' => 12]);

        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        

        // Signatory
        $txt = '                                                                           '.self::ADMINISTRATOR;
        $section->addText($txt, ['name' => 'Cambria','size' => 12]);
            
        $section->addTextBreak();

        $txt = '                                                                                          Administrator';
        $section->addText($txt, ['name' => 'Cambria','size' => 12]);

        $section->addTextBreak();  
        $section->addTextBreak();      


        // Image & Control No.
        $section->addImage('images/flag.png', ['width' => 140,'height' => 70,'wrappingStyle' => 'behind','positioning' => 'absolute','posHorizontalRel' => 'margin','posVerticalRel' => 'line',]);

        $section->addTextBreak(); 
        $section->addTextBreak();

        $control_no = '   '. $trader_reg->control_no;
        $section->addText($control_no, ['name' => 'Cambria','size' => 13, 'bold' => true]);

        $section->addTextBreak(); 
        $section->addTextBreak();  
        $section->addTextBreak();  
        $section->addTextBreak();          


        // TIN
        $txt = 'TIN: ';
        $section->addText($txt, ['name' => 'Cambria','size' => 13]);

        $tin = optional($trader_reg->trader)->tin;
        $section->addText($tin, ['name' => 'Cambria','size' => 13, 'bold' => true, 'underline' => 'single',]);


        // Export

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('trader_license.docx'));
        } catch (Exception $e) {
            abort(500);
        }

        return response()->download(storage_path('trader_license.docx'));

    }






}
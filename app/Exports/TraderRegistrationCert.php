<?php

namespace App\Exports;
use App\Core\Helpers\__dataType;

class TraderRegistrationCert{
    

    const ADMINISTRATOR = 'HERMENEGILDO R. SERAFICA';


    // TRADER CERTIFICATE
    public static function cert($trader_reg){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $par_bold = ['name' => 'Arial', 'size' => 12, 'bold' => true];
        $par = ['name' => 'Arial','size' => 12];
        $title_bold = ['name' => 'Arial','size' => 14, 'bold' => true];
        $title_bold_u = ['name' => 'Arial','size' => 14, 'bold' => true, 'underline' => 'single'];

        // page format
        $section = $phpWord->addSection([
            'paperSize' => 'Legal',
            'marginTop' => 5500,
            'marginRight' => 1700,
            'marginLeft' => 1700 
        ]);



        // Trader Name
        $textrun = $section->addTextRun();

        $trader_name = ''.self::stringFilter(optional($trader_reg->trader)->name);
        $textrun->addText($trader_name, ['name' => 'Arial', 'size' => 14, 'underline' => 'single','bold' => true,]);
        $textrun->setParagraphStyle(array('align' => 'center'));

        // 1st Paragraph
        $textrun = $section->addTextRun();
        $txt = ' of';
        $textrun->addText($txt, $par);

        // trader address
        $trader_address = ' '.self::stringFilter(optional($trader_reg->trader)->address);
        $textrun->addText($trader_address, $par_bold);

        // txt
        if ($trader_reg->trader_cat_id == "TC1001") {

            $txt = ', is hereby licensed with this Office to operate as a DOMESTIC SUGAR TRADER during the ';
            $textrun->addText($txt, $par);

        }elseif ($trader_reg->trader_cat_id == "TC1002") {

            $txt = ', is hereby licensed with this Office to operate as INTERNATIONAL (EXPORT/IMPORT) SUGAR TRADER during the ';
            $textrun->addText($txt, $par);

        }elseif ($trader_reg->trader_cat_id == "TC1003") {

            $txt = ', is hereby licensed with this Office to operate as DOMESTIC MOLASSES TRADER during the ';
            $textrun->addText($txt, $par);

        }elseif ($trader_reg->trader_cat_id == "TC1004") {

            $txt = ', is hereby licensed with this Office to operate as INTERNATIONAL MOLASSES TRADER during the ';
            $textrun->addText($txt, $par);

        }elseif ($trader_reg->trader_cat_id == "TC1005") {

            $txt = ', is hereby licensed with this Office to operate as MUSCOVADO TRADER during the ';
            $textrun->addText($txt, $par);

        }elseif ($trader_reg->trader_cat_id == "TC1006") {

            $txt = ', is hereby licensed with this Office to operate as INTERNATIONAL SUGAR TRADER for Chemically Pure Fructose and High Fructose Corn Syrup during the ';
            $textrun->addText($txt, $par);

        }

        // crop year
        $cy = ' '.optional($trader_reg->cropYear)->name;
        $textrun->addText($cy, $par_bold);

        // txt
        if ($trader_reg->trader_cat_id == "TC1001" || $trader_reg->trader_cat_id == "TC1002") {

            $txt = ' Crop Year. Said Trader is hereby authorized to';
            $textrun->addText($txt, $par);

            $txt = ' withdraw purchased';
            $textrun->addText($txt, $par_bold);

            $txt = ' sugar from the warehouse of any mill or refinery subject to rules and regulations issued by this Office pursuant thereto.';
            $textrun->addText($txt, $par);
            
        }elseif ($trader_reg->trader_cat_id == "TC1003" || $trader_reg->trader_cat_id == "TC1004") {

            $txt = ' Crop Year. Said Trader is hereby authorized to';
            $textrun->addText($txt, $par);

            $txt = ' withdraw purchased';
            $textrun->addText($txt, $par_bold);

            $txt = ' molasses from the warehouse of any mill or refinery subject to rules and regulations issued by this Office pursuant thereto.';
            $textrun->addText($txt, $par);
            
        }elseif($trader_reg->trader_cat_id == "TC1005"){

            $txt = ' Crop Year. Said Trader is hereby authorized to';
            $textrun->addText($txt, $par);
            
            $txt = ' withdraw purchased';
            $textrun->addText($txt, $par_bold);

            $txt = ' muscovado from the warehouse of any muscovado mill.';
            $textrun->addText($txt, $par);

        }elseif($trader_reg->trader_cat_id == "TC1006"){

            $txt = ' Crop Year.';
            $textrun->addText($txt, $par);

        }

        $textrun->setParagraphStyle(array('align' => 'both'));



        // 2nd Paragraph
        $textrun = $section->addTextRun();

        $txt = '               ';
        $textrun->addText($txt);

        // txt
        $txt = 'The licensed/registered trader is required to submit a semi-annual report of its trading activities ';
        $textrun->addText($txt, $par);

        // txt
        $txt = 'and such other report/s as maybe required by SRA. For its failure to submit the same, the trader shall be subject to the provision ';
        $textrun->addText($txt, $par_bold);

        // txt
        $txt = 'of SRA Sugar Order No.10, Series of 2009-2010, dated February 26, 2010 ';
        $textrun->addText($txt, $par);

        // txt
        $txt = 'and other pertinent SRA rules and regulations.';
        $textrun->addText($txt, $par_bold);

        $textrun->setParagraphStyle(array('align' => 'both'));



        // 3rd Paragraph
        $textrun = $section->addTextRun();

        $txt = '               ';
        $textrun->addText($txt);

        // txt
        $txt = 'This license shall be posted conspicuously at the place where business/warehouse is located and shall be presented and/or   surrendered to concerned authorities upon demand. In case of closure of business, this License to Operate must be surrendered to this Office for official retirement.';
        $textrun->addText($txt, $par);

        $textrun->setParagraphStyle(array('align' => 'both'));



        // 4th Paragraph
        $textrun = $section->addTextRun();
        
        $txt = '               ';
        $textrun->addText($txt);

        // txt
        $txt = 'Any erasure/alteration on this certificate/license will invalidate same. NOT TRANSFERABLE AND NOT VALID WITHOUT OFFICIAL SEAL OF THIS OFFICE.';
        $textrun->addText($txt, $par);

        $textrun->setParagraphStyle(array('align' => 'both'));



        // 5th Paragraph
        $textrun = $section->addTextRun();
        
        $txt = '               ';
        $textrun->addText($txt);

        // txt
        $txt = 'Given this ' . __dataType::date_parse($trader_reg->reg_date, "jS") .' day of '. __dataType::date_parse($trader_reg->reg_date, "F Y") .'. Valid Until August 31, 2021.';
        $textrun->addText($txt, $par);

        $textrun->addTextBreak(2);
        


        // Signatory
        $textrun = $section->addTextRun();

        $txt = '                                                       '.self::ADMINISTRATOR;
        $textrun->addText($txt, $title_bold);
            
        $textrun->addTextBreak();

        $txt = '                                                                      Administrator';
        $textrun->addText($txt, ['name' => 'Arial','size' => 14]);

        $textrun->addTextBreak(2);       


        // Image & Control No.
        $textrun->addImage('images/flag.png', ['width' => 130,'height' => 40,'wrappingStyle' => 'behind','positioning' => 'absolute','posHorizontalRel' => 'margin','posVerticalRel' => 'line',]);

        $textrun->addTextBreak(); 

        $control_no = '   '. $trader_reg->control_no;
        $textrun->addText($control_no, $title_bold);

        $textrun->addTextBreak(3);          


        // TIN
        $txt = 'TIN: ';
        $textrun->addText($txt, $title_bold);

        $tin = optional($trader_reg->trader)->tin;
        $textrun->addText($tin, $title_bold_u);


        // Export

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('trader_license.docx'));
        } catch (Exception $e) {
            abort(500);
        }

        return response()->download(storage_path('trader_license.docx'));

    }



    private static function stringFilter($string){

        if(strpos($string, '&') == true){
            $string = htmlentities($string);
        }

        return $string;

    }



}
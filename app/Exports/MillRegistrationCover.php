<?php

namespace App\Exports;
use App\Core\Helpers\__dataType;
use Carbon;

class MillRegistrationCover{
    

    const ADMINISTRATOR = 'ENGR. HERMENEGILDO R. SERAFICA';


    // COVER LETTER
    public static function coverLetter($mill_reg){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Page Format
        $section = $phpWord->addSection([
            'paperSize' => 'A4', 
            'marginTop' => 3000, 
            'marginLeft' => 2200, 
            'marginRight' => 2200 
        ]);


        $textrun = $section->addTextRun();

        // Tracking No.
        $tracking_no = "MEMO-REG-LMD-".Carbon::now()->format('Y')."-".Carbon::now()->format('M')."-";
        $textrun->addText($tracking_no, ['name' => 'Cambria', 'size' => 10]);

        $textrun->addTextBreak(5);

        // Date
        $date = Carbon::now()->format('F d, Y');
        $textrun->addText($date, ['name' => 'Cambria', 'size' => 12]);
        $textrun->addTextBreak(3);


        // Header
        $officer = optional($mill_reg->mill)->officer;
        $textrun->addText($officer, ['name' => 'Cambria', 'size' => 12, 'bold' => true,]);
        $textrun->addTextBreak();

        $position = self::stringFilter(optional($mill_reg->mill)->position);
        $textrun->addText($position, ['name' => 'Cambria', 'size' => 12]);
        $textrun->addTextBreak();

        $name = self::stringFilter(optional($mill_reg->mill)->name);
        $textrun->addText($name, ['name' => 'Cambria', 'size' => 12, 'bold' => true,]);
        $textrun->addTextBreak();

        if (isset($mill_reg->cover_letter_address)) {
            
            if ($mill_reg->cover_letter_address == 1) {
                $address = self::stringFilter(optional($mill_reg->mill)->address);
                $textrun->addText($address, ['name' => 'Cambria', 'size' => 12]);
                $textrun->addTextBreak(1);                
            }elseif ($mill_reg->cover_letter_address == 2) {
                $address = self::stringFilter(optional($mill_reg->mill)->address_second);
                $textrun->addText($address, ['name' => 'Cambria', 'size' => 12]);
                $textrun->addTextBreak(1);    
            }elseif ($mill_reg->cover_letter_address == 3) {
                $address = self::stringFilter(optional($mill_reg->mill)->address_third);
                $textrun->addText($address, ['name' => 'Cambria', 'size' => 12]);
                $textrun->addTextBreak(1);    
            }

        }else{

            $address = self::stringFilter(optional($mill_reg->mill)->address);
            $textrun->addText($address, ['name' => 'Cambria', 'size' => 12]);
            $textrun->addTextBreak(1);  

        }


        // Salutation
        $textrun = $section->addTextRun();
        $salutation = self::stringFilter(optional($mill_reg->mill)->salutation) .':';
        $textrun->addText($salutation, ['name' => 'Cambria', 'size' => 12]);

        // Txt
        $textrun = $section->addTextRun();
        $txt = 'Enclosed is your ';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $license = 'Milling License No. ' . $mill_reg->license_no . ' for CY ' . optional($mill_reg->cropYear)->name;
        $textrun->addText($license, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);

        $txt = ' duly approved by this Office.';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        // TXT
        $textrun = $section->addTextRun();
        $txt = 'As provided for in Section 7, of SRA Circular Letter No. 4, dated 03 September 1991, you are required at the start of each crop year to register with this Office the certificate of authority and official signature of your warehouse receipt agent or warehouseman, and shall report to the SRA any replacement thereof.';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12], ['align'=>'both', 'spaceAfter'=>100]);

        $textrun->setParagraphStyle(array('align' => 'both'));

        // TXT
        $textrun = $section->addTextRun();
        $txt = 'Thank you.';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $textrun->addTextBreak(3);

        // TXT
        $txt = 'Very truly yours,';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $textrun->addTextBreak(4);


        // Administrator
        $txt = self::ADMINISTRATOR;
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);
        $textrun->addTextBreak();
        $txt = 'Administrator';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $textrun->addTextBreak(5);

        // 
        $txt = 'Encl: as stated';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        

        // Export
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('mill_cover_letter.docx'));
        } catch (Exception $e) {
            abort(500);
        }

        return response()->download(storage_path('mill_cover_letter.docx'));

    }



    private static function stringFilter($string){

        if(strpos($string, '&') == true){
            $string = htmlentities($string);
        }

        return $string;

    }






}
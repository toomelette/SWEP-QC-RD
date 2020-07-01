<?php

namespace App\Exports;
use App\Core\Helpers\__dataType;
use Carbon;

class RefineryRegistrationCover{
    

    const ADMINISTRATOR = 'ENGR. HERMENEGILDO R. SERAFICA';


    // COVER LETTER
    public static function coverLetter($refinery_reg){

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->addParagraphStyle('p2Style', array('align'=>'both', 'spaceAfter'=>100));

        // Page Format
        $section = $phpWord->addSection(['paperSize' => 'A4', 'marginTop' => 3000, 'marginLeft' => 2200, 'marginRight' => 2200 ]);

        $section = $section->addTextRun();

        // Tracking No.
        $tracking_no = "MEMO-REG-LMD-".Carbon::now()->format('Y')."-".Carbon::now()->format('M')."-";
        $section->addText($tracking_no, ['name' => 'Cambria', 'size' => 10]);

        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();

        // Date
        $date = Carbon::now()->format('F d, Y');
        $section->addText($date, ['name' => 'Cambria', 'size' => 12]);

        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();

        // Header
        $officer = optional($refinery_reg->refinery)->officer;
        $section->addText($officer, ['name' => 'Cambria', 'size' => 12, 'bold' => true,]);
        $section->addTextBreak();

        $position = optional($refinery_reg->refinery)->position;
        $section->addText($position, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();

        $name = optional($refinery_reg->refinery)->name;
        $section->addText($name, ['name' => 'Cambria', 'size' => 12, 'bold' => true,]);
        $section->addTextBreak();

        $address = optional($refinery_reg->refinery)->address;
        $section->addText($address, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();
        $section->addTextBreak();

        // Salutation
        $salutation = optional($refinery_reg->refinery)->salutation .':';
        $section->addText($salutation, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();
        $section->addTextBreak();

        // Txt
        $txt = 'Enclosed is your ';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $license = 'Refining License No. ' . $refinery_reg->license_no . ' for CY ' . optional($refinery_reg->cropYear)->name;
        $section->addText($license, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);

        $txt = ' duly approved by this Office.';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $section->addTextBreak();
        $section->addTextBreak();

        // TXT
        $txt = 'As provided for in Section 7, of SRA Circular Letter No. 4, dated 03 September 1991, you are required at the start of each crop year to register with this Office the certificate of authority and official signature of your warehouse receipt agent or warehouseman, and shall report to the SRA any replacement thereof.';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12], ['align'=>'both', 'spaceAfter'=>100]);
        $section->addTextBreak();
        $section->addTextBreak();

        // TXT
        $txt = 'Thank you.';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();

        // TXT
        $txt = 'Very truly yours,';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();


        // Administrator
        $txt = self::ADMINISTRATOR;
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);
        $section->addTextBreak();
        $txt = 'Administrator';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();

        // 
        $txt = 'Encl: as stated';
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        

        // Export
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('cover_letter.docx'));
        } catch (Exception $e) {
            abort(500);
        }

        return response()->download(storage_path('cover_letter.docx'));

    }






}
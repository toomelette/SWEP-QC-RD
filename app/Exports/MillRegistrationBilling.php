<?php

namespace App\Exports;
use App\Core\Helpers\__dataType;
use Carbon;

class MillRegistrationBilling{
    

    const ADMINISTRATOR = 'ENGR. HERMENEGILDO R. SERAFICA';


    // COVER LETTER
    public static function billingStatement($mill_reg){

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

        $position = optional($mill_reg->mill)->position;
        $textrun->addText($position, ['name' => 'Cambria', 'size' => 12]);
        $textrun->addTextBreak();

        $name = optional($mill_reg->mill)->name;
        $textrun->addText($name, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);
        $textrun->addTextBreak();

        $address = optional($mill_reg->mill)->address;
        $textrun->addText($address, ['name' => 'Cambria', 'size' => 12]);
        $textrun->addTextBreak(1);

        // Salutation
        $textrun = $section->addTextRun();
        $salutation = optional($mill_reg->mill)->salutation .':';
        $textrun->addText($salutation, ['name' => 'Cambria', 'size' => 12]);

        // Paragraph 1
        $textrun = $section->addTextRun();
        $status = $mill_reg->payment_status == "UP" ? "underpayment" : "excess payment";
        $payment_amount = $mill_reg->payment_status == "UP" ? $mill_reg->under_payment : $mill_reg->excess_payment;
        $txt = "Please be informed that based on your submitted production estimate of ". number_format($mill_reg->mt, 2) ." Metric Tons or ". number_format($mill_reg->lkg, 2) ." Lkg., your Milling License Fee for Crop Year ". optional($mill_reg->cropYear)->name ." is ". __dataType::num_to_words($mill_reg->milling_fee) ." (PHP ". number_format($mill_reg->milling_fee, 2) .") PESOS.  However, you have an ". $status ." in your Milling License Fee for CY ". optional($mill_reg->cropYear)->name ." in the amount of ". __dataType::num_to_words($payment_amount) ." PESOS (PHP ". number_format($payment_amount, 2) .").";
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $textrun->setParagraphStyle(array('align' => 'both'));

        // Paragraph 2
        $textrun = $section->addTextRun();
        $txt = "In view thereof, please settle the amount of ";
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $txt = __dataType::num_to_words($mill_reg->balance_fee) ." PESOS (PHP ". number_format($mill_reg->balance_fee, 2) .")";
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);

        $txt = " to facilitate the renewal of your ";
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $txt = "MILLING LICENSE";
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);

        $txt = " for";
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $txt = " CROP YEAR ";
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);

        $txt = optional($mill_reg->cropYear)->name.".";
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);
        $textrun->setParagraphStyle(array('align' => 'both'));

        // Paragraph 3
        $textrun = $section->addTextRun();
        $txt = "Please be guided by the provisions of SRA Sugar Order No. 8, dated 23 July 1992. ";
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);


        // TXT
        $textrun = $section->addTextRun();
        $txt = 'Thank you.';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $textrun->addTextBreak(3);

        // TXT
        $txt = 'Very truly yours,';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $textrun->addTextBreak(2);


        // Administrator
        $textrun = $section->addTextRun();
        $txt = self::ADMINISTRATOR;
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);
        $textrun->addTextBreak();
        $txt = 'Administrator';
        $textrun->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        

        // Export
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('mill_billing_statement.docx'));
        } catch (Exception $e) {
            abort(500);
        }

        return response()->download(storage_path('mill_billing_statement.docx'));

    }




}
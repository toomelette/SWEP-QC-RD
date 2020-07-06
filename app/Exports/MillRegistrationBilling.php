<?php

namespace App\Exports;
use App\Core\Helpers\__dataType;
use Carbon;

class MillRegistrationBilling{
    

    const ADMINISTRATOR = 'ENGR. HERMENEGILDO R. SERAFICA';


    // COVER LETTER
    public static function billingStatement($mill_reg){

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
        $officer = optional($mill_reg->mill)->officer;
        $section->addText($officer, ['name' => 'Cambria', 'size' => 12, 'bold' => true,]);
        $section->addTextBreak();

        $position = optional($mill_reg->mill)->position;
        $section->addText($position, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();

        $name = optional($mill_reg->mill)->name;
        $section->addText($name, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);
        $section->addTextBreak();

        $address = optional($mill_reg->mill)->address;
        $section->addText($address, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();
        $section->addTextBreak();

        // Salutation
        $salutation = optional($mill_reg->mill)->salutation .':';
        $section->addText($salutation, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();
        $section->addTextBreak();

        // Paragraph 1
        $status = $mill_reg->payment_status == "UP" ? "underpayment" : "excess payment";
        $payment_amount = $mill_reg->payment_status == "UP" ? $mill_reg->under_payment : $mill_reg->excess_payment;
        $txt = "Please be informed that based on your submitted production estimate of ". number_format($mill_reg->mt, 2) ." Metric Tons or ". number_format($mill_reg->lkg, 2) ." Lkg., your Milling License Fee for Crop Year ". optional($mill_reg->cropYear)->name ." is ". __dataType::num_to_words($mill_reg->milling_fee) ." (PHP ". number_format($mill_reg->milling_fee, 2) .") PESOS.  However, you have an ". $status ." in your Milling License Fee for CY ". optional($mill_reg->cropYear)->name ." in the amount of ". __dataType::num_to_words($payment_amount) ." PESOS (PHP ". number_format($payment_amount, 2) .").";
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
        $section->addTextBreak();
        $section->addTextBreak();

        // Paragraph 2
        $txt = "In view thereof, please settle the amount of ";
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $txt = __dataType::num_to_words($mill_reg->balance_fee) ." PESOS (PHP ". number_format($mill_reg->balance_fee, 2) .")";
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);

        $txt = " to facilitate the renewal of your ";
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $txt = "MILLING LICENSE";
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);

        $txt = " for";
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);

        $txt = " CROP YEAR ";
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);

        $txt = optional($mill_reg->cropYear)->name.".";
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12, 'bold' => true]);
        $section->addTextBreak();
        $section->addTextBreak();

        // Paragraph 3
        $txt = "Please be guided by the provisions of SRA Sugar Order No. 8, dated 23 July 1992. ";
        $section->addText($txt, ['name' => 'Cambria', 'size' => 12]);
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
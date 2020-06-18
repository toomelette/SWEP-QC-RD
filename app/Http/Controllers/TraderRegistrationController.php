<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\TraderRegistrationInterface;
use App\Core\Interfaces\CropYearInterface;
use App\Http\Requests\TraderRegistration\TraderRegistrationFormRequest;
use App\Http\Requests\TraderRegistration\TraderRegistrationFilterRequest;
use App\Http\Requests\TraderRegistration\TraderRegistrationReportRequest;

use App\Exports\TraderRegistrationBDC;
use Maatwebsite\Excel\Facades\Excel;


class TraderRegistrationController extends Controller{


    protected $trader_reg_repo;
    protected $cy_repo;

    protected $administrator = 'HERMENEGILDO R. SERAFICA';


    public function __construct(TraderRegistrationInterface $trader_reg_repo,
                                CropYearInterface $cy_repo){
        $this->trader_reg_repo = $trader_reg_repo;
        $this->cy_repo = $cy_repo;
        parent::__construct();
    }
 


    public function show($slug){

        $trader_reg = $this->trader_reg_repo->findbySlug($slug);
        return view('dashboard.trader_registration.show')->with('trader_reg', $trader_reg);

    }



    public function print($slug){

        $trader_reg = $this->trader_reg_repo->findbySlug($slug);
        return view('printables.trader_registration.license')->with('trader_reg', $trader_reg);

    }




    public function downloadWordFile($slug){

        $trader_reg = $this->trader_reg_repo->findbySlug($slug);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();


        $phpWord->addParagraphStyle('p2Style', array('align'=>'both', 'spaceAfter'=>100));

        // page format
        $section = $phpWord->addSection([
            "paperSize" => "Legal",
            'marginTop' => 6000
        ]);

        // 1st Paragraph
        $section = $section->addTextRun();

        // txt
        $txt = '               ';
        $section->addText($txt);

        // trader name
        $trader_name = ''.optional($trader_reg->trader)->name;
        $section->addText(
            $trader_name, 
            [
                'name' => 'Arial', 
                'size' => 12, 
                'underline' => 'single',
                'bold' => true,
            ]
        );

        // txt
        $txt = ' of';
        $section->addText($txt, ['name' => 'Arial','size' => 12,]);

        // trader address
        $trader_address = ' '.optional($trader_reg->trader)->address;
        $section->addText($trader_address, [
            'name' => 'Arial', 
            'size' => 12, 
            'bold' => true,
        ]);

        // txt
        $txt = ', is hereby licensed with this Office to operate as DOMESTIC MOLASSES TRADER during the ';
        $section->addText($txt, ['name' => 'Arial','size' => 12,]);

        // crop year
        $cy = ' '.optional($trader_reg->cropYear)->name;
        $section->addText($cy, ['name' => 'Arial','size' => 12,'bold' => true]);

        // txt
        $txt = ' Crop Year. Said Trader is hereby authorized to';
        $section->addText($txt, ['name' => 'Arial','size' => 12]);

        // txt
        $txt = ' withdraw purchased';
        $section->addText($txt, ['name' => 'Arial','size' => 12,'bold' => true]);

        // txt
        $txt = ' molasses from the warehouse of any mill or refinery subject to rules and regulations issued by this Office pursuant thereto.';
        $section->addText($txt, ['name' => 'Arial','size' => 12]);



        // 2nd Paragraph
        $section->addTextBreak();
        $section->addTextBreak();

        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'The licensed/registered trader is required to submit a semi-annual report of its trading activities ';
        $section->addText($txt, ['name' => 'Arial','size' => 12]);

        // txt
        $txt = 'and such other report/s as maybe required by SRA. For its failure to submit the same, the trader shall be subject to the provision ';
        $section->addText($txt, ['name' => 'Arial','size' => 12, 'bold' => true]);

        // txt
        $txt = 'of SRA Sugar Order No.10, Series of 2009-2010, dated February 26, 2010 ';
        $section->addText($txt, ['name' => 'Arial','size' => 12]);

        // txt
        $txt = 'and other pertinent SRA rules and regulations.';
        $section->addText($txt, ['name' => 'Arial','size' => 12, 'bold' => true]);



        // 3rd Paragraph
        $section->addTextBreak();
        $section->addTextBreak();

        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'This license shall be posted conspicuously at the place where business/warehouse is located and shall be presented and/or   surrendered to concerned authorities upon demand. In case of closure of business, this License to Operate must be surrendered to this Office for official retirement.';
        $section->addText($txt, ['name' => 'Arial','size' => 12]);



        // 4th Paragraph
        $section->addTextBreak();
        $section->addTextBreak();
        
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'Any erasure/alteration on this certificate/license will invalidate same. NOT TRANSFERABLE AND NOT VALID WITHOUT OFFICIAL SEAL OF THIS OFFICE.';
        $section->addText($txt, ['name' => 'Arial','size' => 12]);



        // 5th Paragraph
        $section->addTextBreak();
        $section->addTextBreak();
        
        $txt = '               ';
        $section->addText($txt);

        // txt
        $txt = 'Given this ' . $this->__dataType->date_parse($trader_reg->reg_date, "jS") .' day of '. $this->__dataType->date_parse($trader_reg->reg_date, "F Y") .'.';
        $section->addText($txt, ['name' => 'Arial','size' => 12]);



        // Signatory
        $section->addTextBreak();
        $section->addTextBreak();
        
        $txt = '                                               ' . $this->administrator;
        $section->addText($txt, ['name' => 'Arial','size' => 12]);
        
        $txt = '                                               Administrator';
        $section->addText($txt, ['name' => 'Arial','size' => 12]);



        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        try {
            $objWriter->save(storage_path('certificate.docx'));
        } catch (Exception $e) {
            abort(500);
        }

        return response()->download(storage_path('certificate.docx'));

    }




    public function destroy($slug){

        $trader_reg = $this->trader_reg_repo->destroy($slug);
        $this->event->fire('trader_reg.destroy', $trader_reg);
        return redirect()->back();

    }




    public function reports(){
        return view('dashboard.trader_registration.reports');
    }



    public function reportsOutput(TraderRegistrationReportRequest $request){

        if ($request->ft == 'bdc') {
            
            $trader_registrations = $this->trader_reg_repo->getByRegDate_Category($request->bdc_df, $request->bdc_dt, $request->bdc_tc);
            
            if ($request->bdc_t == 'p') {

                return view('printables.trader_registration.list_bdc')->with('trader_registrations', $trader_registrations);
                
            }elseif ($request->bdc_t == 'e') {

                return Excel::download(
                    new TraderRegistrationBDC($trader_registrations), 'list_by_date_category.xlsx'
                );

            }

        }elseif ($request->ft == 'bcyc') {

            if ($request->bcyc_rt == 'A') {

                $trader_registrations = $this->trader_reg_repo->getByCropYearId_Category($request->bcyc_cy, $request->bcyc_tc);
                $crop_year = $this->cy_repo->findByCropYearId($request->bcyc_cy);

                return view('printables.trader_registration.list_bcyc_a')->with([
                    'trader_registrations' => $trader_registrations,
                    'crop_year' => $crop_year
                ]);
                
            }elseif ($request->bcyc_rt == 'BR') {

                $trader_registrations = $this->trader_reg_repo->getByCropYearId_Category($request->bcyc_cy, $request->bcyc_tc);
                $crop_year = $this->cy_repo->findByCropYearId($request->bcyc_cy);

                return view('printables.trader_registration.list_bcyc_br')->with([
                    'trader_registrations' => $trader_registrations,
                    'crop_year' => $crop_year
                ]);
                
            }
            
        }

        return abort(404);

    }


   
}

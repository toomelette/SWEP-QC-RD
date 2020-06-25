<?php

namespace App\Http\Controllers;

use App\Core\Interfaces\CropYearInterface;
use App\Core\Interfaces\MillRegistrationInterface;
use App\Http\Requests\Mill\MillRenewLicenseFormRequest;
use App\Http\Requests\MillRegistration\MillRegistrationReportRequest;
// use App\Exports\MillRegistrationBDC;
// use App\Exports\MillRegistrationCert;
// use Maatwebsite\Excel\Facades\Excel;



class MillRegistrationController extends Controller{



    protected $mill_reg_repo;
    protected $cy_repo;



    public function __construct(CropYearInterface $cy_repo, 
                                MillRegistrationInterface $mill_reg_repo){
        $this->mill_reg_repo = $mill_reg_repo;
        $this->cy_repo = $cy_repo;
        parent::__construct();
    }
 



    // public function show($slug){

    //     $mill_reg = $this->mill_reg_repo->findbySlug($slug);
    //     return view('dashboard.mill_registration.show')->with('mill_reg', $mill_reg);

    // }




    // public function downloadWordFile($slug){

    //     $mill_reg = $this->mill_reg_repo->findbySlug($slug);
    //     return MillRegistrationCert::cert($mill_reg);

    // }




    public function destroy($slug){

        $mill_reg = $this->mill_reg_repo->destroy($slug);
        $this->event->fire('mill_reg.destroy', $mill_reg);
        return redirect()->back();

    }




    public function update(MillRenewLicenseFormRequest $request, $slug){
        
        $mill_reg = $this->mill_reg_repo->update($request, $slug);

        $this->event->fire('mill.renew_license', [ $mill_reg->mill, $mill_reg ]);
        return redirect()->back();

    }




    // public function reportsOutput(MillRegistrationReportRequest $request){

    //     if ($request->ft == 'bdc') {
            
    //         $mill_registrations = $this->mill_reg_repo->getByRegDate_Category($request->bdc_df, $request->bdc_dt, $request->bdc_tc);
            
    //         if ($request->bdc_t == 'p') {

    //             return view('printables.mill_registration.list_bdc')->with('mill_registrations', $mill_registrations);
                
    //         }elseif ($request->bdc_t == 'e') {

    //             return Excel::download(
    //                 new MillRegistrationBDC($mill_registrations), 'list_by_date_category.xlsx'
    //             );

    //         }

    //     }elseif ($request->ft == 'bcyc') {

    //         if ($request->bcyc_rt == 'A') {

    //             $mill_registrations = $this->mill_reg_repo->getByCropYearId_Category($request->bcyc_cy, $request->bcyc_tc);
    //             $crop_year = $this->cy_repo->findByCropYearId($request->bcyc_cy);

    //             return view('printables.mill_registration.list_bcyc_a')->with([
    //                 'mill_registrations' => $mill_registrations,
    //                 'crop_year' => $crop_year
    //             ]);
                
    //         }elseif ($request->bcyc_rt == 'BR') {

    //             $mill_registrations = $this->mill_reg_repo->getByCropYearId_Category($request->bcyc_cy, $request->bcyc_tc);
    //             $crop_year = $this->cy_repo->findByCropYearId($request->bcyc_cy);

    //             return view('printables.mill_registration.list_bcyc_br')->with([
    //                 'mill_registrations' => $mill_registrations,
    //                 'crop_year' => $crop_year
    //             ]);
                
    //         }
            
    //     }

    //     return abort(404);

    // }




   
}

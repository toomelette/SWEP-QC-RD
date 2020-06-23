<?php

namespace App\Http\Controllers;

use App\Core\Interfaces\CropYearInterface;
use App\Core\Interfaces\TraderRegistrationInterface;
use App\Http\Requests\Trader\TraderRenewLicenseFormRequest;
use App\Http\Requests\TraderRegistration\TraderRegistrationReportRequest;
use App\Exports\TraderRegistrationBDC;
use App\Exports\TraderRegistrationCert;
use Maatwebsite\Excel\Facades\Excel;



class TraderRegistrationController extends Controller{



    protected $trader_reg_repo;
    protected $cy_repo;



    public function __construct(CropYearInterface $cy_repo, 
                                TraderRegistrationInterface $trader_reg_repo){
        $this->trader_reg_repo = $trader_reg_repo;
        $this->cy_repo = $cy_repo;
        parent::__construct();
    }
 



    public function show($slug){

        $trader_reg = $this->trader_reg_repo->findbySlug($slug);
        return view('dashboard.trader_registration.show')->with('trader_reg', $trader_reg);

    }




    public function downloadWordFile($slug){

        $trader_reg = $this->trader_reg_repo->findbySlug($slug);
        return TraderRegistrationCert::cert($trader_reg);

    }




    public function destroy($slug){

        $trader_reg = $this->trader_reg_repo->destroy($slug);
        $this->event->fire('trader_reg.destroy', $trader_reg);
        return redirect()->back();

    }




    public function update(TraderRenewLicenseFormRequest $request, $slug){

        $trader_reg = $this->trader_reg_repo->findBySlug($slug);

        if ($trader_reg->trader_cat_id != $request->trader_cat_id) {

            if ($this->trader_reg_repo->isTraderExistInCY_CAT($request->crop_year_id, $trader_reg->trader_id, $request->trader_cat_id)) {
                
                $this->session->flash('TRADER_REG_IS_EXIST','The Trader is already registered in the current crop year and category!');
                $this->session->flash('TRADER_REG_IS_EXIST_SLUG', $slug);

                $request->flash();
                return redirect()->back();
                
            }
            
        }

        $trader_reg = $this->trader_reg_repo->update($request, $slug);

        $this->event->fire('trader.renew_license', [ $trader_reg->trader, $trader_reg ]);
        return redirect()->back();

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

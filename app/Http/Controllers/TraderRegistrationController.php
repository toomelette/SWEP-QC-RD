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


    public function __construct(TraderRegistrationInterface $trader_reg_repo,
                                CropYearInterface $cy_repo){
        $this->trader_reg_repo = $trader_reg_repo;
        $this->cy_repo = $cy_repo;
        parent::__construct();
    }


    
    public function index(TraderRegistrationFilterRequest $request){

        $trader_registrations = $this->trader_reg_repo->fetch($request);
        $request->flash();
        return view('dashboard.trader_registration.index')->with('trader_registrations', $trader_registrations);

    }

    

    public function create(){
        return view('dashboard.trader_registration.create');
    }

   

    public function store(TraderRegistrationFormRequest $request){

        if ($this->trader_reg_repo->isTraderExistInCY_CAT($request->crop_year_id, $request->trader_id, $request->trader_cat_id)) {
            
            $this->session->flash('TRADER_REG_IS_EXIST','The Trader is already registered in this current Crop year!');
            $request->flash();
            return redirect()->back();

        }

        $trader_reg = $this->trader_reg_repo->store($request);
        
        $this->event->fire('trader_reg.store', $trader_reg);
        return redirect()->back();

    }
 


    public function edit($slug){

        $trader_reg = $this->trader_reg_repo->findbySlug($slug);
        return view('dashboard.trader_registration.edit')->with('trader_reg', $trader_reg);

    }
 


    public function show($slug){

        $trader_reg = $this->trader_reg_repo->findbySlug($slug);
        return view('dashboard.trader_registration.show')->with('trader_reg', $trader_reg);

    }



    public function print($slug){

        $trader_reg = $this->trader_reg_repo->findbySlug($slug);
        return view('printables.trader_registration.license')->with('trader_reg', $trader_reg);

    }



    public function update(TraderRegistrationFormRequest $request, $slug){

        $trader_reg = $this->trader_reg_repo->update($request, $slug);

        $this->event->fire('trader_reg.update', $trader_reg);
        return redirect()->route('dashboard.trader_registration.index');

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

            $page = $request->rt == 'A' ? 'list_bcyc_br' : 'list_bcyc_a';

            $trader_registrations = $this->trader_reg_repo->getByCropYearId_Category($request->bcyc_cy, $request->bcyc_tc);
            $crop_year = $this->cy_repo->findByCropYearId($request->bcyc_cy);

            return view('printables.trader_registration.'.$page.'')->with([
                'trader_registrations' => $trader_registrations,
                'crop_year' => $crop_year
            ]);
            
        }

        return abort(404);

    }


   
}

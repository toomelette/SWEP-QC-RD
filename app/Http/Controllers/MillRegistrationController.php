<?php

namespace App\Http\Controllers;

use App\Core\Interfaces\CropYearInterface;
use App\Core\Interfaces\MillRegistrationInterface;
use App\Http\Requests\Mill\MillRenewLicenseFormRequest;
use App\Http\Requests\MillRegistration\MillRegistrationReportRequest;

use App\Exports\MillRegistrationCover;
use App\Exports\MillRegistrationBilling;
use App\Exports\MillRegistrationLicense;

use App\Exports\MillRegistrationBD;
use App\Exports\MillRegistrationBCY;
use Maatwebsite\Excel\Facades\Excel;



class MillRegistrationController extends Controller{



    protected $mill_reg_repo;
    protected $cy_repo;



    public function __construct(CropYearInterface $cy_repo, MillRegistrationInterface $mill_reg_repo){
        $this->mill_reg_repo = $mill_reg_repo;
        $this->cy_repo = $cy_repo;
        parent::__construct();
    }
 



    public function show($slug){

        $mill_reg = $this->mill_reg_repo->findbySlug($slug);
        return view('dashboard.mill_registration.show')->with('mill_reg', $mill_reg);

    }




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




    public function downloadCoverLetter($slug){

        $mill_reg = $this->mill_reg_repo->findbySlug($slug);
        return MillRegistrationCover::coverLetter($mill_reg);

    }




    public function downloadBillingStatement($slug){

        $mill_reg = $this->mill_reg_repo->findbySlug($slug);
        return MillRegistrationBilling::billingStatement($mill_reg);

    }




    public function downloadLicense($slug){

        $mill_reg = $this->mill_reg_repo->findbySlug($slug);
        return MillRegistrationLicense::license($mill_reg);

    }




    public function reportsOutput(MillRegistrationReportRequest $request){

        if ($request->ft == 'md') {

            $mill_registrations = $this->mill_reg_repo->getByCropYearId($request->md_cy);
            $crop_year = $this->cy_repo->findByCropYearId($request->md_cy);

            return view('printables.mill_registration.mill_directory')->with([
                'mill_registrations' => $mill_registrations,
                'crop_year' => $crop_year 
            ]);

        }elseif ($request->ft == 'rc') {

            $mill_registrations = $this->mill_reg_repo->getByCropYearId($request->rc_cy);
            $crop_year = $this->cy_repo->findByCropYearId($request->rc_cy);

            return view('printables.mill_registration.mill_rated_capacity')->with([
                'mill_registrations' => $mill_registrations,
                'crop_year' => $crop_year 
            ]);
            
        }elseif ($request->ft == 'mp') {

            $mill_registrations = $this->mill_reg_repo->getByCropYearId($request->mp_cy);
            $crop_year = $this->cy_repo->findByCropYearId($request->mp_cy);

            return view('printables.mill_registration.mill_participation')->with([
                'mill_registrations' => $mill_registrations,
                'crop_year' => $crop_year 
            ]);
            
        }elseif ($request->ft == 'cbcy') {

            $mill_registrations = $this->mill_reg_repo->getByCropYearId($request->cbcy_cy);
            $crop_year = $this->cy_repo->findByCropYearId($request->cbcy_cy);

            return view('printables.mill_registration.count_by_cropyear')->with([
                'mill_registrations' => $mill_registrations,
                'crop_year' => $crop_year
            ]);
            
        }elseif ($request->ft == 'bd') {

            $mill_registrations = $this->mill_reg_repo->getByRegDate($request->bd_df, $request->bd_dt);
            return Excel::download(new MillRegistrationBD($mill_registrations), 'mills_by_date.xlsx');
            
        }elseif ($request->ft == 'bcy') {

            $mill_registrations = $this->mill_reg_repo->getByCropYearId($request->bcy_cy);
            return Excel::download(new MillRegistrationBCY($mill_registrations), 'mills_by_crop_year.xlsx');
            
        }

        return abort(404);

    }




   
}

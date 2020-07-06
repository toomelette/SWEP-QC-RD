<?php

namespace App\Http\Controllers;

use App\Core\Interfaces\CropYearInterface;
use App\Core\Interfaces\RefineryRegistrationInterface;
use App\Http\Requests\Refinery\RefineryRenewLicenseFormRequest;
use App\Http\Requests\RefineryRegistration\RefineryRegistrationReportRequest;

use App\Exports\RefineryRegistrationCover;
use App\Exports\RefineryRegistrationLicense;

use App\Exports\RefineryRegistrationBD;
use App\Exports\RefineryRegistrationBCY;
use Maatwebsite\Excel\Facades\Excel;



class RefineryRegistrationController extends Controller{



    protected $cy_repo;



    public function __construct(RefineryRegistrationInterface $refinery_reg_repo){
        $this->refinery_reg_repo = $refinery_reg_repo;
        parent::__construct();
    }
 



    public function show($slug){

        $refinery_reg = $this->refinery_reg_repo->findbySlug($slug);
        return view('dashboard.refinery_registration.show')->with('refinery_reg', $refinery_reg);

    }




    public function downloadCoverLetter($slug){

        $refinery_reg = $this->refinery_reg_repo->findbySlug($slug);
        return RefineryRegistrationCover::coverLetter($refinery_reg);

    }




    public function downloadLicense($slug){

        $refinery_reg = $this->refinery_reg_repo->findbySlug($slug);
        return RefineryRegistrationLicense::license($refinery_reg);

    }




    public function destroy($slug){

        $refinery_reg = $this->refinery_reg_repo->destroy($slug);
        $this->event->fire('refinery_reg.destroy', $refinery_reg);
        return redirect()->back();

    }




    public function update(RefineryRenewLicenseFormRequest $request, $slug){
        
        $refinery_reg = $this->refinery_reg_repo->update($request, $slug);

        $this->event->fire('refinery.renew_license', [ $refinery_reg->refinery, $refinery_reg ]);
        return redirect()->back();

    }




    public function reportsOutput(RefineryRegistrationReportRequest $request){

        if ($request->ft == 'bd') {

            $refinery_registrations = $this->refinery_reg_repo->getByRegDate($request->bd_df, $request->bd_dt);
            return Excel::download(new RefineryRegistrationBD($refinery_registrations), 'refinery_by_date.xlsx');

        }elseif ($request->ft == 'bcy') {

            $refinery_registrations = $this->refinery_reg_repo->getByCropYearId($request->bcy_cy);
            return Excel::download(new RefineryRegistrationBCY($refinery_registrations), 'refinery_by_crop_year.xlsx');
            
        }

        return abort(404);

    }




   
}
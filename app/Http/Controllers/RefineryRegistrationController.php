<?php

namespace App\Http\Controllers;

use App\Core\Interfaces\CropYearInterface;
use App\Core\Interfaces\RefineryRegistrationInterface;
use App\Http\Requests\Refinery\RefineryRenewLicenseFormRequest;

// use App\Exports\RefineryRegistrationBDC;
// use App\Exports\RefineryRegistrationCert;



class RefineryRegistrationController extends Controller{



    protected $cy_repo;



    public function __construct(RefineryRegistrationInterface $refinery_reg_repo){
        $this->refinery_reg_repo = $refinery_reg_repo;
        parent::__construct();
    }
 



    // public function show($slug){

    //     $refinery_reg = $this->refinery_reg_repo->findbySlug($slug);
    //     return view('dashboard.refinery_registration.show')->with('refinery_reg', $refinery_reg);

    // }




    // public function downloadWordFile($slug){

    //     $refinery_reg = $this->refinery_reg_repo->findbySlug($slug);
    //     return RefineryRegistrationCert::cert($refinery_reg);

    // }




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




   
}

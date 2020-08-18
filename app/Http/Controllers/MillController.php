<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\MillInterface;
use App\Core\Interfaces\MillRegistrationInterface;
use App\Core\Interfaces\MillFileInterface;
use App\Http\Requests\Mill\MillFormRequest;
use App\Http\Requests\Mill\MillFilterRequest;
use App\Http\Requests\Mill\MillRenewLicenseFormRequest;
use App\Http\Requests\Mill\MillRenewalHistoryFilterRequest;
use App\Http\Requests\MillFile\MillFileFilterRequest;


class MillController extends Controller{



    protected $mill_repo;
    protected $mill_reg_repo;
    protected $mill_file_repo;



    public function __construct(MillInterface $mill_repo, 
                                MillRegistrationInterface $mill_reg_repo,
                                MillFileInterface $mill_file_repo){
        $this->mill_repo = $mill_repo;
        $this->mill_reg_repo = $mill_reg_repo;
        $this->mill_file_repo = $mill_file_repo;
        parent::__construct();
    }



    
    public function index(MillFilterRequest $request){

        $mills = $this->mill_repo->fetch($request);
        $request->flash();
        return view('dashboard.mill.index')->with('mills', $mills);

    }

    


    public function create(){
        return view('dashboard.mill.create');
    }


   

    public function store(MillFormRequest $request){

        $mill = $this->mill_repo->store($request);
        
        $this->event->fire('mill.store');
        return redirect()->back();

    }
 



    public function edit($slug){

        $mill = $this->mill_repo->findbySlug($slug);
        return view('dashboard.mill.edit')->with('mill', $mill);

    }




    public function update(MillFormRequest $request, $slug){

        $mill = $this->mill_repo->update($request, $slug);

        $this->event->fire('mill.update', $mill);
        return redirect()->route('dashboard.mill.index');

    }

    


    public function destroy($slug){

        $mill = $this->mill_repo->destroy($slug);
        $this->event->fire('mill.destroy', $mill);
        return redirect()->back();

    }

    


    public function renewLicensePost($slug, MillRenewLicenseFormRequest $request){

        $mill = $this->mill_repo->findbySlug($slug);

        if ($request->ft == 'rl') {
            if ($this->mill_reg_repo->isLicenseExistInCY($request->crop_year_id, $mill->mill_id)) {
                $this->session->flash('LICENSE_IS_EXIST','The Mill License is already added in the current crop year');
                $this->session->flash('LICENSE_IS_EXIST_SLUG', $slug);
                $request->flash();
                return redirect()->back();
            }
        }

        if ($request->ft == 'bs') {
            if ($this->mill_reg_repo->isBillingExistInCY($request->crop_year_id, $mill->mill_id)) {
                $this->session->flash('BILLING_IS_EXIST','The Billing Statement is already added in the current crop year');
                $this->session->flash('BILLING_IS_EXIST_SLUG', $slug);
                $request->flash();
                return redirect()->back();
            } 
        }

        if ($request->ft == 'ce') {
            if ($this->mill_reg_repo->isCropEstExistInCY($request->crop_year_id, $mill->mill_id)) {
                $this->session->flash('CROP_EST_IS_EXIST','The Crop Estimate is already added in the current crop year');
                $this->session->flash('CROP_EST_IS_EXIST_SLUG', $slug);
                $request->flash();
                return redirect()->back();
            }
        }

        if (!$this->mill_reg_repo->isExistInCY($request->crop_year_id, $mill->mill_id)) {
            $mill_reg = $this->mill_reg_repo->store($request, $mill);
        }else{
            $mill_reg = $this->mill_reg_repo->updateOnRenew($request, $mill);
        }

        $this->event->fire('mill.renew_license', [ $mill, $mill_reg, $request ]);
        return redirect()->back();

    }

    


    public function renewalHistory($slug, MillRenewalHistoryFilterRequest $request){

        $mill = $this->mill_repo->findbySlug($slug);
        $mill_reg_list = $this->mill_reg_repo->fetchByMillId($request, $mill->mill_id);

        $request->flash();
        return view('dashboard.mill.renewal_history')->with([
            'mill_reg_list' => $mill_reg_list,
            'mill' => $mill
        ]);

    }

    


    public function files($slug, MillFileFilterRequest $request){

        $mill = $this->mill_repo->findbySlug($slug);
        $mill_file_list = $this->mill_file_repo->fetchByMillId($request, $mill->mill_id);

        $request->flash();
        
        return view('dashboard.mill_file.index')->with([
            'mill_file_list' => $mill_file_list,
            'mill' => $mill,
        ]);

    }




    public function reports(){
        return view('dashboard.mill.reports');
    }


    
}

<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\RefineryInterface;
use App\Core\Interfaces\RefineryRegistrationInterface;
use App\Core\Interfaces\RefineryFileInterface;
use App\Http\Requests\Refinery\RefineryFormRequest;
use App\Http\Requests\Refinery\RefineryFilterRequest;
use App\Http\Requests\Refinery\RefineryRenewLicenseFormRequest;
use App\Http\Requests\Refinery\RefineryRenewalHistoryFilterRequest;
use App\Http\Requests\RefineryFile\RefineryFileFilterRequest;


class RefineryController extends Controller{



    protected $refinery_repo;
    protected $refinery_reg_repo;
    protected $refinery_file_repo;


    public function __construct(RefineryInterface $refinery_repo, 
                                RefineryRegistrationInterface $refinery_reg_repo,
                                RefineryFileInterface $refinery_file_repo){
        $this->refinery_repo = $refinery_repo;
        $this->refinery_reg_repo = $refinery_reg_repo;
        $this->refinery_file_repo = $refinery_file_repo;
        parent::__construct();
    }




    
    public function index(RefineryFilterRequest $request){

        $refineries = $this->refinery_repo->fetch($request);
        $request->flash();
        return view('dashboard.refinery.index')->with('refineries', $refineries);

    }

    


    public function create(){
        return view('dashboard.refinery.create');
    }


   

    public function store(RefineryFormRequest $request){

        $refinery = $this->refinery_repo->store($request);
        
        $this->event->fire('refinery.store');
        return redirect()->back();

    }
 



    public function edit($slug){

        $refinery = $this->refinery_repo->findbySlug($slug);
        return view('dashboard.refinery.edit')->with('refinery', $refinery);

    }




    public function update(RefineryFormRequest $request, $slug){

        $refinery = $this->refinery_repo->update($request, $slug);

        $this->event->fire('refinery.update', $refinery);
        return redirect()->route('dashboard.refinery.index');

    }

    


    public function destroy($slug){

        $refinery = $this->refinery_repo->destroy($slug);
        $this->event->fire('refinery.destroy', $refinery);
        return redirect()->back();

    }

    


    public function renewLicensePost($slug, RefineryRenewLicenseFormRequest $request){

        $refinery = $this->refinery_repo->findbySlug($slug);

        if ($request->ft == 'rl') {
            if ($this->refinery_reg_repo->isLicenseExistInCY($request->crop_year_id, $refinery->refinery_id)) {
                $this->session->flash('LICENSE_IS_EXIST','The Refinery License is already added in the current crop year');
                $this->session->flash('LICENSE_IS_EXIST_SLUG', $slug);
                $request->flash();
                return redirect()->back();
            }
        }

        if ($request->ft == 'rc') {
            if ($this->refinery_reg_repo->isRatedCapacityExistInCY($request->crop_year_id, $refinery->refinery_id)) {
                $this->session->flash('RATED_CAPACITY_IS_EXIST','The Refinery Rated Capacity is already added in the current crop year');
                $this->session->flash('RATED_CAPACITY_IS_EXIST_SLUG', $slug);
                $request->flash();
                return redirect()->back();
            }
        }

        if (!$this->refinery_reg_repo->isExistInCY($request->crop_year_id, $refinery->refinery_id)) {
            $refinery_reg = $this->refinery_reg_repo->store($request, $refinery);
        }else{
            $refinery_reg = $this->refinery_reg_repo->updateOnRenew($request, $refinery);
        }

        $this->event->fire('refinery.renew_license', [ $refinery, $refinery_reg, $request ]);
        return redirect()->back();

    }

    


    public function renewalHistory($slug, RefineryRenewalHistoryFilterRequest $request){

        $refinery = $this->refinery_repo->findbySlug($slug);
        $refinery_reg_list = $this->refinery_reg_repo->fetchByRefineryId($request, $refinery->refinery_id);

        $request->flash();
        return view('dashboard.refinery.renewal_history')->with([
            'refinery_reg_list' => $refinery_reg_list,
            'refinery' => $refinery,
        ]);

    }

    


    public function files($slug, RefineryFileFilterRequest $request){

        $refinery = $this->refinery_repo->findbySlug($slug);
        $refinery_file_list = $this->refinery_file_repo->fetchByRefineryId($request, $refinery->refinery_id);

        $request->flash();
        
        return view('dashboard.refinery_file.index')->with([
            'refinery_file_list' => $refinery_file_list,
            'refinery' => $refinery,
        ]);

    }




    public function reports(){
        return view('dashboard.refinery.reports');
    }


    
}

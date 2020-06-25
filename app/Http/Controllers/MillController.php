<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\MillInterface;
use App\Core\Interfaces\MillRegistrationInterface;
use App\Http\Requests\Mill\MillFormRequest;
use App\Http\Requests\Mill\MillFilterRequest;
use App\Http\Requests\Mill\MillRenewLicenseFormRequest;
use App\Http\Requests\Mill\MillRenewalHistoryFilterRequest;


class MillController extends Controller{



    protected $mill_repo;
    protected $mill_reg_repo;


    public function __construct(MillInterface $mill_repo, MillRegistrationInterface $mill_reg_repo){
        $this->mill_repo = $mill_repo;
        $this->mill_reg_repo = $mill_reg_repo;
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

        if ($this->mill_reg_repo->isMillExistInCY($request->crop_year_id, $mill->mill_id)) {
            
            $this->session->flash('MILL_REG_IS_EXIST','The Mill is already registered in the current crop year and category!');
            $this->session->flash('MILL_REG_IS_EXIST_SLUG', $slug);

            $request->flash();
            return redirect()->back();
            
        }

        $mill_reg = $this->mill_reg_repo->store($request, $mill);

        $this->event->fire('mill.renew_license', [ $mill, $mill_reg ]);
        return redirect()->back();

    }

    


    public function renewalHistory($slug, MillRenewalHistoryFilterRequest $request){

        $mill = $this->mill_repo->findbySlug($slug);
        $mill_reg_list = $this->mill_reg_repo->fetchByMillId($request, $mill->mill_id);

        $request->flash();
        return view('dashboard.mill.renewal_history')->with('mill_reg_list', $mill_reg_list);

    }




    // public function reports(){
    //     return view('dashboard.mill.reports');
    // }


    
}

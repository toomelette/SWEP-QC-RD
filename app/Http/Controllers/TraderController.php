<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\TraderInterface;
use App\Core\Interfaces\TraderRegistrationInterface;
use App\Core\Interfaces\TraderFileInterface;
use App\Http\Requests\Trader\TraderFormRequest;
use App\Http\Requests\Trader\TraderFilterRequest;
use App\Http\Requests\Trader\TraderRenewLicenseFormRequest;
use App\Http\Requests\Trader\TraderRenewalHistoryFilterRequest;
use App\Http\Requests\TraderFile\TraderFileFilterRequest;


class TraderController extends Controller{



    protected $trader_repo;
    protected $trader_reg_repo;
    protected $trader_file_repo;



    public function __construct(TraderInterface $trader_repo, 
                                TraderRegistrationInterface $trader_reg_repo, 
                                TraderFileInterface $trader_file_repo){
        $this->trader_repo = $trader_repo;
        $this->trader_reg_repo = $trader_reg_repo;
        $this->trader_file_repo = $trader_file_repo;
        parent::__construct();
    }




    
    public function index(TraderFilterRequest $request){

        $traders = $this->trader_repo->fetch($request);
        $request->flash();
        return view('dashboard.trader.index')->with('traders', $traders);

    }

    


    public function create(){
        return view('dashboard.trader.create');
    }


   

    public function store(TraderFormRequest $request){

        $trader = $this->trader_repo->store($request);
        
        $this->event->fire('trader.store');
        return redirect()->back();

    }
 



    public function edit($slug){

        $trader = $this->trader_repo->findbySlug($slug);
        return view('dashboard.trader.edit')->with('trader', $trader);

    }




    public function update(TraderFormRequest $request, $slug){

        $trader = $this->trader_repo->update($request, $slug);

        $this->event->fire('trader.update', $trader);
        return redirect()->route('dashboard.trader.index');

    }

    


    public function destroy($slug){

        $trader = $this->trader_repo->destroy($slug);
        $this->event->fire('trader.destroy', $trader);
        return redirect()->back();

    }

    


    public function renewLicensePost($slug, TraderRenewLicenseFormRequest $request){

        $trader = $this->trader_repo->findbySlug($slug);

        if ($this->trader_reg_repo->isTraderExistInCY_CAT($request->crop_year_id, $trader->trader_id, $request->trader_cat_id)) {
            
            $this->session->flash('TRADER_REG_IS_EXIST','The Trader is already registered in the current crop year and category!');
            $this->session->flash('TRADER_REG_IS_EXIST_SLUG', $slug);

            $request->flash();
            return redirect()->back();
            
        }

        $trader_reg = $this->trader_reg_repo->store($request, $trader);

        $this->event->fire('trader.renew_license', [ $trader, $trader_reg ]);
        return redirect()->back();

    }

    


    public function renewalHistory($slug, TraderRenewalHistoryFilterRequest $request){

        $trader = $this->trader_repo->findbySlug($slug);
        $trader_reg_list = $this->trader_reg_repo->fetchByTraderId($request, $trader->trader_id);

        $request->flash();
        return view('dashboard.trader.renewal_history')->with([
            'trader_reg_list' => $trader_reg_list,
            'trader' => $trader,
        ]);

    }

    


    public function files($slug, TraderFileFilterRequest $request){

        $trader = $this->trader_repo->findbySlug($slug);
        $trader_file_list = $this->trader_file_repo->fetchByTraderId($request, $trader->trader_id);

        $request->flash();
        
        return view('dashboard.trader_file.index')->with([
            'trader_file_list' => $trader_file_list,
            'trader' => $trader,
        ]);

    }




    public function reports(){
        return view('dashboard.trader.reports');
    }



    
}

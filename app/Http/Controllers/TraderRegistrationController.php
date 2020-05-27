<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\TraderRegistrationInterface;
use App\Http\Requests\TraderRegistration\TraderRegistrationFormRequest;
use App\Http\Requests\TraderRegistration\TraderRegistrationFilterRequest;


class TraderRegistrationController extends Controller{


    protected $trader_reg_repo;


    public function __construct(TraderRegistrationInterface $trader_reg_repo){
        $this->trader_reg_repo = $trader_reg_repo;
        parent::__construct();
    }




    
    // public function index(TraderRegistrationFilterRequest $request){

    //     $trader_registrations = $this->trader_reg_repo->fetch($request);
    //     $request->flash();
    //     return view('dashboard.trader_registration.index')->with('trader_registrations', $trader_registrations);

    // }

    


    public function create(){
        return view('dashboard.trader_registration.create');
    }


   

    public function store(TraderRegistrationFormRequest $request){

        $trader = $this->trader_reg_repo->store($request);
        
        $this->event->fire('trader_reg.store');
        return redirect()->back();

    }
 



    // public function edit($slug){

    //     $trader = $this->trader_reg_repo->findbySlug($slug);
    //     return view('dashboard.trader_registration.edit')->with('trader', $trader);

    // }




    // public function update(TraderRegistrationFormRequest $request, $slug){

    //     $trader = $this->trader_reg_repo->update($request, $slug);

    //     $this->event->fire('trader.update', $trader);
    //     return redirect()->route('dashboard.trader_registration.index');

    // }

    


    // public function destroy($slug){

    //     $trader = $this->trader_reg_repo->destroy($slug);
    //     $this->event->fire('trader.destroy', $trader);
    //     return redirect()->back();

    // }



    
}

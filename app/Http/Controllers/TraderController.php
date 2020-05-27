<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\TraderInterface;
use App\Http\Requests\Trader\TraderFormRequest;
use App\Http\Requests\Trader\TraderFilterRequest;


class TraderController extends Controller{


    protected $trader_repo;


    public function __construct(TraderInterface $trader_repo){
        $this->trader_repo = $trader_repo;
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



    
}

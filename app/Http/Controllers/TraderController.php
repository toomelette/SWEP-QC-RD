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




    
    // public function index(TraderFilterRequest $request){

    //     $traders = $this->trader_repo->fetch($request);
    //     $request->flash();
    //     return view('dashboard.menu.index')->with('traders', $traders);

    // }

    


    public function create(){
        return view('dashboard.trader.create');
    }


   

    // public function store(TraderFormRequest $request){

    //     $menu = $this->trader_repo->store($request);

    //     if(!empty($request->row)){
    //         foreach ($request->row as $row) {
    //             $submenu = $this->trader_repo->store($row, $menu);
    //         }
    //     }
        
    //     $this->event->fire('menu.store');
    //     return redirect()->back();

    // }
 



    // public function edit($slug){

    //     $menu = $this->trader_repo->findbySlug($slug);
    //     return view('dashboard.menu.edit')->with('menu', $menu);

    // }




    // public function update(TraderFormRequest $request, $slug){

    //     $menu = $this->trader_repo->update($request, $slug);

    //     if(!empty($request->row)){
    //         foreach ($request->row as $row) {
    //             $submenu = $this->trader_repo->store($row, $menu);
    //         }
    //     }

    //     $this->event->fire('menu.update', $menu);
    //     return redirect()->route('dashboard.menu.index');

    // }

    


    // public function destroy($slug){

    //     $menu = $this->trader_repo->destroy($slug);
    //     $this->event->fire('menu.destroy', $menu);
    //     return redirect()->back();

    // }



    
}

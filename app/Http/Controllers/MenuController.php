<?php

namespace App\Http\Controllers;


use App\Core\Interfaces\MenuInterface;
use App\Core\Interfaces\SubmenuInterface;
use App\Http\Requests\Menu\MenuFormRequest;
use App\Http\Requests\Menu\MenuFilterRequest;


class MenuController extends Controller{


    protected $menu_repo;
    protected $submenu_repo;


    public function __construct(MenuInterface $menu_repo, SubmenuInterface $submenu_repo){
        $this->menu_repo = $menu_repo;
        $this->submenu_repo = $submenu_repo;
        parent::__construct();
    }




    
    public function index(MenuFilterRequest $request){

        $menus = $this->menu_repo->fetch($request);
        $request->flash();
        return view('dashboard.menu.index')->with('menus', $menus);

    }

    


    public function create(){
        return view('dashboard.menu.create');
    }


   

    public function store(MenuFormRequest $request){

        $menu = $this->menu_repo->store($request);

        if(!empty($request->row)){
            foreach ($request->row as $row) {
                $submenu = $this->submenu_repo->store($row, $menu);
            }
        }
        
        $this->event->fire('menu.store');
        return redirect()->back();

    }
 



    public function edit($slug){

        $menu = $this->menu_repo->findbySlug($slug);
        return view('dashboard.menu.edit')->with('menu', $menu);

    }




    public function update(MenuFormRequest $request, $slug){

        $menu = $this->menu_repo->update($request, $slug);

        if(!empty($request->row)){
            foreach ($request->row as $row) {
                $submenu = $this->submenu_repo->store($row, $menu);
            }
        }

        $this->event->fire('menu.update', $menu);
        return redirect()->route('dashboard.menu.index');

    }

    


    public function destroy($slug){

        $menu = $this->menu_repo->destroy($slug);
        $this->event->fire('menu.destroy', $menu);
        return redirect()->back();

    }



    
}

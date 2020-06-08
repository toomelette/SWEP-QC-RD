<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;


use App\Core\Interfaces\TraderInterface;
use Illuminate\Http\Request;


class ApiTraderController extends Controller{


	protected $trader_repo;


	public function __construct(TraderInterface $trader_repo){
		$this->trader_repo = $trader_repo;
	}


	public function selectTraderByTraderId(Request $request, $trader_id){

    	if($request->Ajax()){
    		$response_trader = $this->trader_repo->getByTraderId($trader_id);
	    	return json_encode($response_trader);
	    }

	    return abort(404);

    }


    
}

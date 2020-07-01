<?php

namespace App\Core\Interfaces;
 


interface TraderFileInterface {

	public function fetchByTraderId($request, $trader_id);

	// public function store($request, $trader);

	// public function update($request, $slug);

	// public function destroy($slug);

	// public function findBySlug($slug);
		
}
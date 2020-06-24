<?php

namespace App\Core\Interfaces;
 


interface MillInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);

	// public function getByTraderId($trader_id);

	// public function getAll();
		
}
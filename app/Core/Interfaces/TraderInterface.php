<?php

namespace App\Core\Interfaces;
 


interface TraderInterface {

	public function fetch($request);

	public function store($request);

	public function storeFromTR($request);

	public function update($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);

	public function getByTraderId($trader_id);

	public function getAll();
		
}
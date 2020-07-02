<?php

namespace App\Core\Interfaces;
 


interface TraderFileInterface {

	public function fetchByTraderId($request, $trader_id);

	public function store($trader_id, $filename, $file_location);

	public function update($filename, $file_location, $slug);

	public function destroy($trader_file);

	public function findBySlug($slug);
		
}
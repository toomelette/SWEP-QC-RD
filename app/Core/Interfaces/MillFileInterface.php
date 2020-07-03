<?php

namespace App\Core\Interfaces;
 


interface MillFileInterface {

	public function fetchByMillId($request, $mill_id);

	public function store($mill_id, $filename, $file_location);

	public function update($filename, $file_location, $slug);

	public function destroy($mill_file);

	public function findBySlug($slug);
		
}
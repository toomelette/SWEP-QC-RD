<?php

namespace App\Core\Interfaces;
 


interface RefineryFileInterface {

	public function fetchByRefineryId($request, $refinery_id);

	public function store($refinery_id, $filename, $file_location);

	public function update($filename, $file_location, $slug);

	public function destroy($refinery_file);

	public function findBySlug($slug);
		
}
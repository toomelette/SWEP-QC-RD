<?php

namespace App\Core\Interfaces;
 


interface RefineryRegistrationInterface {

	public function fetchByRefineryId($request, $refinery_id);

	public function store($request, $refinery);

	public function update($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);

	public function isRefineryExistInCY($crop_year_id, $refinery_id);

	// public function getByRegDate_Category($df, $dt, $tc_id);

	// public function getByCropYearId_Category($cy_id, $tc_id);
		
}
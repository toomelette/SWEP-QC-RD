<?php

namespace App\Core\Interfaces;
 


interface RefineryRegistrationInterface {

	public function fetchByRefineryId($request, $refinery_id);

	public function store($request, $refinery);

	public function update($request, $slug);

	public function updateOnRenew($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);

	public function isExistInCY($crop_year_id, $refinery_id);

	public function isLicenseExistInCY($crop_year_id, $refinery_id);

	public function isRatedCapacityExistInCY($crop_year_id, $refinery_id);

	public function getByRegDate($df, $dt);

	public function getByCropYearId($cy_id);
		
}
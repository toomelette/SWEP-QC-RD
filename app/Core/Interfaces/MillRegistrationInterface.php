<?php

namespace App\Core\Interfaces;
 


interface MillRegistrationInterface {

	public function fetchByMillId($request, $trader_id);

	public function store($request, $mill);

	public function updateOnRenew($request, $mill);

	public function update($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);
	
	public function isExistInCY($crop_year_id, $mill_id);

	public function isLicenseExistInCY($crop_year_id, $mill_id);
	
	public function isBillingExistInCY($crop_year_id, $mill_id);
	
	public function isCropEstExistInCY($crop_year_id, $mill_id);

	public function getByRegDate($df, $dt);

	public function getByCropYearId($cy_id);
		
}
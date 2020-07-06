<?php

namespace App\Core\Interfaces;
 


interface MillRegistrationInterface {

	public function fetchByMillId($request, $trader_id);

	public function store($request, $trader);

	public function update($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);

	public function isMillExistInCY($crop_year_id, $mill_id);

	public function getByRegDate($df, $dt);

	public function getByCropYearId($cy_id);
		
}
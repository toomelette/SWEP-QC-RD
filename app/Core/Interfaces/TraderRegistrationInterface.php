<?php

namespace App\Core\Interfaces;
 


interface TraderRegistrationInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);

	public function isTraderExistInCY_CAT($crop_year_id, $trader_id, $trader_cat_id);

	public function getByRegDate_Category($df, $dt, $tc_id);

	public function getByCropYearId_Category($cy_id, $tc_id);
		
}
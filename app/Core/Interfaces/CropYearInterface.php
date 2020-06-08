<?php

namespace App\Core\Interfaces;
 


interface CropYearInterface {

	public function getAll();

	public function findByCropYearId($cy_id);
		
}
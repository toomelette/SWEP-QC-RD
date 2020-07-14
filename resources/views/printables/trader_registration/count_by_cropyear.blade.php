<?php
  
  function countByRegionAndCat($trader_registrations, $region_id, $cat_id){

    $count = 0;

    foreach ($trader_registrations as $data) {
      if (!empty($data->trader)) {
        if ($data->trader->region_id == $region_id && $data->trader_cat_id == $cat_id) {
          $count++;
        }
      }
    }

    return $count;

  }
  


  function countByRegion($trader_registrations, $region_id){

    $count = 0;

    foreach ($trader_registrations as $data) {
      if (!empty($data->trader)) {
        if ($data->trader->region_id == $region_id) {
          $count++;
        }
      }
    }

    return $count;

  }
  


  function countByCat($trader_registrations, $cat_id){

    $trader_registrations_array = $trader_registrations->pluck('trader_cat_id')->toArray();
    $count = 0;

    foreach ($trader_registrations as $data) {
      if ($data->trader_cat_id == $cat_id) {
        $count++;
      }
    }

    return $count;

  }



?>

<!DOCTYPE html>
<html>

<head>
	<title>Count Traders by Crop Year</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">
  <style type="text/css">
    @page  
      { 
        size: auto;
        margin-top: 50mm;
        margin-bottom: 30mm;  
      } 
  </style>
</head>

<body onload="window.print();" onafterprint="window.close()" style="font-size: 11px;">

<section class="invoice">

  {{-- HEADER --}}
  <div class="row" style="padding:10px; margin-bottom:10px;">
    <div class="col-xs-12" style="text-align: center;">
      <span style="font-size: 14px;">Number of Registered Traders per Region and Category</span><br>
      <span style="font-size: 14px;">CROP YEAR {{ $crop_year->name }}</span>
    </div>
  </div>

  <div class="row" id="content">
    <div class="col-xs-12 table-responsive">

      <table class="table table-bordered">

        <thead>
          <tr>
            <th style="width:100px;">Region</td>
            <th style="text-align:center;">Sugar Trader (Domestic)</td>
            <th style="text-align:center;">Sugar Trader (International)</td>
            <th style="text-align:center;">Molasses (Domestic)</td>
            <th style="text-align:center;">Molasses (International)</td>
            <th style="text-align:center;">Muscovado</td>
            <th style="text-align:center;">HFCS</td>
            <th style="text-align:center;">TOTAL</td>
          </tr>
        </thead>

        <tbody>

          <?php 
            $subtotal_std = 0;
            $subtotal_sti = 0;
            $subtotal_md = 0;
            $subtotal_mi = 0;
            $subtotal_mus = 0;
            $subtotal_hfcs = 0;
          ?>

          @foreach($global_regions_all as $region_data)

            <tr>
              <td>
                {{ $region_data->name }}
              </td>
              <td style="text-align:center;">
                {{ countByRegionAndCat($trader_registrations, $region_data->region_id, 'TC1001') }}
              </td>
              <td style="text-align:center;">
                {{ countByRegionAndCat($trader_registrations, $region_data->region_id, 'TC1002') }}
              </td>
              <td style="text-align:center;">
                {{ countByRegionAndCat($trader_registrations, $region_data->region_id, 'TC1003') }}
              </td>
              <td style="text-align:center;">
                {{ countByRegionAndCat($trader_registrations, $region_data->region_id, 'TC1004') }}
              </td>
              <td style="text-align:center;">
                {{ countByRegionAndCat($trader_registrations, $region_data->region_id, 'TC1005') }}
              </td>
              <td style="text-align:center;">
                {{ countByRegionAndCat($trader_registrations, $region_data->region_id, 'TC1006') }}
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ countByRegion($trader_registrations, $region_data->region_id) }}
              </td>
            </tr>

          @endforeach

            <tr>
              <td>
                TOTAL
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ countByCat($trader_registrations, 'TC1001') }}
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ countByCat($trader_registrations, 'TC1002') }}
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ countByCat($trader_registrations, 'TC1003') }}
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ countByCat($trader_registrations, 'TC1004') }}
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ countByCat($trader_registrations, 'TC1005') }}
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ countByCat($trader_registrations, 'TC1006') }}
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ $trader_registrations->count() }}
              </td>
            </tr>

        </tbody>

      </table>

    </div>

  </div>

</section>

</body>

</html>
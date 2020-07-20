<?php
  
  $date_from = substr($crop_year->name, 0, 4) .'-08-01';
  $date_to = substr($crop_year->name, -4) .'-08-31';

  $months = __dynamic::months_between_dates($date_from, $date_to);



  function countByMonthYearAndCat($trader_registrations, $my, $cat_id){

    $count = 0;
    foreach ($trader_registrations as $data) {
      $data_my = __dataType::date_parse($data->reg_date, 'm-Y');
      if ($data_my == $my && $data->trader_cat_id == $cat_id) {
        $count++;
      }
    }

    return $count;

  }
  


  function countByMonthYear($trader_registrations, $my){

    $count = 0;

    foreach ($trader_registrations as $data) {
      $data_my = __dataType::date_parse($data->reg_date, 'm-Y');
      if ($data_my == $my) {
        $count++;
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
	<title>Number of Registered Traders per Month and Category</title>
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
      <span style="font-size: 14px;">Number of Registered Traders per Month and Category</span><br>
      <span style="font-size: 14px;">CROP YEAR {{ $crop_year->name }}</span>
    </div>
  </div>

  <div class="row" id="content">
    <div class="col-xs-12 table-responsive">

      <table class="table table-bordered">

        <thead>
          <tr>
            <th style="width:100px;">Month</td>
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

          @foreach($months as $key => $data)

            <tr>
              <td>
                {{ $data }}
              </td>
              <td style="text-align:center;">
                {{ countByMonthYearAndCat($trader_registrations, $key, 'TC1001') }}
              </td>
              <td style="text-align:center;">
                {{ countByMonthYearAndCat($trader_registrations, $key, 'TC1002') }}
              </td>
              <td style="text-align:center;">
                {{ countByMonthYearAndCat($trader_registrations, $key, 'TC1003') }}
              </td>
              <td style="text-align:center;">
                {{ countByMonthYearAndCat($trader_registrations, $key, 'TC1004') }}
              </td>
              <td style="text-align:center;">
                {{ countByMonthYearAndCat($trader_registrations, $key, 'TC1005') }}
              </td>
              <td style="text-align:center;">
                {{ countByMonthYearAndCat($trader_registrations, $key, 'TC1006') }}
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ countByMonthYear($trader_registrations, $key) }}
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
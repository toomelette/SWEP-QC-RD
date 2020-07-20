<?php
  
  $date_from = substr($crop_year->name, 0, 4) .'-08-01';
  $date_to = substr($crop_year->name, -4) .'-08-31';

  $months = __dynamic::months_between_dates($date_from, $date_to);
  

  function countByMonthYear($refinery_registrations, $my){

    $count = 0;

    foreach ($refinery_registrations as $data) {
      $data_my = __dataType::date_parse($data->reg_date, 'm-Y');
      if ($data_my == $my) {
        $count++;
      }
    }

    return $count;

  }



?>

<!DOCTYPE html>
<html>

<head>
	<title>Number of Registered Refineries per Month</title>
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
      <span style="font-size: 14px;">Number of Registered Refineries per Month</span><br>
      <span style="font-size: 14px;">CROP YEAR {{ $crop_year->name }}</span>
    </div>
  </div>

  <div class="row" id="content">
    <div class="col-xs-12 table-responsive">

      <table class="table table-bordered">

        <thead>
          <tr>
            <th>Month</td>
            <th style="text-align:center;">Registered Refineries</td>
          </tr>
        </thead>

        <tbody>

          @foreach($months as $key => $data)

            <tr>
              <td>
                {{ $data }}
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ countByMonthYear($refinery_registrations, $key) }}
              </td>
            </tr>

          @endforeach

            <tr>
              <td>
                TOTAL
              </td>
              <td style="text-align:center; font-weight: bold;">
                {{ $refinery_registrations->count() }}
              </td>
            </tr>

        </tbody>

      </table>

    </div>

  </div>

</section>

</body>

</html>
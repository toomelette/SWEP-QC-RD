<?php

  $cat = [

    'TC1001' => 'DOMESTIC SUGAR TRADERS',
    'TC1002' => 'INTERNATIONAL SUGAR TRADERS',
    'TC1003' => 'DOMESTIC MOLASSES TRADERS',
    'TC1004' => 'INTERNATIONAL MOLASSES TRADERS',
    'TC1005' => 'MUSCOVADO TRADER',
    'TC1006' => 'HFSC TRADER',

  ];

?>

<!DOCTYPE html>
<html>

<head>
	<title>List of Trader By Crop Year / Category</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">
</head>

<body onload="window.print();" onafterprint="window.close()">

<section class="invoice">

  {{-- HEADER --}}
  <div class="row" style="padding:10px; margin-bottom:10px; margin-top:40px;">
    <div class="col-xs-12" style="text-align: center;">
      <span>LISTING OF REGISTERED {{ $cat[Request::get('bcyc_tc')] }}</span><br>
      <span>CROP YEAR {{ $crop_year->name }}</span>
    </div>
  </div>

  <div class="row" id="content">
    <div class="col-xs-12 table-responsive">

      <table>

        <thead  style="border-top:1px solid; border-bottom:1px solid;">
          <tr>
            <th style="width:40px;">#</td>
            <th style="width:390px;">NAME & ADDRESS</td>
            <th style="width:150px; text-align: center;">TIN</td>
            <th style="width:150px; text-align: center;">TEL. NO. / FAX NO.</td>
          </tr>
        </thead>

        <tbody>

          <?php $i = 0; ?>

          @foreach($trader_registrations as $tr_data)
            @if (!empty($tr_data->trader))
              <tr>
                <td style="width:40px; vertical-align: text-top;">
                  {{ $i += 1 }}
                </td>
                <td style="width:390px;">
                  <b>{{ optional($tr_data->trader)->name }}</b><br>
                  {{ optional($tr_data->trader)->address }}<br>
                  {{ $tr_data->trader_officer }}<br>
                  {{ $tr_data->trader_email }}<br>
                  <br>
                </td>
                <td style="width:150px; text-align: center; vertical-align: text-top;">
                  {{ optional($tr_data->trader)->tin }}
                </td>
                <td style="width:150px; text-align: center; vertical-align: text-top;">
                  {{ optional($tr_data->trader)->tel_no }}
                </td>
              </tr>
            @endif
          @endforeach

        </tbody>

      </table>

    </div>

  </div>

</section>

</body>

</html>
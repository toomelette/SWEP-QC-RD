<?php

  $cat = [

    'TC1001' => 'DOMESTIC SUGAR TRADERS',
    'TC1002' => 'INTERNATIONAL SUGAR TRADERS',
    'TC1003' => 'DOMESTIC MOLASSES TRADERS',
    'TC1004' => 'INTERNATIONAL MOLASSES TRADERS',
    'TC1005' => 'MUSCOVADO TRADER',
    'TC1006' => 'HFSC TRADER',

  ];

  $trader_registrations_array = $trader_registrations->pluck('trader.region_id')->toArray();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Purchase Order</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">

</head>
<body onload="window.print();" onafterprint="window.close()">

	<section class="invoice">


    {{-- HEADER --}}
    <div class="row" style="padding:10px; margin-bottom:10px;">

      <div class="col-xs-12" style="text-align: center;">
        <span>LISTING OF REGISTERED {{ $cat[Request::get('bcyc_tc')] }}</span><br>
        <span>CROP YEAR {{ $crop_year->name }}</span>
      </div>

    </div>
    
    <div class="row" style="margin-bottom:20px;">
      <div class="col-xs-12 table-responsive">
        <table style="border-top:1px solid; border-bottom:1px solid;">
          <tbody>
            <tr>
              <td style="width:30px;">#</td>
              <td style="width:380px;">NAME & ADDRESS</td>
              <td style="width:150px; text-align: center;">TIN</td>
              <td style="width:150px; text-align: center;">TEL. NO. / FAX NO.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    @foreach ($global_regions_all as $region_data)
        
        @if (in_array($region_data->region_id, $trader_registrations_array))

          <div class="row">
            <div class="col-xs-12" style="text-align:center;">
              <span>{{ $region_data->name }}</span>
            </div>
            <div class="col-xs-12 table-responsive">
              <table>
                <tbody>
                  <?php $i = 0; ?>
                  @foreach($trader_registrations as $tr_data)
                    @if ($tr_data->trader->region_id == $region_data->region_id)
                      <tr>
                        <td style="width:30px; vertical-align: text-top;">{{ $i + 1 }}</td>
                        <td style="width:380px;">
                          <b>{{ $tr_data->trader->name }}</b><br>
                          {{ $tr_data->trader->address }}<br>
                          {{ $tr_data->trader_officer }}<br>
                          {{ $tr_data->trader_email }}<br>
                        </td>
                        <td style="width:150px; text-align: center;">{{ $tr_data->trader->tin }}</td>
                        <td style="width:150px; text-align: center;">{{ $tr_data->trader->tel_no }}</td>
                      </tr>
                    @endif
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>
          
        @endif

    @endforeach
  


  </section>

</body>
</html>
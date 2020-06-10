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
	<title>List of Trader By Crop Year / Category</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">
</head>

<body onload="window.print();" onafterprint="window.close()" style="font-size: 12px;">

<section class="invoice">

  {{-- HEADER --}}
  <div class="row" style="padding:10px; margin-bottom:10px; margin-top:40px;">
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
            <td style="width:40px;">#</td>
            <td style="width:390px;">NAME & ADDRESS</td>
            <td style="width:150px; text-align: center;">TIN</td>
            <td style="width:150px; text-align: center;">TEL. NO. / FAX NO.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row" id="content">
    <div class="col-xs-12 table-responsive">
      
      @foreach ($global_regions_all as $region_data)

        <table>
            
          <?php $i = 0; ?>

          @if (in_array($region_data->region_id, $trader_registrations_array))

            <thead style="display: table-header-group;">
              <tr>
                <th colspan="4" style="text-align: center; font-size:16px; padding-bottom:10px;">
                  {{ $region_data->name }}
                </th>
              </tr>
            </thead>

            <tbody>

              @foreach($trader_registrations as $tr_data)
                @if (!empty($tr_data->trader))
                  @if ($tr_data->trader->region_id == $region_data->region_id)
                    <tr>
                      <td style="width:40px; vertical-align: text-top; padding-top:10px;">
                        {{ $i += 1 }}
                      </td>
                      <td style="width:390px; padding-top:10px;">
                        <b>{{ optional($tr_data->trader)->name }}</b><br>
                        {{ optional($tr_data->trader)->address }}<br>
                        {{ $tr_data->trader_officer }}<br>
                        {{ $tr_data->trader_email }}<br>
                      </td>
                      <td style="width:150px; text-align: center; vertical-align: text-top; padding-top:10px;">
                        {{ optional($tr_data->trader)->tin }}
                      </td>
                      <td style="width:150px; text-align: center; vertical-align: text-top; padding-top:10px;">
                        {{ optional($tr_data->trader)->tel_no }}
                      </td>
                    </tr>
                  @endif
                @endif
              @endforeach

            </tbody>
      
          @endif

        </table>

      @endforeach

    </div>

  </div>

</section>

</body>

</html>
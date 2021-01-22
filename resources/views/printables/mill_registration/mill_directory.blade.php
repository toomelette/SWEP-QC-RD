<?php

  function countMillRegPerRegion($mill_registrations, $region){

    $count = 0;

    foreach($mill_registrations as $data){
      if (!empty($data->mill)){
        if ($data->mill->report_region == $region){
          $count =+ 1;
        }
      }
    }

    return $count;

  }

?>

<!DOCTYPE html>
<html>

<head>
  <title>Mill Directory</title>
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
  <div class="row" style="padding:11px; text-align: center;">
    <span style="font-size: 14px; font-weight:bold;">DIRECTORY OF SUGAR MILLS</span><br>
    <span style="font-size: 14px; font-weight:bold;">CY {{ $crop_year->name }}</span>  
  </div>

  <div class="row" style="margin-bottom:15px;">
    <div class="col-xs-12 table-responsive">
      <table style="border-top:1px solid; border-bottom:1px solid;">
        <tbody>
          <tr>
            <th style="width:200px;">SUGAR MILLS</th>
            <th style="width:200px; text-align:center;">METRO MANILA ADDRESS</th>
            <th style="width:200px; text-align:center;">MILL SITE ADDRESS</th>
            <th style="width:200px; text-align:center;">OFFICIAL / EMAIL ADDRESS</th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row" id="content">

    <div class="col-xs-12">

      @foreach (__static::report_regions() as $rr_name => $rr_key)

        @if (countMillRegPerRegion($mill_registrations, $rr_key) > 0)
          
          <?php $i = 0; ?>

          <table class="table" style="word-break:break-all; page-break-inside:avoid; border:none;">

            <thead style="display: table-header-group;">
              <tr>
                <th colspan="4" style="font-size:14px;">
                    {{ $rr_name }}
                </th>
              </tr>
            </thead>

            <tbody>

              @foreach($mill_registrations as $data)
                @if (!empty($data->mill))
                  @if ($data->mill->report_region == $rr_key)
                    <tr>
                      <td style="vertical-align: text-top; padding-top:5px; width:200px; overflow: hidden;">
                        {{ $i += 1 }}. {{ optional($data->mill)->name }}<br>
                        {{ optional(optional($data->mill)->region)->name }}
                      </td>
                      <td style="padding-top:5px; width:200px; overflow: hidden;">
                        {{ optional($data->mill)->address }}<br>
                        {{ optional($data->mill)->tel_no }}<br>
                        {{ optional($data->mill)->fax_no }}<br>
                      </td>
                      <td style="vertical-align: text-top; padding-top:5px; width:200px; overflow: hidden;">
                        {{ optional($data->mill)->address_second }}<br>
                        {{ optional($data->mill)->tel_no_second }}<br>
                        {{ optional($data->mill)->fax_no_second }}<br>
                      </td>
                      <td style="vertical-align: text-top; padding-top:5px; width:200px; overflow: hidden;">
                        {{ optional($data->mill)->officer }} - {{ optional($data->mill)->position }}<br>
                        {{ optional($data->mill)->email }}
                      </td>
                    </tr>
                  @endif
                @endif
              @endforeach

            </tbody>

          </table>

          
      
        @endif
          
      @endforeach

    </div>

  </div>

</section>

</body>

</html>
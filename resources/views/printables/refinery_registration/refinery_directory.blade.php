<?php

  function countRefineryRegPerRegion($ref_registrations, $region){

    $count = 0;

    foreach($ref_registrations as $data){
      if (!empty($data->refinery)){
        if ($data->refinery->report_region == $region){
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
  <title>Refinery Directory</title>
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
  <div class="row" style="padding:10px; text-align: center;">
    <span style="font-size: 14px;">DIRECTORY OF SUGAR REFINERIES</span><br>
    <span style="font-size: 14px;">CY {{ $crop_year->name }}</span>  
  </div>

  <div class="row" style="margin-bottom:15px;">
    <div class="col-xs-12 table-responsive">
      <table style="border-top:1px solid; border-bottom:1px solid;">
        <tbody>
          <tr>
            <th style="width:200px;">SUGAR REFINERIES</th>
            <th style="width:100px; text-align:center;">RATED CAPACITY</th>
            <th style="width:200px;">METRO MANILA ADDRESS</th>
            <th style="width:200px;">MILL SITE ADDRESS</th>
            <th style="width:200px;">OFFICIAL / EMAIL ADDRESS</th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="row" id="content">

    <div class="col-xs-12 table-responsive">

      @foreach (__static::report_regions() as $rr_name => $rr_key)

        @if(countRefineryRegPerRegion($refinery_registrations, $rr_key))

          <?php $i = 0; ?>

          <table class="table table-bordered" style="word-break:break-all; page-break-after:avoid;">

            <thead style="display: table-header-group;">
              <tr>
                <th colspan="5" style="font-size:11px;">
                  {{ $rr_name }}
                </th>
              </tr>
            </thead>

            <tbody>

              <?php $i = 0; ?>

              @foreach($refinery_registrations as $data)
                @if (!empty($data->refinery))
                  @if ($data->refinery->report_region == $rr_key)

                  <tr>
                    <td style="vertical-align: text-top; padding-top:5px; width:200px; overflow: hidden;">
                      {{ $i += 1 }}. {{ optional($data->refinery)->name }}<br>
                      {{ optional(optional($data->refinery)->region)->name }}
                    </td>
                    <td style="vertical-align: text-top; padding-top:5px; width:100px; overflow: hidden;">
                      {{ number_format($data->rated_capacity, 2)  }}
                    </td>
                    <td style="padding-top:5px; width:200px;">
                      {{ optional($data->refinery)->address }}<br>
                      {{ optional($data->refinery)->tel_no }}<br>
                      {{ optional($data->refinery)->fax_no }}<br>
                    </td>
                    <td style="vertical-align: text-top; padding-top:5px; width:200px; overflow: hidden;">
                      {{ optional($data->refinery)->address_second }}<br>
                      {{ optional($data->refinery)->tel_no_second }}<br>
                      {{ optional($data->refinery)->fax_no_second }}<br>
                    </td>
                    <td style="vertical-align: text-top; padding-top:5px; width:200px; overflow: hidden;">
                      {{ optional($data->refinery)->officer }} - {{ optional($data->refinery)->position }}<br>
                      {{ optional($data->refinery)->email }}
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
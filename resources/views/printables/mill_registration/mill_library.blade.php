<!DOCTYPE html>
<html>

<head>

  <title>Mill Library</title>
  <link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">

  <style type="text/css">

    @page  
      { 
        size: auto;
        margin-top: 25mm;
        margin-bottom: 30mm;  
        margin-right: 30mm;  
      } 

  </style>

</head>

<body onload="window.print();" onafterprint="window.close()" style="font-size: 11px;">

<section class="invoice">

  {{-- HEADER --}}
  <div class="row" style="padding:11px; text-align: center;">
    <span style="font-size: 14px;">Mill District Library</span><br>
    <span style="font-size: 14px;">CY {{ $crop_year->name }}</span>  
  </div>

  <div class="row" id="content">

    <div class="col-xs-12">

      <table class="table table-bordered">

        <thead>

          <tr>
            <th rowspan="2">Mills</th>
            
            @if (in_array('1', $fields))
              <th colspan="1" rowspan="2">Mill License</th>
            @endif
            
            @if (in_array('2', $fields))
              <th colspan="1" rowspan="2">Refinery License</th>
            @endif
            
            @if (in_array('3', $fields))
              <th colspan="2"  style="text-align: center;">Mill Participation</th>
            @endif
            
            @if (in_array('4', $fields))
              <th colspan="1" rowspan="2">Mill Rated Capacity</th>
            @endif
            
            @if (in_array('5', $fields))
              <th colspan="1" rowspan="2">Refinery Rated Capacity</th>
            @endif
            
            @if (in_array('6', $fields))
              <th colspan="1" rowspan="2">Molasses Tank 1</th>
            @endif
            
            @if (in_array('7', $fields))
              <th colspan="1" rowspan="2">Molasses Tank 2</th>
            @endif
            
            @if (in_array('13', $fields))
              <th colspan="1" rowspan="2">Molasses Tank 3</th>
            @endif
            
            @if (in_array('8', $fields))
              <th colspan="1" rowspan="2">Est. Start of Milling</th>
            @endif
            
            @if (in_array('9', $fields))
              <th colspan="1" rowspan="2">Est. End of Milling</th>
            @endif
            
            @if (in_array('10', $fields))
              <th colspan="3" style="text-align: center;">Crop Estimates</th>
            @endif
            
            @if (in_array('11', $fields))
              <th colspan="2" style="text-align: center;">Area Harvested</th>
            @endif
            
            @if (in_array('12', $fields))
              <th colspan="2" style="text-align: center;">Area Planted</th>
            @endif
            
          </tr>

          <tr>
            @if (in_array('3', $fields))
              <th>Planter</th>
              <th>Miller</th>
            @endif
            @if (in_array('10', $fields))
              <th>GTCM MT</th>
              <th>RAW MT</th>
              <th>RAW LKG</th>
            @endif
            @if (in_array('11', $fields))
              <th>Plane Cane</th>
              <th>Ratoon Cane</th>
            @endif
            @if (in_array('12', $fields))
              <th>Plane Cane</th>
              <th>Ratoon Cane</th>
            @endif
          </tr>

          <tr>
            
          </tr>
        </thead>

        <tbody>

          @foreach (__static::report_regions() as $rr_name => $rr_key)

            <tr>
              <th style="vertical-align: text-top; padding-top:5px; font-weight:bold;" colspan="18">
                {{ $rr_name }}
              </th>
            </tr>

            @foreach($mill_registrations as $data)
              @if (!empty($data->mill))
                @if ($data->mill->report_region == $rr_key)
                  <tr>

                    <td style="vertical-align: text-top; padding-top:5px;">
                      {{ optional($data->mill)->name }}
                    </td>

                    @if (in_array('1', $fields))
                      <td>{{ $data->license_no}}</td>
                    @endif

                    @if (in_array('2', $fields))
                      <td></td>
                    @endif

                    @if (in_array('3', $fields))
                      <td>{{ number_format($data->planter_share, 2) }}%</td>
                      <td>{{ number_format($data->mill_share, 2) }}%</td>
                    @endif

                    @if (in_array('4', $fields))
                      <td>{{ number_format($data->rated_capacity, 2) }} Tc/day</td>
                    @endif

                    @if (in_array('5', $fields))
                      <td></td>
                    @endif

                    @if (in_array('6', $fields))
                      <td>{{ number_format($data->molasses_tank_first, 2) }} MT</td>
                    @endif

                    @if (in_array('7', $fields))
                      <td>{{ number_format($data->molasses_tank_second, 2) }} MT</td>
                    @endif

                    @if (in_array('13', $fields))
                      <td>{{ number_format($data->molasses_tank_third, 2) }} MT</td>
                    @endif

                    @if (in_array('8', $fields))
                      <td>{{ __dataType::date_parse($data->est_start_milling, 'm/d/Y') }}</td>
                    @endif

                    @if (in_array('9', $fields))
                      <td>{{ __dataType::date_parse($data->est_end_milling, 'm/d/Y') }}</td>
                    @endif

                    @if (in_array('10', $fields))
                      <td>{{ number_format($data->gtcm_mt, 2) }}</td>
                      <td>{{ number_format($data->raw_mt, 2) }}</td>
                      <td>{{ number_format($data->raw_lkg, 2) }}</td>
                    @endif

                    @if (in_array('11', $fields))
                      <td>{{ number_format($data->ah_plant_cane, 2) }}</td>
                      <td>{{ number_format($data->ah_ratoon_cane, 2) }}</td>
                    @endif

                    @if (in_array('12', $fields))
                      <td>{{ number_format($data->ap_plant_cane, 2) }}</td>
                      <td>{{ number_format($data->ap_ratoon_cane, 2) }}</td>
                    @endif
                    
                  </tr>
                @endif
              @endif
            @endforeach
            
          @endforeach

          

        </tbody>

      </table>

    </div>

  </div>

</section>

</body>

</html>
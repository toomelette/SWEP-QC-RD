<!DOCTYPE html>
<html>

<head>

  <title>Mill Participation</title>
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
      } 

  </style>

</head>

<body onload="window.print();" onafterprint="window.close()" style="font-size: 11px;">

<section class="invoice">

  {{-- HEADER --}}
  <div class="row" style="padding:11px; text-align: center;">
    <span style="font-size: 14px;">MILL PARTICIPATION</span><br>
    <span style="font-size: 14px;">CY {{ $crop_year->name }}</span>  
  </div>

  <div class="row" id="content">

    <div class="col-xs-12">

      <table class="table table-bordered">

        <thead>
          <tr>
            <th style="width:100px;">SUGAR MILLS</th>
            <th style="width:100px;">PLANTER SHARE</th>
            <th style="width:100px;">MILL SHARE</th>
            <th style="width:100px;">OTHERS</th>
          </tr>
        </thead>

        <tbody>


          <tr>
            <td style="vertical-align: text-top; padding-top:5px; font-weight:bold;">
              LUZON
            </td>
            <td style="padding-top:5px;"></td>
            <td style="padding-top:5px;"></td>
            <td style="padding-top:5px;"></td>
          </tr>

          @foreach($mill_registrations as $data)
            @if (!empty($data->mill))
              @if ($data->mill->region->island_group == 1)
                <tr>
                  <td style="vertical-align: text-top; padding-top:5px;">
                    {{ optional($data->mill)->name }}
                  </td>
                  <td style="padding-top:5px;">
                    {{ number_format($data->planter_share, 2) }} %<br>
                  </td>
                  <td style="padding-top:5px;">
                    {{ number_format($data->mill_share, 2) }} %<br>
                  </td>
                  <td style="padding-top:5px;">
                    {{ $data->other_share}}<br>
                  </td>
                </tr>
              @endif
            @endif
          @endforeach


          <tr>
            <td style="vertical-align: text-top; padding-top:5px; font-weight:bold;">
              VISAYAS
            </td>
            <td style="padding-top:5px;"></td>
            <td style="padding-top:5px;"></td>
            <td style="padding-top:5px;"></td>
          </tr>

          @foreach($mill_registrations as $data)
            @if (!empty($data->mill))
              @if ($data->mill->region->island_group == 2)
                <tr>
                  <td style="vertical-align: text-top; padding-top:5px;">
                    {{ optional($data->mill)->name }}
                  </td>
                  <td style="padding-top:5px;">
                    {{ number_format($data->planter_share, 2) }} %<br>
                  </td>
                  <td style="padding-top:5px;">
                    {{ number_format($data->mill_share, 2) }} %<br>
                  </td>
                  <td style="padding-top:5px;">
                    {{ $data->other_share}}<br>
                  </td>
                </tr>
              @endif
            @endif
          @endforeach


          <tr>
            <td style="vertical-align: text-top; padding-top:5px; font-weight:bold;">
              MINDANAO
            </td>
            <td style="padding-top:5px;"></td>
            <td style="padding-top:5px;"></td>
            <td style="padding-top:5px;"></td>
          </tr>

          @foreach($mill_registrations as $data)
            @if (!empty($data->mill))
              @if ($data->mill->region->island_group == 3)
                <tr>
                  <td style="vertical-align: text-top; padding-top:5px;">
                    {{ optional($data->mill)->name }}
                  </td>
                  <td style="padding-top:5px;">
                    {{ number_format($data->planter_share, 2) }} %<br>
                  </td>
                  <td style="padding-top:5px;">
                    {{ number_format($data->mill_share, 2) }} %<br>
                  </td>
                  <td style="padding-top:5px;">
                    {{ $data->other_share}}<br>
                  </td>
                </tr>
              @endif
            @endif
          @endforeach

        </tbody>

      </table>

    </div>

  </div>

</section>

</body>

</html>
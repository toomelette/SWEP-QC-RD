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

  <div class="row" id="content">

    <div class="col-xs-12">

      <table class="table table-bordered">

        <thead>
          <tr>
            <th style="width:100px;">SUGAR MILLS</th>
            <th style="width:50px;">RATED CAPACITY</th>
            <th style="width:100px;">METRO MANILA ADDRESS</th>
            <th style="width:100px;">MILL SITE ADDRESS</th>
            <th style="width:100px;">OFFICIAL / EMAIL ADDRESS</th>
          </tr>
        </thead>

        <tbody>

          <?php $i = 0; ?>

          @foreach($refinery_registrations as $data)
            @if (!empty($data->refinery))
              <tr>
                <td style="vertical-align: text-top; padding-top:5px;">
                  {{ $i += 1 }}. {{ optional($data->refinery)->name }}<br>
                  {{ optional(optional($data->refinery)->region)->name }}
                </td>
                <td style="vertical-align: text-top; padding-top:5px;">
                  {{ number_format($data->rated_capacity, 2)  }}
                </td>
                <td style="padding-top:5px;">
                  {{ optional($data->refinery)->address }}<br>
                  {{ optional($data->refinery)->tel_no }}<br>
                  {{ optional($data->refinery)->fax_no }}<br>
                </td>
                <td style="vertical-align: text-top; padding-top:5px;">
                  {{ optional($data->refinery)->address_second }}<br>
                  {{ optional($data->refinery)->tel_no_second }}<br>
                  {{ optional($data->refinery)->fax_no_second }}<br>
                </td>
                <td style="vertical-align: text-top; padding-top:5px;">
                  {{ optional($data->refinery)->officer }} - {{ optional($data->refinery)->position }}<br>
                  {{ optional($data->refinery)->email }}
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
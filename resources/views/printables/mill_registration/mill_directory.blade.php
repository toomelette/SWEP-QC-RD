<!DOCTYPE html>
<html>

<head>
  <title>List of Trader By Crop Year / Category</title>
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

<body onload="window.print();" onafterprint="window.close()" style="font-size: 10px;">

<section class="invoice">

  {{-- HEADER --}}
  <div class="row" style="padding:10px; text-align: center;">
    <span>DIRECTORY OF SUGAR MILLS</span><br>
    <span>CY {{ $crop_year->name }}</span>  
  </div>

  <div class="row" id="content">

    <div class="col-xs-12">

      <table class="table table-bordered">

        <thead>
          <tr>
            <th style="width:100px;">SUGAR MILLS</th>
            <th style="width:100px;">METRO MANILA ADDRESS</th>
            <th style="width:100px;">MILL SITE ADDRESS</th>
            <th style="width:100px;">President/Email Address</th>
          </tr>
        </thead>

        <tbody>

          <?php $i = 0; ?>

          @foreach($mill_registrations as $data)
            @if (!empty($data->mill))
              <tr>
                <td style="vertical-align: text-top; padding-top:5px;">
                  {{ $i += 1 }}. {{ optional($data->mill)->name }}<br>
                  {{ optional(optional($data->mill)->region)->name }}
                </td>
                <td style="padding-top:5px;">
                  {{ optional($data->mill)->address }}<br>
                  {{ optional($data->mill)->tel_no }}<br>
                  {{ optional($data->mill)->fax_no }}<br>
                </td>
                <td style="vertical-align: text-top; padding-top:5px;">
                  {{ optional($data->mill)->address_second }}<br>
                  {{ optional($data->mill)->tel_no_second }}<br>
                  {{ optional($data->mill)->fax_no_second }}<br>
                </td>
                <td style="vertical-align: text-top; padding-top:5px;">
                  {{ optional($data->mill)->officer }} - {{ optional($data->mill)->position }}<br>
                  {{ optional($data->mill)->email }}
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
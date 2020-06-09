<!DOCTYPE html>
<html>
<head>
	<title>List of Trader By Date / Category</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">

</head>
<body onload="window.print();" onafterprint="window.close()">

	<section class="invoice">
      
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Crop Year</th>
              <th>Category</th>
              <th>Control No.</th>
              <th>Reg. Date</th>
              <th>Trader Name</th>
              <th>Trader Address</th>
              <th>Trader 2nd Address</th>
              <th>Region</th>
              <th>TIN</th>
              <th>Tel No.</th>
              <th>Officer</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            @foreach($trader_registrations as $data)

              <tr>
                <td>{{ optional($data->cropYear)->name }}</td>
                <td>{{ optional($data->traderCategory)->name }}</td>
                <td>{{ $data->control_no }}</td>
                <td>{{ $data->reg_date->format('m/d/Y') }}</td>
                <td>{{ optional($data->trader)->name }}</td>
                <td>{{ optional($data->trader)->address }}</td>
                <td>{{ optional($data->trader)->address_second }}</td>
                <td>{{ optional($data->trader)->region->name }}</td>
                <td>{{ optional($data->trader)->tin }}</td>
                <td>{{ optional($data->trader)->tel_no }}</td>
                <td>{{ optional($data->trader)->officer }}</td>
                <td>{{ optional($data->trader)->email }}</td>
              </tr>

            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  


  </section>

</body>
</html>
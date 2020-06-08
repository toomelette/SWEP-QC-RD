@extends('layouts.admin-master')

@section('content')

<section class="content">
            
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title mid-vert">List by Registration Date and Category</h2>
      <div class="pull-right">
        <a href="{{ route('dashboard.trader_registration.print_list_bdc') }}" 
           class="btn btn-sm btn-default"
           target="_blank">
           Print <i class="fa fa-fw fa-print"></i>
        </a>
      </div> 
    </div>
    
    <div class="box-body">
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
                <th>Trader Second Address</th>
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
    </div>

  </div>

</section>

@endsection
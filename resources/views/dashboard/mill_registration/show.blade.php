@extends('layouts.admin-master')

@section('content')

<section class="content">
            
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">Trader License Details</h2>
      <div class="pull-right">

        @if (in_array('dashboard.mill_registration.dl_cover', $global_user_submenus))
          <a href="{{ route('dashboard.mill_registration.dl_cover', $mill_reg->slug) }}" 
             class="btn btn-md bg-blue"
             target="_blank">
             <i class="fa fa-download"></i> Cover Letter
          </a>
        @endif
        &nbsp;

        @if (in_array('dashboard.mill_registration.dl_billing', $global_user_submenus))
          <a href="{{ route('dashboard.mill_registration.dl_billing', $mill_reg->slug) }}" 
             class="btn btn-md bg-blue"
             target="_blank">
             <i class="fa fa-download"></i> Billing Statement
          </a>
        @endif
        &nbsp;

        @if (in_array('dashboard.mill_registration.dl_license', $global_user_submenus))
          <a href="{{ route('dashboard.mill_registration.dl_license', $mill_reg->slug) }}" 
             class="btn btn-md bg-blue"
             target="_blank">
             <i class="fa fa-download"></i> License
          </a>
        @endif
        &nbsp;
        
        {!! __html::back_button(['dashboard.mill.renewal_history']) !!}
      </div> 
    </div>

    <div class="box-body">

      <div class="col-md-6">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">License Info</h3>
          </div>
          <div class="box-body">
            <dl class="dl-horizontal">
              <dt>Crop Year:</dt>
              <dd>{{ optional($mill_reg->cropYear)->name }}</dd>
              <dt>License No.:</dt>
              <dd>{{ $mill_reg->license_no }}</dd>
              <dt>Name of Mill:</dt>
              <dd>{{ optional($mill_reg->mill)->name }}</dd>
              <dt>Address:</dt>
              <dd>{{ optional($mill_reg->mill)->address }}</dd>
              <dt>Date of Registration:</dt>
              <dd>{{ __dataType::date_parse($mill_reg->reg_date, 'F d,Y') }}</dd>
              <dt>Rated Capacity:</dt>
              <dd>{{ number_format($mill_reg->rated_capacity, 2) }}</dd>
              <dt>Milling Date:</dt>
              <dd>{{ __dataType::date_scope($mill_reg->start_milling, $mill_reg->end_milling) }}</dd>
            </dl>
          </div>
        </div>
      </div> 


      <div class="col-md-6">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Cover Letter Info</h3>
          </div>
          <div class="box-body">
            <dl class="dl-horizontal">
              <dt>Officer:</dt>
              <dd>{{ optional($mill_reg->mill)->officer }}</dd>
              <dt>Position:</dt>
              <dd>{{ optional($mill_reg->mill)->position }}</dd>
              <dt>Name of Mill:</dt>
              <dd>{{ optional($mill_reg->mill)->name }}</dd>
              <dt>Address:</dt>
              <dd>{{ optional($mill_reg->mill)->address }}</dd>
              <dt>License No.:</dt>
              <dd>{{ $mill_reg->license_no }}</dd>
              <dt>Crop Year:</dt>
              <dd>{{ optional($mill_reg->cropYear)->name }}</dd>
            </dl>
          </div>
        </div>
      </div> 

      <div class="col-md-12"></div>

      <div class="col-md-6">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Billing Statement Info</h3>
          </div>
          <div class="box-body">
            <dl class="dl-horizontal">
              <dt>Officer:</dt>
              <dd>{{ optional($mill_reg->mill)->officer }}</dd>
              <dt>Position:</dt>
              <dd>{{ optional($mill_reg->mill)->position }}</dd>
              <dt>Name of Mill:</dt>
              <dd>{{ optional($mill_reg->mill)->name }}</dd>
              <dt>Address:</dt>
              <dd>{{ optional($mill_reg->mill)->address }}</dd>
              <dt>Salutation:</dt>
              <dd>{{ optional($mill_reg->mill)->salutation }}</dd>
              <dt>MT:</dt>
              <dd>{{ number_format($mill_reg->mt, 2) }}</dd>
              <dt>LKG:</dt>
              <dd>{{ number_format($mill_reg->lkg, 2) }}</dd>
              <dt>Milling Fee:</dt>
              <dd>{{ number_format($mill_reg->milling_fee, 2) }}</dd>
              <dt>Payment Status:</dt>
              <dd>{{ $mill_reg->payment_status == "UP" ? "Underpayment" : "Excess Payment" }}</dd>
              <dt>Underpayment:</dt>
              <dd>{{ number_format($mill_reg->under_payment, 2) }}</dd>
              <dt>Excess Payment:</dt>
              <dd>{{ number_format($mill_reg->excess_payment, 2) }}</dd>
              <dt>Balance:</dt>
              <dd>{{ number_format($mill_reg->balance_fee, 2) }}</dd>
              <dt>Crop Year:</dt>
              <dd>{{ optional($mill_reg->cropYear)->name }}</dd>
            </dl>
          </div>
        </div>
      </div> 


    </div>

  </div>

</section>

@endsection
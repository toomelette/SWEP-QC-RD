@extends('layouts.admin-master')

@section('content')

<section class="content">
            
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">Refinery License Details</h2>
      <div class="pull-right">

        @if (in_array('dashboard.refinery_registration.dl_cover', $global_user_submenus))
          <a href="{{ route('dashboard.refinery_registration.dl_cover', $refinery_reg->slug) }}" 
             class="btn btn-md bg-blue"
             target="_blank">
             <i class="fa fa-download"></i> Cover Letter
          </a>
        @endif
        &nbsp;

        @if (in_array('dashboard.refinery_registration.dl_license', $global_user_submenus))
          <a href="{{ route('dashboard.refinery_registration.dl_license', $refinery_reg->slug) }}" 
             class="btn btn-md bg-blue"
             target="_blank">
             <i class="fa fa-download"></i> License
          </a>
        @endif
        &nbsp;
        {!! __html::back_button(['dashboard.refinery.renewal_history']) !!}
      </div> 
    </div>

    <div class="box-body">

      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Details</h3>
          </div>
          <div class="box-body">
            <dl class="dl-horizontal">
              <dt>Crop Year:</dt>
              <dd>{{ optional($refinery_reg->cropYear)->name }}</dd>
              <dt>License No.:</dt>
              <dd>{{ $refinery_reg->license_no }}</dd>
              <dt>Name of Mill:</dt>
              <dd>{{ optional($refinery_reg->refinery)->name }}</dd>
              <dt>Address:</dt>
              <dd>{{ optional($refinery_reg->refinery)->address }}</dd>
              <dt>Date of Registration:</dt>
              <dd>{{ __dataType::date_parse($refinery_reg->reg_date, 'F d,Y') }}</dd>
              <dt>Rated Capacity:</dt>
              <dd>{{ number_format($refinery_reg->rated_capacity, 2) }}</dd>
            </dl>
          </div>
        </div>
      </div>

    </div>

  </div>

</section>

@endsection
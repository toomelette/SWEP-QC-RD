@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Trader License Details</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
          &nbsp;
          {!! __html::back_button(['dashboard.trader_registration.index']) !!}
        </div> 
      </div>

      <div class="box-body">
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
      </div>

    </div>

</section>

@endsection
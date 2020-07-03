@extends('layouts.admin-master')

@section('content')

<section class="content">
            
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title" style="margin-top: 10px;">Trader License Details</h2>
      <div class="pull-right">
        <a href="{{ route('dashboard.trader_registration.dl_word_file', $trader_reg->slug) }}" 
           class="btn btn-md bg-blue"
           target="_blank">
           <i class="fa fa-download"></i> Download Word File
        </a>
        &nbsp;
        {!! __html::back_button(['dashboard.trader.renewal_history']) !!}
      </div> 
    </div>

    <div class="box-body" style="padding-top:100px; padding-bottom:100px;">

     

      <div class="col-md-1"></div>

      <div class="col-md-10" 
           style="text-indent: 40px; 
                  font-family: Arial; 
                  font-size: 14px;
                  text-align: justify;">
      
      @if ($trader_reg->trader_cat_id == 'TC1001')
        @include('dashboard.trader_registration.print_contents.sugar_dom') 
      @elseif($trader_reg->trader_cat_id == 'TC1002') 
        @include('dashboard.trader_registration.print_contents.sugar_int') 
      @elseif($trader_reg->trader_cat_id == 'TC1003') 
        @include('dashboard.trader_registration.print_contents.molasses_dom') 
      @elseif($trader_reg->trader_cat_id == 'TC1004') 
        @include('dashboard.trader_registration.print_contents.molasses_int') 
      @elseif($trader_reg->trader_cat_id == 'TC1005') 
        @include('dashboard.trader_registration.print_contents.muscovado') 
      @elseif($trader_reg->trader_cat_id == 'TC1006') 
        @include('dashboard.trader_registration.print_contents.sugar_fruc') 
      @endif

      </div>

      <div class="col-md-1"></div>

      <div class="col-md-12" style="padding-bottom:40px;"></div>


      <div class="col-md-4"></div>
      <div class="col-md-2"></div>
      <div class="col-md-4" style="text-align: center;">
        <span style="font-weight: bold;">{{ $trader_reg->signatory }}</span>
      </div>
      <div class="col-md-2"></div>


      <div class="col-md-4"></div>
      <div class="col-md-2"></div>
      <div class="col-md-4" style="text-align: center;">
        <span>Administrator</span>
      </div>
      <div class="col-md-2"></div>


      <div class="col-md-2"></div>
      <div class="col-md-5" style="padding-left:80px;">

        <img src="{{ asset('images/flag.png') }}"
             style="width:210px; position:relative;">

        <span style="position: absolute; 
                     margin-top: 25px;
                     margin-left: -175px;
                     font-weight:bold;
                     font-size:21px;">
          {{ $trader_reg->control_no }}
        </span>

        <br>
        <br>

        <span style="font-weight:bold; font-size:20px;">
          TIN:
        </span>
        <span style="font-weight:bold; font-size:20px; text-decoration: underline;">
          &nbsp;{{ optional($trader_reg->trader)->tin }}
        </span>

      </div>
      <div class="col-md-5"></div>


    </div>

  </div>

</section>

@endsection
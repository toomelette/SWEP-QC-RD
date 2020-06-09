<!DOCTYPE html>
<html>
<head>
	<title>Trader Certification</title>
	<link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">
	<link rel="stylesheet" href="{{ asset('template/dist/css/skins/_all-skins.min.css') }}">

</head>
<body onload="window.print();" onafterprint="window.close()">

	<section class="invoice" style="padding-top:380px;">

    <div class="col-xs-1"></div>

    <div class="col-xs-10" 
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

    <div class="col-xs-1"></div>

    <div class="col-xs-12" style="padding-bottom:40px;"></div>


    <div class="col-xs-4"></div>
    <div class="col-xs-2"></div>
    <div class="col-xs-4" style="text-align: center;">
      <span style="font-weight: bold;">{{ $trader_reg->signatory }}</span>
    </div>
    <div class="col-xs-2"></div>


    <div class="col-xs-4"></div>
    <div class="col-xs-2"></div>
    <div class="col-xs-4" style="text-align: center;">
      <span>Administrator</span>
    </div>
    <div class="col-xs-2"></div>


    <div class="col-xs-2"></div>
    <div class="col-xs-5" style="padding-left:80px;">

      <img src="{{ asset('images/flag.png') }}"
           style="width:210px; position:relative;">

      <span style="position: absolute; 
                   margin: 0 auto; 
                   margin-left: 30px;
                   margin-top: -57px;
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
    <div class="col-xs-5"></div>

  </section>

</body>
</html>
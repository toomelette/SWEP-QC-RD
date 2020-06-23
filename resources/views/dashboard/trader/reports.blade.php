@extends('layouts.admin-master')

@section('content')

<section class="content">
       

  {{-- List by Date and Category --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">List of Registered Traders by Date and Category</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bdc" 
          action="{{ route('dashboard.trader_registration.reports_output') }}">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="bdc">

          <input type="hidden" id="bdc_t" name="bdc_t">

          {!! __form::datepicker(
            '3', 'bdc_df',  'Date from *', old('bdc_df'), $errors->has('bdc_df'), $errors->first('bdc_df')
          ) !!}

          {!! __form::datepicker(
            '3', 'bdc_dt',  'Date to *', old('bdc_dt'), $errors->has('bdc_dt'), $errors->first('bdc_dt')
          ) !!}

          {!! __form::select_dynamic(
            '3', 'bdc_tc', 'Trader Category *', old('bdc_tc'), $global_trader_categories_all, 'trader_cat_id', 'name', $errors->has('bdc_tc'), $errors->first('bdc_tc'), 'select2', ''
          ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button class="btn btn-default submit_button" data-type="p">
          Print <i class="fa fa-fw fa-print"></i>
        </button>&nbsp;
        <button class="btn btn-success submit_button" data-type="e">
          Export in Excel <i class="fa fa-fw fa-file-text-o"></i>
        </button>
      </div>

    </form>

  </div>
           


  {{-- List by Crop Year and Category --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">List of Registered Traders by Crop Year and Category</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bdc" 
          action="{{ route('dashboard.trader_registration.reports_output') }}"
          target="_blank">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="bcyc">
          
          {!! __form::select_dynamic(
            '3', 'bcyc_cy', 'Crop Year *', old('bcyc_cy'), $global_crop_years_all, 'crop_year_id', 'name', $errors->has('bcyc_cy'), $errors->first('bcyc_cy'), 'select2', ''
          ) !!}

          {!! __form::select_dynamic(
            '3', 'bcyc_tc', 'Trader Category *', old('bcyc_tc'), $global_trader_categories_all, 'trader_cat_id', 'name', $errors->has('bcyc_tc'), $errors->first('bcyc_tc'), 'select2', ''
          ) !!}

          {!! __form::select_static(
            '3', 'bcyc_rt', 'Type *', old('bcyc_rt'), ['By Region' => 'BR', 'Alphabetical' => 'A'], $errors->has('bcyc_rt'), $errors->first('bcyc_rt'), '', ''
          ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button class="btn btn-default" data-type="p">
          Print <i class="fa fa-fw fa-print"></i>
        </button>
      </div>

    </form>

  </div>



</section>

@endsection




@section('scripts')

  <script type="text/javascript">

    $(document).on("click", ".submit_button", function (e) {
      
      e.preventDefault();
      $("#bdc_t").val($(this).data("type"));
      
      if($(this).data("type") == 'e'){
        $("#form_bdc").submit();
      }else if($(this).data("type") == 'p'){
        $("#form_bdc").attr("target", "_blank").submit();
      }

    });

  </script>
    
@endsection
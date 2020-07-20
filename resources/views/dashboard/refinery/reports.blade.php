@extends('layouts.admin-master')

@section('content')

<section class="content">
       

  {{-- Refinery Directory --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">Directory of Sugar Refineries</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bd" 
          action="{{ route('dashboard.refinery_registration.reports_output') }}"
          target="_blank">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="rd">

          {!! __form::select_dynamic(
            '3', 'rd_cy', 'Crop Year *', old('rd_cy'), $global_crop_years_all, 'crop_year_id', 'name', $errors->has('rd_cy'), $errors->first('rd_cy'), 'select2', ''
          ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-default">
          Print <i class="fa fa-fw fa-print"></i>
        </button>
      </div>

    </form>

  </div>
       


  {{-- RATED CAPACITY --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">Rated Capacity</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bd" 
          action="{{ route('dashboard.refinery_registration.reports_output') }}"
          target="_blank">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="rc">

          {!! __form::select_dynamic(
            '3', 'rc_cy', 'Crop Year *', old('rc_cy'), $global_crop_years_all, 'crop_year_id', 'name', $errors->has('rc_cy'), $errors->first('rc_cy'), 'select2', ''
          ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-default">
          Print <i class="fa fa-fw fa-print"></i>
        </button>
      </div>

    </form>

  </div>
           


  {{-- Count By Crop Year --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">Number of Registered Refineries by Month</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_cbcy"
          action="{{ route('dashboard.refinery_registration.reports_output') }}"
          target="_blank">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="cbcy">
          
          {!! __form::select_dynamic(
            '3', 'cbcy_cy', 'Crop Year *', old('cbcy_cy'), $global_crop_years_all, 'crop_year_id', 'name', $errors->has('cbcy_cy'), $errors->first('cbcy_cy'), 'select2', ''
          ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button class="btn btn-default">
          Print <i class="fa fa-fw fa-print"></i>
        </button>
      </div>

    </form>

  </div>
       


  {{-- List of Registered Refinery by Date --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">List of Registered Refinery by Date</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bd" 
          action="{{ route('dashboard.refinery_registration.reports_output') }}"
          target="_blank">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="bd">

          {!! __form::datepicker(
            '3', 'bd_df',  'Date from *', old('bd_df'), $errors->has('bd_df'), $errors->first('bd_df')
          ) !!}

          {!! __form::datepicker(
            '3', 'bd_dt',  'Date to *', old('bd_dt'), $errors->has('bd_dt'), $errors->first('bd_dt')
          ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-success">
          Export in Excel <i class="fa fa-fw fa-file-text-o"></i>
        </button>
      </div>

    </form>

  </div>
           


  {{-- List of Registered Refinery by Crop Year --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">List of Registered Refinery by Crop Year</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bd" 
          action="{{ route('dashboard.refinery_registration.reports_output') }}"
          target="_blank">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="bcy">
          
          {!! __form::select_dynamic(
            '3', 'bcy_cy', 'Crop Year *', old('bcy_cy'), $global_crop_years_all, 'crop_year_id', 'name', $errors->has('bcy_cy'), $errors->first('bcy_cy'), 'select2', ''
          ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button type="submit" class="btn btn-success">
          Export in Excel <i class="fa fa-fw fa-file-text-o"></i>
        </button>
      </div>

    </form>

  </div>



</section>

@endsection
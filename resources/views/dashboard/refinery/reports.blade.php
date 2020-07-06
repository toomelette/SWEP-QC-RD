@extends('layouts.admin-master')

@section('content')

<section class="content">
       

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
<?php

  $ml_fields = [

    '1' => 'Mill Registration Status',
    // '2' => 'Refinery Registration Status',
    '3' => 'Mill Participation',
    '4' => 'Mill Rated Capacity',
    // '5' => 'Refinery Rated Capacity',
    '6' => 'Molasses Tank 1',
    '7' => 'Molasses Tank 2',
    '13' => 'Molasses Tank 3',
    '8' => 'Estimated Start of Milling',
    '9' => 'Estimated End of Milling',
    '10' => 'Crop Estimates',
    '11' => 'Area Harvested',
    '12' => 'Area Planted',

  ];

?>

@extends('layouts.admin-master')

@section('content')

<section class="content">
       

  {{-- Mill Directory --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title"><b>Directory of Sugar Mills</b></h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bd" 
          action="{{ route('dashboard.mill_registration.reports_output') }}"
          target="_blank">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="md">

          {!! __form::select_dynamic(
            '3', 'md_cy', 'Crop Year *', old('md_cy'), $global_crop_years_all, 'crop_year_id', 'name', $errors->has('md_cy'), $errors->first('md_cy'), 'select2', ''
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
           


  {{-- Mill Library --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title"><b>Mill Library</b></h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_ml" 
          action="{{ route('dashboard.mill_registration.reports_output') }}"
          target="_blank">

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="ml">

          <input type="hidden" id="ml_t" name="ml_t">
          
          {!! __form::select_dynamic(
            '3', 'ml_cy', 'Crop Year *', old('ml_cy'), $global_crop_years_all, 'crop_year_id', 'name', $errors->has('ml_cy'), $errors->first('ml_cy'), 'select2', ''
          ) !!}


          <div class="form-group col-md-12">

            <label>Please select fields:</label><br>

            @foreach ($ml_fields as $key => $title)
              <label>
                <input type="checkbox" 
                       class="minimal" 
                       name="ml_field[]" 
                       value="{{ $key }}" 
                       @if ($errors->has('ml_field'))
                          {{ in_array($key, old('ml_field')) ? 'checked' : '' }}
                       @endif
                >
                &nbsp; {{ $title }}
              </label>
              <br>
            @endforeach
            
            @if($errors->has('ml_field'))
              <p class="text-danger">{{ $errors->first('ml_field') }}</p>
            @endif

          </div>


        </div>
      </div>

      <div class="box-footer">
        <button class="btn btn-default submit_button_ml" data-type="p">
          Print <i class="fa fa-fw fa-print"></i>
        </button>&nbsp;
        <button class="btn btn-success submit_button_ml" data-type="e">
          Excel <i class="fa fa-fw fa-file-text-o"></i>
        </button>
      </div>

    </form>

  </div>
           


  {{-- Count By Crop Year --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title"><b>Number of Registered Mills by Month</b></h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_cbcy"
          action="{{ route('dashboard.mill_registration.reports_output') }}"
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

       

  {{-- List of Registered Mills by Date --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title"><b>List of Registered Mills by Date</b></h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bd" 
          action="{{ route('dashboard.mill_registration.reports_output') }}"
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
           


  {{-- List of Registered Mills by Crop Year --}}
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title"><b>List of Registered Mills by Crop Year</b></h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bcy" 
          action="{{ route('dashboard.mill_registration.reports_output') }}"
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




@section('scripts')

  <script type="text/javascript">


    $(document).on("click", ".submit_button_ml", function (e) {
      
      e.preventDefault();
      $("#ml_t").val($(this).data("type"));
      
      if($(this).data("type") == 'e'){
        $("#form_ml").submit();
      }else if($(this).data("type") == 'p'){
        $("#form_ml").attr("target", "_blank").submit();
      }

    });


  </script>
    
@endsection
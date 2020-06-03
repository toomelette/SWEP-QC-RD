@extends('layouts.admin-master')

@section('content')

<section class="content">
            
  <div class="box box-solid">
      
    <div class="box-header with-border">
      <h2 class="box-title">List by Date and Category</h2>
      <div class="pull-right">
          <code>Fields with asterisks(*) are required</code>
      </div> 
    </div>
    
    <form method="GET" 
          id="form_bdc" 
          action="{{ route('dashboard.trader_registration.reports_output') }}"
          {{-- target="_blank" --}}>

      <div class="box-body">
        <div class="col-md-12">

          <input type="hidden" id="ft" name="ft" value="bdc">

          <input type="hidden" id="t" name="t">

          {!! __form::datepicker(
            '3', 'df',  'Date from *', old('df'), $errors->has('df'), $errors->first('df')
          ) !!}

          {!! __form::datepicker(
            '3', 'dt',  'Date to *', old('dt'), $errors->has('dt'), $errors->first('dt')
          ) !!}

          {!! __form::select_dynamic(
            '3', 'tc', 'Category', old('tc'), $global_trader_categories_all, 'trader_cat_id', 'name', $errors->has('tc'), $errors->first('tc'), 'select2', ''
          ) !!}

        </div>
      </div>

      <div class="box-footer">
        <button class="btn btn-default submit_button"
                data-type="p">
          Print <i class="fa fa-fw fa-print"></i>
        </button>&nbsp;
        <button class="btn btn-success submit_button"
                data-type="e">
          Export in Excel <i class="fa fa-fw fa-file-text-o"></i>
        </button>
      </div>

    </form>

  </div>

</section>

@endsection




@section('scripts')

  <script type="text/javascript">

    $(document).on("click", ".submit_button", function () {
      $("#t").val($(this).data("type"));
      $("#form_bdc").submit();
    });

  </script>
    
@endsection
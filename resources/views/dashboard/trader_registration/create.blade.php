@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Trader License</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.trader_registration.store') }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf   

            {!! __form::textbox(
              '4', 'control_no', 'text', 'Control No. *', 'Control No.', old('control_no'), $errors->has('control_no'), $errors->first('control_no'), ''
            ) !!}

            {!! __form::select_dynamic(
              '8', 'trader_id', 'Trader *', old('trader_id'), $global_traders_all, 'trader_id', 'name', $errors->has('trader_id'), $errors->first('trader_id'), 'select2', ''
            ) !!}

            {!! __form::select_dynamic(
              '4', 'trader_cat_id', 'Category *', old('trader_cat_id'), $global_trader_categories_all, 'trader_cat_id', 'name', $errors->has('trader_cat_id'), $errors->first('trader_cat_id'), 'select2', ''
            ) !!}

            {!! __form::datepicker(
              '4', 'reg_date',  'Date of Registration *', old('reg_date'), $errors->has('reg_date'), $errors->first('reg_date')
            ) !!}

          </div>
        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>

      </form>

    </div>

</section>

@endsection




@section('scripts')

  <script type="text/javascript">

    @if(Session::has('TRADER_REG_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('TRADER_REG_CREATE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection
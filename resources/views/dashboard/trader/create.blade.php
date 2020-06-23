@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Trader</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.trader.store') }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf   

            {!! __form::textbox(
              '6', 'name', 'text', 'Name *', 'Name', old('name'), $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '3', 'tin', 'text', 'TIN *', 'TIN', old('tin'), $errors->has('tin'), $errors->first('tin'), ''
            ) !!}

            {!! __form::select_dynamic(
              '3', 'region_id', 'Region *', old('region_id'), $global_regions_all, 'region_id', 'name', $errors->has('region_id'), $errors->first('region_id'), 'select2', ''
            ) !!}

            {!! __form::textbox(
              '12', 'address', 'text', 'Address *', 'Address', old('address'), $errors->has('address'), $errors->first('address'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_second', 'text', 'Second Address', 'Second Address', old('address_second'), $errors->has('address_second'), $errors->first('address_second'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_third', 'text', 'Third Address', 'Third Address', old('address_third'), $errors->has('address_third'), $errors->first('address_third'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'tel_no', 'text', 'Tel No.', 'Tel No.', old('tel_no'), $errors->has('tel_no'), $errors->first('tel_no'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'officer', 'text', 'Officer', 'Officer', old('officer'), $errors->has('officer'), $errors->first('officer'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'email', 'text', 'Email', 'Email', old('email'), $errors->has('email'), $errors->first('email'), ''
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

    @if(Session::has('TRADER_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('TRADER_CREATE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection
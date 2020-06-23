@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Edit Trader</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
          &nbsp;
          {!! __html::back_button(['dashboard.trader.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.trader.update', $trader->slug) }}">

        <div class="box-body">
          <div class="col-md-12">

            <input name="_method" value="PUT" type="hidden">
                  
            @csrf   

            {!! __form::textbox(
              '6', 'name', 'text', 'Name *', 'Name', old('name') ? old('name') : $trader->name, $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '3', 'tin', 'text', 'TIN *', 'TIN', old('tin') ? old('tin') : $trader->tin, $errors->has('tin'), $errors->first('tin'), ''
            ) !!}

            {!! __form::select_dynamic(
              '3', 'region_id', 'Region *', old('region_id') ? old('region_id') : $trader->region_id, $global_regions_all, 'region_id', 'name', $errors->has('region_id'), $errors->first('region_id'), 'select2', ''
            ) !!}

            {!! __form::textbox(
              '12', 'address', 'text', 'Address *', 'Address', old('address') ? old('address') : $trader->address, $errors->has('address'), $errors->first('address'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_second', 'text', 'Address Second', 'Address Second', old('address_second') ? old('address_second') : $trader->address_second, $errors->has('address_second'), $errors->first('address_second'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_third', 'text', 'Address Third', 'Address Third', old('address_third') ? old('address_third') : $trader->address_third, $errors->has('address_third'), $errors->first('address_third'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'tel_no', 'text', 'Tel No.', 'Tel No.', old('tel_no') ? old('tel_no') : $trader->tel_no, $errors->has('tel_no'), $errors->first('tel_no'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'officer', 'text', 'Officer', 'Officer', old('officer') ? old('officer') : $trader->officer, $errors->has('officer'), $errors->first('officer'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'email', 'text', 'Email', 'Email', old('email') ? old('email') : $trader->email, $errors->has('email'), $errors->first('email'), ''
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
@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Edit Mill</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.mill.update', $mill->slug) }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf   

            <input type="hidden" name="_method" value="PUT"> 

            {!! __form::textbox(
              '12', 'name', 'text', 'Name of Mill *', 'Name of Mill', old('name') ? old('name') : $mill->name, $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address', 'text', 'Address *', 'Address', old('address') ? old('address') : $mill->address, $errors->has('address'), $errors->first('address'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_second', 'text', 'Second Address', 'Second Address', old('address_second') ? old('address_second') : $mill->address_second, $errors->has('address_second'), $errors->first('address_second'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_third', 'text', 'Third Address', 'Third Address', old('address_third') ? old('address_third') : $mill->address_third, $errors->has('address_third'), $errors->first('address_third'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '6', 'tel_no', 'text', 'Tel No.', 'Tel No.', old('tel_no') ? old('tel_no') : $mill->tel_no, $errors->has('tel_no'), $errors->first('tel_no'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'tel_no_second', 'text', 'Tel No. Second', 'Tel No. Second', old('tel_no_second') ? old('tel_no_second') : $mill->tel_no_second, $errors->has('tel_no_second'), $errors->first('tel_no_second'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '6', 'fax_no', 'text', 'Fax No.', 'Fax No.', old('fax_no') ? old('fax_no') : $mill->fax_no, $errors->has('fax_no'), $errors->first('fax_no'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'fax_no_second', 'text', 'Fax No. Second', 'Fax No. Second', old('fax_no_second') ? old('fax_no_second') : $mill->fax_no_second, $errors->has('fax_no_second'), $errors->first('fax_no_second'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '4', 'officer', 'text', 'Officer', 'Officer', old('officer') ? old('officer') : $mill->officer, $errors->has('officer'), $errors->first('officer'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'position', 'text', 'Position', 'Position', old('position') ? old('position') : $mill->position, $errors->has('position'), $errors->first('position'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'salutation', 'text', 'Salutation', 'Salutation', old('salutation') ? old('salutation') : $mill->salutation, $errors->has('salutation'), $errors->first('salutation'), ''
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

    @if(Session::has('MILL_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_CREATE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection
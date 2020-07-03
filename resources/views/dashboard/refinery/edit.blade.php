@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title"  style="margin-top: 10px;">Edit Refinery</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
            &nbsp;
            {!! __html::back_button(['dashboard.refinery.index']) !!}
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.refinery.update', $refinery->slug) }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf   

            <input type="hidden" name="_method" value="PUT"> 

            {!! __form::textbox(
              '12', 'name', 'text', 'Name of Refinery *', 'Name of Refinery', old('name') ? old('name') : $refinery->name, $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address', 'text', 'Address *', 'Address', old('address') ? old('address') : $refinery->address, $errors->has('address'), $errors->first('address'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_second', 'text', 'Second Address', 'Second Address', old('address_second') ? old('address_second') : $refinery->address_second, $errors->has('address_second'), $errors->first('address_second'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_third', 'text', 'Third Address', 'Third Address', old('address_third') ? old('address_third') : $refinery->address_third, $errors->has('address_third'), $errors->first('address_third'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '6', 'tel_no', 'text', 'Tel No.', 'Tel No.', old('tel_no') ? old('tel_no') : $refinery->tel_no, $errors->has('tel_no'), $errors->first('tel_no'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'tel_no_second', 'text', 'Tel No. Second', 'Tel No. Second', old('tel_no_second') ? old('tel_no_second') : $refinery->tel_no_second, $errors->has('tel_no_second'), $errors->first('tel_no_second'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '6', 'fax_no', 'text', 'Fax No.', 'Fax No.', old('fax_no') ? old('fax_no') : $refinery->fax_no, $errors->has('fax_no'), $errors->first('fax_no'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'fax_no_second', 'text', 'Fax No. Second', 'Fax No. Second', old('fax_no_second') ? old('fax_no_second') : $refinery->fax_no_second, $errors->has('fax_no_second'), $errors->first('fax_no_second'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '4', 'officer', 'text', 'Officer', 'Officer', old('officer') ? old('officer') : $refinery->officer, $errors->has('officer'), $errors->first('officer'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'position', 'text', 'Position', 'Position', old('position') ? old('position') : $refinery->position, $errors->has('position'), $errors->first('position'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'salutation', 'text', 'Salutation', 'Salutation', old('salutation') ? old('salutation') : $refinery->salutation, $errors->has('salutation'), $errors->first('salutation'), ''
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
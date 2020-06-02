@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">Edit Trader License</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
          &nbsp;
          {!! __html::back_button(['dashboard.trader_registration.index']) !!}
        </div> 
      </div>
      
      <form method="POST" action="{{ route('dashboard.trader_registration.update', $trader_reg->slug) }}">

        <div class="box-body">
          <div class="col-md-12">

            <input name="_method" value="PUT" type="hidden">
                  
            @csrf   

            {!! __form::textbox(
              '4', 'control_no', 'text', 'Control No. *', 'Control No.', old('control_no') ? old('control_no') : $trader_reg->control_no, $errors->has('control_no'), $errors->first('control_no'), ''
            ) !!}

            {!! __form::select_dynamic(
              '4', 'trader_id', 'Trader *', old('trader_id') ? old('trader_id') : $trader_reg->trader_id, $global_traders_all, 'trader_id', 'name', $errors->has('trader_id'), $errors->first('trader_id'), 'select2', ''
            ) !!}

            {!! __form::select_dynamic(
              '4', 'trader_cat_id', 'Category *', old('trader_cat_id') ? old('trader_cat_id') : $trader_reg->trader_cat_id, $global_trader_categories_all, 'trader_cat_id', 'name', $errors->has('trader_cat_id'), $errors->first('trader_cat_id'), 'select2', ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::select_dynamic(
              '4', 'crop_year_id', 'Crop Year *', old('crop_year_id') ? old('crop_year_id') : $trader_reg->crop_year_id, $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', ''
            ) !!}

            {!! __form::datepicker(
              '4', 'reg_date',  'Date of Registration *', old('reg_date') ? old('reg_date') : $trader_reg->reg_date, $errors->has('reg_date'), $errors->first('reg_date')
            ) !!}

            {!! __form::textbox(
              '4', 'signatory', 'text', 'Signatory *', 'Signatory', old('signatory') ? old('signatory') : $trader_reg->signatory, $errors->has('signatory'), $errors->first('signatory'), ''
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
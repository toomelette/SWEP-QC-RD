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

      <form method="POST" action="{{ route('dashboard.trader_registration.store') }}">

        <div class="box-body">
          <div class="col-md-12">
            
            @if(Session::has('TRADER_REG_IS_EXIST'))
              {!! __html::alert('warning', '<i class="icon fa fa-ban"></i> Cannot submit data!', Session::get('TRADER_REG_IS_EXIST')) !!}
            @endif
                  
            @csrf   

            {!! __form::select_dynamic(
              '4', 'crop_year_id', 'Crop Year*', old('crop_year_id'), $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', ''
            ) !!}

            {!! __form::select_dynamic(
              '4', 'trader_cat_id', 'Category *', old('trader_cat_id'), $global_trader_categories_all, 'trader_cat_id', 'name', $errors->has('trader_cat_id'), $errors->first('trader_cat_id'), 'select2', ''
            ) !!}

            {!! __form::textbox(
              '4', 'control_no', 'text', 'Control No. *', 'Control No.', old('control_no'), $errors->has('control_no'), $errors->first('control_no'), 'data-transform="uppercase"'
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::select_dynamic(
              '11', 'trader_id', 'Trader *', old('trader_id'), $global_traders_all, 'trader_id', 'name', $errors->has('trader_id'), $errors->first('trader_id'), 'select2', ''
            ) !!}

            <div class="col-md-1" style="padding-top:24px;">
              <a href="#" id="add_trader" type="button" class="btn btn-default"><i class="fa fa-plus"></i></a>
            </div>

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '4', 'trader_officer', 'text', "Trader's Officer", "Trader's Officer", old('trader_officer'), $errors->has('trader_officer'), $errors->first('trader_officer'), ''
            ) !!}

            {!! __form::textbox(
              '4', 'trader_email', 'text', "Trader's Email", "Trader's Email", old('trader_email'), $errors->has('trader_email'), $errors->first('trader_email'), ''
            ) !!}

            {!! __form::datepicker(
              '4', 'reg_date',  'Date of Registration *', old('reg_date') ? old('reg_date') : Carbon::now()->format('m/d/Y'), $errors->has('reg_date'), $errors->first('reg_date')
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



@section('modals')

  {{-- Add Modal --}}
  <div class="modal fade bs-example-modal-lg" id="add_trader_modal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">

          <form id="trader_create" method="POST" action="{{ route('dashboard.trader.store_from_tr') }}">

            <div class="row">
                  
              @csrf   

              <input type="hidden" id="tr_crop_year_id" name="crop_year_id">
              <input type="hidden" id="tr_trader_cat_id" name="trader_cat_id">
              <input type="hidden" id="tr_control_no" name="control_no">

              {!! __form::textbox(
                '12', 'tr_name', 'text', 'Name *', 'Name', old('tr_name'), $errors->has('tr_name'), $errors->first('tr_name'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox(
                '6', 'tr_tin', 'text', 'TIN *', 'TIN', old('tr_tin'), $errors->has('tr_tin'), $errors->first('tr_tin'), ''
              ) !!}

              {!! __form::select_dynamic(
                '6', 'tr_region_id', 'Region *', old('tr_region_id') ? old('tr_region_id') : '', $global_regions_all, 'region_id', 'name', $errors->has('tr_region_id'), $errors->first('tr_region_id'), 'select2', 'style="width:100%;"'
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox(
                '6', 'tr_address', 'text', 'Address *', 'Address', old('tr_address'), $errors->has('tr_address'), $errors->first('tr_address'), ''
              ) !!}

              {!! __form::textbox(
                '6', 'tr_address_second', 'text', 'Second Address', 'Second Address', old('tr_address_second'), $errors->has('tr_address_second'), $errors->first('tr_address_second'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox(
                '4', 'tr_tel_no', 'text', 'Tel No.', 'Tel No.', old('tr_tel_no'), $errors->has('tr_tel_no'), $errors->first('tr_tel_no'), ''
              ) !!}

              {!! __form::textbox(
                '4', 'tr_officer', 'text', 'Officer', 'Officer', old('tr_officer'), $errors->has('tr_officer'), $errors->first('tr_officer'), ''
              ) !!}

              {!! __form::textbox(
                '4', 'tr_email', 'text', 'Email', 'Email', old('tr_email'), $errors->has('tr_email'), $errors->first('tr_email'), ''
              ) !!}

            </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>
        </form>
      </div>
    </div>
  </div>


  {{-- TR CREATE SUCCESS --}}
  @if(Session::has('TRADER_REG_CREATE_SUCCESS'))

    {!! __html::modal_print(
      'tr_create', '<i class="fa fa-fw fa-check"></i> Saved!', Session::get('TRADER_REG_CREATE_SUCCESS'), route('dashboard.trader_registration.show', Session::get('TRADER_REG_CREATE_SUCCESS_SLUG'))
    ) !!}

  @endif

@endsection 



@section('scripts')

  <script type="text/javascript">

  
    @if(Session::has('TRADER_REG_CREATE_SUCCESS'))
      $('#tr_create').modal('show');
    @endif


    {!! __js::ajax_select_to_input('trader_id', 
                                   'trader_officer', 
                                   '/api/trader/select_trader_byTraderId/', 
                                   'officer'); 
    !!}


    {!! __js::ajax_select_to_input('trader_id', 
                                   'trader_email', 
                                   '/api/trader/select_trader_byTraderId/', 
                                   'email'); 
    !!}


    @if(Session::has('TRADER_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('TRADER_CREATE_SUCCESS')) !!}
    @endif


    // Add Trader Button Action
    $(document).on("click", "#add_trader", function () {
      $('#tr_region_id').select2().select2("val", null);;
      $("#add_trader_modal").modal("show");
    });


    // Update Button Action
    $('#trader_create').submit(function() {
      $('#tr_crop_year_id').val($('#crop_year_id').val());
      $('#tr_trader_cat_id').val($('#trader_cat_id').val());
      $('#tr_control_no').val($('#control_no').val());
    });


  </script>
    
@endsection
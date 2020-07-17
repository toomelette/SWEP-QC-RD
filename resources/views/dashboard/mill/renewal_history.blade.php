<?php

  $table_sessions = [
    Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG'),
    Session::get('MILL_REG_IS_EXIST_SLUG'),
  ];

  $appended_requests = [
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Mill Renewal History ({{ $mill->name }})</h1>
      <div class="pull-right">
        <a href="{{ route('dashboard.mill.index') }}" class="btn btn-md btn-default" style="margin-top: -45px;">
          <i class="fa fa-fw fa-arrow-left"></i>&nbsp;Back to List
        </a>
      </div> 
  </section>

  <section class="content">

      {{-- Form Start --}}
      <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.mill.renewal_history', $mill->slug) }}">

      <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.mill.renewal_history', $mill->slug)) !!}
      </div>

      {{-- Form End --}}  
      </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('cropYear.name', 'Crop Year')</th>
            <th>@sortablelink('license_no', 'License No')</th>
            <th>@sortablelink('reg_date', 'Date of Registration')</th>
            <th>Action</th>
          </tr>
          @foreach($mill_reg_list as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ optional($data->cropYear)->name }}</td>
              <td id="mid-vert">{{ $data->license_no }}</td>
              <td id="mid-vert">{{ __dataType::date_parse($data->reg_date, 'F d,Y') }}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.mill_registration.show', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="show_button" href="{{ route('dashboard.mill_registration.show', $data->slug) }}">
                      <i class="fa fa-eye"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.mill_registration.update', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default" 
                       id="update_button"  
                       data-crop_year_id="{{ $data->crop_year_id }}"
                       data-reg_date="{{ __dataType::date_parse($data->reg_date, 'm/d/Y') }}"
                       data-mt="{{ $data->mt }}"
                       data-lkg="{{ $data->lkg }}"
                       data-milling_fee="{{ $data->milling_fee }}"
                       data-payment_status="{{ $data->payment_status }}"
                       data-under_payment="{{ $data->under_payment }}"
                       data-excess_payment="{{ $data->excess_payment }}"
                       data-balance_fee="{{ $data->balance_fee }}"
                       data-rated_capacity="{{ $data->rated_capacity }}"
                       data-start_milling="{{ __dataType::date_parse($data->start_milling, 'm/d/Y') }}"
                       data-end_milling="{{ __dataType::date_parse($data->end_milling, 'm/d/Y') }}"
                       data-planter_share="{{ $data->planter_share }}"
                       data-mill_share="{{ $data->mill_share }}"
                       data-other_share="{{ $data->other_share }}"
                       data-action="update" 
                       data-url="{{ route('dashboard.mill_registration.update', $data->slug) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.mill_registration.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.mill_registration.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </table>
      </div>

      @if($mill_reg_list->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($mill_reg_list) !!}
        {!! $mill_reg_list->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection







@section('modals')


  {!! __html::modal_delete('mill_registration_delete') !!}


  {{-- TR UPDATE SUCCESS --}}
  @if(Session::has('MILL_RENEW_LICENSE_SUCCESS'))

    <div class="modal fade" id="mill_renew_success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-fw fa-check"></i> Saved!</h4>
          </div>
          <div class="modal-body">
            <p><p style="font-size: 17px;">The License has been successfully updated!</p></p>
          </div>
          <div class="modal-footer">

            @if (in_array('dashboard.mill_registration.dl_cover', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_cover', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> Cover Letter
              </a>
            @endif

            @if (in_array('dashboard.mill_registration.dl_billing', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_billing', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> Billing Statement
              </a>
            @endif

            @if (in_array('dashboard.mill_registration.dl_license', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_license', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> License
              </a>
            @endif

            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

          </div>
        </div>
      </div>
    </div>

  @endif


  {{-- MILL IS EXIST --}}  
  @if(Session::has('MILL_REG_IS_EXIST'))
    <div class="modal fade modal-danger" data-backdrop="static" id="mill_is_exist">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">
              <i class="fa fa-exclamation-triangle"></i> 
              &nbsp;Whoops!
            </h4>
          </div>
          <div class="modal-body">
            <p style="font-size: 17px;">
              {{ Session::get('MILL_REG_IS_EXIST') }}
            </p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-outline" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  @endif


  {{-- RENEW LICENSE FORM --}}
  <div class="modal fade" id="mill_rl" data-backdrop="static">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <i class="fa fa-certificate"></i> &nbsp;Edit License
            <div class="pull-right">
              <code>Fields with asterisks(*) are required</code>
            </div> 
          </h4>
        </div>
        <div class="modal-body" id="mill_rl_body">

          <form method="POST" id="mill_rl_form" autocomplete="off">
            
            @csrf

            <div class="row">

              <input type="hidden" name="_method" value="PUT">

              {!! __form::select_dynamic(
                '6', 'crop_year_id', 'Crop Year', '', $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', 'style="width:100%; "required'
              ) !!}

              {!! __form::datepicker(
                '6', 'reg_date',  'Date of Registration *', '', $errors->has('reg_date'), $errors->first('reg_date')
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'mt', 'text', 'MT *', 'MT', '', $errors->has('mt'), $errors->first('mt'), 'required'
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'lkg', 'text', 'LKG *', 'LKG', '', $errors->has('lkg'), $errors->first('lkg'), 'required'
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'milling_fee', 'text', 'Milling Fee *', 'Milling Fee', '', $errors->has('milling_fee'), $errors->first('milling_fee'), 'required'
              ) !!}

              {!! __form::select_static(
                '6', 'payment_status', 'Payment Status *', '', ['Underpayment' => 'UP', 'Excess Payment ' => 'EP'], $errors->has('payment_status'), $errors->first('payment_status'), 'select2', 'style="width:100%;" required'
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'under_payment', 'text', 'Underpayment', 'Underpayment', '', $errors->has('under_payment'), $errors->first('under_payment'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'excess_payment', 'text', 'Excess Payment', 'Excess Payment', '00' , $errors->has('excess_payment'), $errors->first('excess_payment'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'balance_fee', 'text', 'Balance', 'Balance', '', $errors->has('balance_fee'), $errors->first('balance_fee'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'rated_capacity', 'text', 'Rated Capacity', 'Rated Capacity', '', $errors->has('rated_capacity'), $errors->first('rated_capacity'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::datepicker(
                '6', 'start_milling',  'Start of Milling', '', $errors->has('start_milling'), $errors->first('start_milling')
              ) !!}

              {!! __form::datepicker(
                '6', 'end_milling',  'End of Milling', '', $errors->has('end_milling'), $errors->first('end_milling')
              ) !!}


              <div class="col-md-12 no-padding">

                <div class="col-md-12">
                  <h4>Mill Share</h4>
                </div>

                <div class="col-md-12">

                  {!! __form::textbox_numeric(
                    '6', 'planter_share', 'text', 'Planter (%)', 'Planter (%)', '' , $errors->has('planter_share'), $errors->first('planter_share'), ''
                  ) !!}

                  {!! __form::textbox_numeric(
                    '6', 'mill_share', 'text', 'Mill (%)', 'Mill (%)', '' , $errors->has('mill_share'), $errors->first('mill_share'), ''
                  ) !!}
                  
                  <div class="col-md-12"></div>

                  {!! __form::textbox(
                    '12', 'other_share', 'text', 'Others (%)', 'Others (%)', '' , $errors->has('other_share'), $errors->first('other_share'), ''
                  ) !!}
                  
                </div>
                
              </div>

            </div>

          </div>

          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save <i class="fa fa-fw fa-save"></i></button>
          </form>

        </div>
      </div>
    </div>
  </div>

@endsection 







@section('scripts')

  <script type="text/javascript">


    {!! __js::button_modal_confirm_delete_caller('mill_registration_delete') !!}


    // ONCLICK UPDATE BUTTON
    $(document).on("click", "#update_button", function () {

      $('.select2').select2();

      $('.datepicker').each(function(){
          $(this).datepicker({
              autoclose: true,
              dateFormat: "mm/dd/yy",
              orientation: "bottom"
          });
      });

      if($(this).data("action") == "update"){

        $("#mill_rl").modal("show");
        $("#mill_rl_body #mill_rl_form").attr("action", $(this).data("url"));

        $("#mill_rl_form #crop_year_id").val($(this).data("crop_year_id")).change();
        $("#mill_rl_form #reg_date").val($(this).data("reg_date"));
        $("#mill_rl_form #mt").val($(this).data("mt"));
        $("#mill_rl_form #lkg").val($(this).data("lkg"));
        $("#mill_rl_form #milling_fee").val($(this).data("milling_fee"));
        $("#mill_rl_form #payment_status").val($(this).data("payment_status")).change();
        $("#mill_rl_form #under_payment").val($(this).data("under_payment"));
        $("#mill_rl_form #excess_payment").val($(this).data("excess_payment"));
        $("#mill_rl_form #balance_fee").val($(this).data("balance_fee"));
        $("#mill_rl_form #rated_capacity").val($(this).data("rated_capacity"));
        $("#mill_rl_form #start_milling").val($(this).data("start_milling"));
        $("#mill_rl_form #end_milling").val($(this).data("end_milling"));
        $("#mill_rl_form #planter_share").val($(this).data("planter_share"));
        $("#mill_rl_form #mill_share").val($(this).data("mill_share"));
        $("#mill_rl_form #other_share").val($(this).data("other_share"));

        if($(this).data("payment_status") == "E"){
          $("#excess_payment").attr('disabled','disabled');
          $("#under_payment").attr('disabled','disabled');
        }else if($(this).data("payment_status") == "UP"){
          $("#excess_payment").attr('disabled','disabled');
        }else if($(this).data("payment_status") == "EP"){
          $("#under_payment").attr('disabled','disabled');
        }

        $(".priceformat").priceFormat({
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: true
        });
        
      }

    });


    // ONCLICK SELECT DISABLE
    $('#payment_status').on('select2:select', function (e) {
      val = $(this).val();
      if(val == "UP"){
        $("#excess_payment").attr('disabled','disabled').val('');
        $("#under_payment").removeAttr("disabled").val('');
        $("#balance_fee").val(0);
      }else if(val == "EP"){
        $("#under_payment").attr('disabled','disabled').val('');
        $("#excess_payment").removeAttr("disabled").val('');
        $("#balance_fee").val(0);
      }else{
        $("#excess_payment").removeAttr("disabled").val('');
        $("#under_payment").removeAttr("disabled").val('');
        $("#balance_fee").val(0);
      }
    });


    // SET KEYUP DELAY
    function delay(callback, ms) {
      var timer = 0;
      return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
          callback.apply(context, args);
        }, ms || 0);
      };
    }


    // INSTANTIATE PRICEFORMAT
    function pf(id) {
      $(id).priceFormat({
        prefix: "",
        thousandsSeparator: ",",
        clearOnEmpty: true,
        allowNegative: true
      });
    }


    // ON FILL UNDERPAYMENT
    $('#under_payment').keyup(delay(function() { 
      balance_fee = 0;
      if ($('#milling_fee').val() != ""){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        underpayment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        up_float = parseFloat(underpayment);
        balance_fee = mf_float - up_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#under_payment').keydown(delay(function() {
      balance_fee = 0;
      if ($('#milling_fee').val() != ""){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        underpayment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        up_float = parseFloat(underpayment);
        balance_fee = mf_float - up_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


    // ON FILL EXCESS PAYMENT
    $('#excess_payment').keyup(delay(function() { 
      balance_fee = 0;
      if ($('#milling_fee').val() != ""){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#excess_payment').keydown(delay(function() {
      balance_fee = 0;
      if ($('#milling_fee').val() != ""){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


     // ON FILL MILLING FEE
    $('#milling_fee').keyup(delay(function() {
      balance_fee = 0;
      if ($('#payment_status').val() == "UP"){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        under_payment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        up_float = parseFloat(under_payment);
        balance_fee = mf_float - up_float;
      }else if($('#payment_status').val() == "EP"){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }else{
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        balance_fee = mf_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#milling_fee').keydown(delay(function() {
      balance_fee = 0;
      if ($('#payment_status').val() == "UP"){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        under_payment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        up_float = parseFloat(under_payment);
        balance_fee = mf_float - up_float;
      }else if($('#payment_status').val() == "EP"){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }else{
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        balance_fee = mf_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


    // TOAST NOTIFICATION
    @if(Session::has('MILL_REG_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_REG_DELETE_SUCCESS')) !!}
    @endif

    @if(Session::has('MILL_RENEW_LICENSE_SUCCESS'))
      $('#mill_renew_success').modal('show');
    @endif

    @if(Session::has('MILL_REG_IS_EXIST'))
      $('#mill_is_exist').modal('show');
    @endif

  </script>
    
@endsection
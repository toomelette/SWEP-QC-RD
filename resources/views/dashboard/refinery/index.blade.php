<?php

  $table_sessions = [ 
    Session::get('REFINERY_UPDATE_SUCCESS_SLUG'),
    Session::get('REFINERY_RENEW_LICENSE_SUCCESS_SLUG'),
    Session::get('REFINERY_REG_IS_EXIST_SLUG'),
  ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Refinery List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" action="{{ route('dashboard.refinery.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.refinery.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

    {{-- Table Grid --}}        
    <div class="box-body no-padding">
      <table class="table table-hover">
        <tr>
          <th>@sortablelink('name', 'Name')</th>
          <th>@sortablelink('', 'Status')</th>
          <th style="width: 400px">Action</th>
        </tr>
        @foreach($refineries as $data) 
          <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
            <td id="mid-vert">{{ $data->name }}</td>
            <td id="mid-vert">
              {!! $data->displayLicensesStatusSpan($global_current_cy->crop_year_id) !!}
            </td>
            <td id="mid-vert">
              <div class="btn-group">
                @if(in_array('dashboard.refinery.renew_license_post', $global_user_submenus))
                  <a type="button" 
                     class="btn btn-default" 
                     @if ($data->licensesStatus($global_current_cy->crop_year_id) == false)
                       id="rl_button" 
                       data-action="rl" 
                       data-url="{{ route('dashboard.refinery.renew_license_post', $data->slug) }}"
                     @else
                       disabled
                     @endif
                  >
                    <i class="fa fa-certificate"></i>&nbsp; Renew License
                  </a>
                @endif
                @if(in_array('dashboard.refinery.renewal_history', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="rh_button" href="{{ route('dashboard.refinery.renewal_history', $data->slug) }}">
                    <i class="fa fa-tasks"></i>&nbsp; Renewal History
                  </a>
                @endif
                @if(in_array('dashboard.refinery.edit', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.refinery.edit', $data->slug) }}">
                    <i class="fa fa-pencil"></i>
                  </a>
                @endif
                @if(in_array('dashboard.refinery.destroy', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.refinery.destroy', $data->slug) }}">
                    <i class="fa fa-trash"></i>
                  </a>
                @endif
              </div>
            </td>
          </tr>
        @endforeach
        </table>
      </div>

      @if($refineries->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($refineries) !!}
        {!! $refineries->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection







@section('modals')


  {!! __html::modal_delete('refinery_delete') !!}


  {{-- TR UPDATE SUCCESS --}}
  @if(Session::has('REFINERY_RENEW_LICENSE_SUCCESS'))

    <div class="modal fade" id="refinery_renew_success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-fw fa-check"></i> Saved!</h4>
          </div>
          <div class="modal-body">
            <p><p style="font-size: 17px;">{{ Session::get('REFINERY_RENEW_LICENSE_SUCCESS') }}</p></p>
          </div>
          <div class="modal-footer">

            @if (in_array('dashboard.refinery_registration.dl_cover', $global_user_submenus))
              <a href="{{ route('dashboard.refinery_registration.dl_cover', Session::get('REFINERY_RENEW_LICENSE_SUCCESS_RR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> Cover Letter
              </a>
            @endif

            @if (in_array('dashboard.refinery_registration.dl_license', $global_user_submenus))
              <a href="{{ route('dashboard.refinery_registration.dl_license', Session::get('REFINERY_RENEW_LICENSE_SUCCESS_RR_SLUG')) }}" 
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


  {{-- REFINERY IS EXIST --}}  
  @if(Session::has('REFINERY_REG_IS_EXIST'))
    <div class="modal fade modal-danger" data-backdrop="static" id="refinery_is_exist">
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
              {{ Session::get('REFINERY_REG_IS_EXIST') }}
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
  <div class="modal fade" id="refinery_rl" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <i class="fa fa-certificate"></i> &nbsp;Refinery License Renewal
          </h4>
        </div>
        <div class="modal-body" id="rl_body">
          <p>Crop Year: {{ $global_current_cy->name }}</p>
          <form method="POST" id="form" autocomplete="off">
            
            @csrf

            <div class="row">

              <input type="hidden" name="crop_year_id" value="{{ $global_current_cy->crop_year_id }}">

              {!! __form::textbox(
                '12', 'license_no', 'text', 'License No.', 'License No.', old('license_no'), $errors->has('license_no'), $errors->first('license_no'), 'data-transform="uppercase" required'
              ) !!}

              {!! __form::datepicker(
                '12', 'reg_date',  'Date of Registration', old('reg_date') ? old('reg_date') : Carbon::now()->format('m/d/Y'), $errors->has('reg_date'), $errors->first('reg_date')
              ) !!}

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


    {!! __js::button_modal_confirm_delete_caller('refinery_delete') !!}


    // ON CLICK APPEAR MODAL
    $(document).on("click", "#rl_button", function () {
      if($(this).data("action") == "rl"){
        $('.select2').select2();
        $('.datepicker').each(function(){
            $(this).datepicker({
                autoclose: true,
                dateFormat: "mm/dd/yy",
                orientation: "bottom"
            });
        });
        $(".priceformat").priceFormat({
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: true
        });
        $("#refinery_rl").modal("show");
        $("#rl_body #form").attr("action", $(this).data("url"));
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
      if ($('#refinerying_fee').val() != ""){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        underpayment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        up_float = parseFloat(underpayment);
        balance_fee = mf_float - up_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#under_payment').keydown(delay(function() {
      balance_fee = 0;
      if ($('#refinerying_fee').val() != ""){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        underpayment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        up_float = parseFloat(underpayment);
        balance_fee = mf_float - up_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


    // ON FILL EXCESS PAYMENT
    $('#excess_payment').keyup(delay(function() { 
      balance_fee = 0;
      if ($('#refinerying_fee').val() != ""){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#excess_payment').keydown(delay(function() {
      balance_fee = 0;
      if ($('#refinerying_fee').val() != ""){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


     // ON FILL REFINERYING FEE
    $('#refinerying_fee').keyup(delay(function() {
      balance_fee = 0;
      if ($('#payment_status').val() == "UP"){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        under_payment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        up_float = parseFloat(under_payment);
        balance_fee = mf_float - up_float;
      }else if($('#payment_status').val() == "EP"){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }else{
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        balance_fee = mf_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#refinerying_fee').keydown(delay(function() {
      balance_fee = 0;
      if ($('#payment_status').val() == "UP"){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        under_payment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        up_float = parseFloat(under_payment);
        balance_fee = mf_float - up_float;
      }else if($('#payment_status').val() == "EP"){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }else{
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        balance_fee = mf_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


    // TOAST
    @if(Session::has('REFINERY_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('REFINERY_UPDATE_SUCCESS')) !!}
    @endif

    @if(Session::has('REFINERY_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('REFINERY_DELETE_SUCCESS')) !!}
    @endif

    @if(Session::has('REFINERY_RENEW_LICENSE_SUCCESS'))
      $('#refinery_renew_success').modal('show');
    @endif

    @if(Session::has('REFINERY_REG_IS_EXIST'))
      $('#refinery_is_exist').modal('show');
    @endif


  </script>
    
@endsection
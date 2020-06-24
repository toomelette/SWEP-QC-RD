<?php

  $table_sessions = [ 
    Session::get('MILL_UPDATE_SUCCESS_SLUG'),
    Session::get('MILL_RENEW_LICENSE_SUCCESS_SLUG'),
    Session::get('MILL_REG_IS_EXIST_SLUG'),
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
      <h1>Mill List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" action="{{ route('dashboard.mill.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.mill.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

    {{-- Table Grid --}}        
    <div class="box-body no-padding">
      <table class="table table-hover">
        <tr>
          <th>@sortablelink('name', 'Name')</th>
          <th style="width: 400px">Action</th>
        </tr>
        @foreach($mills as $data) 
          <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
            <td id="mid-vert">{{ $data->name }}</td>
            <td id="mid-vert">
              <div class="btn-group">
                @if(in_array('dashboard.mill.renew_license_post', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="rl_button" data-action="rl" data-url="{{ route('dashboard.mill.renew_license_post', $data->slug) }}">
                    <i class="fa fa-certificate"></i>&nbsp; Renew License
                  </a>
                @endif
                @if(in_array('dashboard.mill.renewal_history', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="rh_button" href="{{ route('dashboard.mill.renewal_history', $data->slug) }}">
                    <i class="fa fa-tasks"></i>&nbsp; Renewal History
                  </a>
                @endif
                @if(in_array('dashboard.mill.edit', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.mill.edit', $data->slug) }}">
                    <i class="fa fa-pencil"></i>
                  </a>
                @endif
                @if(in_array('dashboard.mill.destroy', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.mill.destroy', $data->slug) }}">
                    <i class="fa fa-trash"></i>
                  </a>
                @endif
              </div>
            </td>
          </tr>
        @endforeach
        </table>
      </div>

      @if($mills->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($mills) !!}
        {!! $mills->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection







@section('modals')


  {!! __html::modal_delete('mill_delete') !!}


  {{-- TR UPDATE SUCCESS --}}
  {{-- @if(Session::has('MILL_RENEW_LICENSE_SUCCESS'))

    <div class="modal fade" id="mill_renew_success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-fw fa-check"></i> Saved!</h4>
          </div>
          <div class="modal-body">
            <p><p style="font-size: 17px;">{{ Session::get('MILL_RENEW_LICENSE_SUCCESS') }}</p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            @if (in_array('dashboard.mill_registration.dl_word_file', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_word_file', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                Download Word File
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

  @endif --}}


  {{-- MILL IS EXIST --}}  
  {{-- @if(Session::has('MILL_REG_IS_EXIST'))
    <div class="modal fade modal-danger" data-backdrop="static" id="tr_is_exist">
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
  @endif --}}


  {{-- RENEW LICENSE FORM --}}
  <div class="modal fade" id="mill_rl" data-backdrop="static">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <i class="fa fa-certificate"></i> &nbsp;Mill License Renewal
            <div class="pull-right">
              <code>Fields with asterisks(*) are required</code>
            </div> 
          </h4>
        </div>
        <div class="modal-body" id="rl_body">
          <p>Crop Year: {{ $global_current_cy->name }}</p>
          <form method="POST" id="form" autocomplete="off">
            
            @csrf

            <div class="row">

              <input type="hidden" name="crop_year_id" value="{{ $global_current_cy->crop_year_id }}">

              {!! __form::textbox(
                '6', 'license_no', 'text', 'License No. *', 'License No.', old('license_no'), $errors->has('license_no'), $errors->first('license_no'), 'data-transform="uppercase" required'
              ) !!}

              {!! __form::datepicker(
                '6', 'reg_date',  'Date of Registration *', old('reg_date') ? old('reg_date') : Carbon::now()->format('m/d/Y'), $errors->has('reg_date'), $errors->first('reg_date')
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'mt', 'text', 'MT *', 'MT', old('mt') , $errors->has('mt'), $errors->first('mt'), 'required'
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'lkg', 'text', 'LKG *', 'LKG', old('lkg') , $errors->has('lkg'), $errors->first('lkg'), 'required'
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'milling_fee', 'text', 'Milling Fee *', 'Milling Fee', old('milling_fee') , $errors->has('milling_fee'), $errors->first('milling_fee'), 'required'
              ) !!}

              {!! __form::select_static(
                '6', 'payment_status', 'Payment Status', old('payment_status'), ['Exact' => 'E', 'Underpayment' => 'UP', 'Excess Payment ' => 'EP'], $errors->has('payment_status'), $errors->first('payment_status'), 'select2', 'style="width:100%;"'
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'under_payment', 'text', 'Underpayment', 'Underpayment', old('under_payment') , $errors->has('under_payment'), $errors->first('under_payment'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'excess_payment', 'text', 'Excess Payment', 'Excess Payment', '00' , $errors->has('excess_payment'), $errors->first('excess_payment'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'balance_fee', 'text', 'Balance', 'Balance', old('balance_fee') , $errors->has('balance_fee'), $errors->first('balance_fee'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'rated_capacity', 'text', 'Rated Capacity', 'Rated Capacity', old('rated_capacity') , $errors->has('rated_capacity'), $errors->first('rated_capacity'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::datepicker(
                '6', 'start_milling',  'Start of Milling', old('start_milling'), $errors->has('start_milling'), $errors->first('start_milling')
              ) !!}

              {!! __form::datepicker(
                '6', 'end_milling',  'End of Milling', old('end_milling'), $errors->has('end_milling'), $errors->first('end_milling')
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


    {!! __js::button_modal_confirm_delete_caller('mill_delete') !!}


    $(document).on("click", "#rl_button", function () {

      if($(this).data("action") == "rl"){

        // Select2
        $('.select2').select2();

        // Date Picker
        $('.datepicker').each(function(){
            $(this).datepicker({
                autoclose: true,
                dateFormat: "mm/dd/yy",
                orientation: "bottom"
            });
        });

        // Number Format
        $(".priceformat").priceFormat({
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: true
        });

        $("#mill_rl").modal("show");
        $("#rl_body #form").attr("action", $(this).data("url"));
        
      }

    });


    $('#payment_status').on('select2:select', function (e) {
        
      val = $(this).val();
      
      if(val == "E"){
        $("#excess_payment").attr('disabled','disabled').val('');
        $("#under_payment").attr('disabled','disabled').val('');
      }else if(val == "UP"){
        $("#excess_payment").attr('disabled','disabled').val('');
        $("#under_payment").removeAttr("disabled").val('');
      }else if(val == "EP"){
        $("#under_payment").attr('disabled','disabled').val('');
        $("#excess_payment").removeAttr("disabled").val('');
      }else{
        $("#excess_payment").removeAttr("disabled").val('');
        $("#under_payment").removeAttr("disabled").val('');
      }

    });


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


    $('#excess_payment').keyup(delay(function() {
      milling_fee = $('#milling_fee').val().replace(/,/g, "");
      excess_payment = $('#excess_payment').val().replace(/,/g, "");
      mf_float = parseFloat(milling_fee).toFixed(2);
      console.log(mf_float);
      ep_float = parseFloat(excess_payment).toFixed(2);
      balance_fee = mf_float + ep_float;
      $('#balance_fee').val(balance_fee.toFixed(2));
    }, 50));


    @if(Session::has('MILL_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_UPDATE_SUCCESS')) !!}
    @endif


    @if(Session::has('MILL_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_DELETE_SUCCESS')) !!}
    @endif


    @if(Session::has('MILL_RENEW_LICENSE_SUCCESS'))
      $('#mill_renew_success').modal('show');
    @endif


    @if(Session::has('MILL_REG_IS_EXIST'))
      $('#tr_is_exist').modal('show');
    @endif


  </script>
    
@endsection
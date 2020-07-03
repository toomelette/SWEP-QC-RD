<?php

  $table_sessions = [ 
    Session::get('TRADER_UPDATE_SUCCESS_SLUG'),
    Session::get('TRADER_RENEW_LICENSE_SUCCESS_SLUG'),
    Session::get('TRADER_REG_IS_EXIST_SLUG'),
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
      <h1>Traders</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" action="{{ route('dashboard.trader.index') }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.trader.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('name', 'Name')</th>
            <th>Licenses</th>
            <th style="width: 500px">Action</th>
          </tr>
          @foreach($traders as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->name }}</td>
              <td id="mid-vert">{!! $data->currentCropYearLicenses($global_current_cy->crop_year_id) !!}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.trader.files', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="files_button" href="{{ route('dashboard.trader.files', $data->slug) }}">
                      <i class="fa fa-file-text-o"></i>&nbsp; Files
                    </a>
                  @endif
                  @if(in_array('dashboard.trader.renew_license_post', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="rl_button" data-action="rl" data-url="{{ route('dashboard.trader.renew_license_post', $data->slug) }}">
                      <i class="fa fa-certificate"></i>&nbsp; Renew License
                    </a>
                  @endif
                  @if(in_array('dashboard.trader.renewal_history', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="rh_button" href="{{ route('dashboard.trader.renewal_history', $data->slug) }}">
                      <i class="fa fa-tasks"></i>&nbsp; Renewal History
                    </a>
                  @endif
                  @if(in_array('dashboard.trader.edit', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.trader.edit', $data->slug) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.trader.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.trader.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
          </table>
      </div>

      @if($traders->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($traders) !!}
        {!! $traders->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection







@section('modals')


  {!! __html::modal_delete('trader_delete') !!}


  {{-- TR UPDATE SUCCESS --}}
  @if(Session::has('TRADER_RENEW_LICENSE_SUCCESS'))

    <div class="modal fade" id="trader_renew_success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-fw fa-check"></i> Saved!</h4>
          </div>
          <div class="modal-body">
            <p><p style="font-size: 17px;">{{ Session::get('TRADER_RENEW_LICENSE_SUCCESS') }}</p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            @if (in_array('dashboard.trader_registration.dl_word_file', $global_user_submenus))
              <a href="{{ route('dashboard.trader_registration.dl_word_file', Session::get('TRADER_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> License
              </a>
            @endif
          </div>
        </div>
      </div>
    </div>

  @endif


  {{-- TRADER IS EXIST --}}  
  @if(Session::has('TRADER_REG_IS_EXIST'))
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
              {{ Session::get('TRADER_REG_IS_EXIST') }}
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
  <div class="modal fade" id="trader_rl" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">
            <i class="fa fa-certificate"></i> &nbsp;Trader's License Renewal
          </h4>
        </div>
        <div class="modal-body" id="rl_body">
          <p>Crop Year: {{ $global_current_cy->name }}</p>
          <form method="POST" id="form" autocomplete="off">
            
            @csrf

            <div class="row">

              <input type="hidden" name="crop_year_id" value="{{ $global_current_cy->crop_year_id }}">

              {!! __form::select_dynamic(
                '12', 'trader_cat_id', 'Category', old('trader_cat_id'), $global_trader_categories_all, 'trader_cat_id', 'name', $errors->has('trader_cat_id'), $errors->first('trader_cat_id'), 'select2', 'style="width:100%; "required'
              ) !!}

              {!! __form::textbox(
                '12', 'control_no', 'text', 'Control No.', 'Control No.', old('control_no'), $errors->has('control_no'), $errors->first('control_no'), 'data-transform="uppercase" required'
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

    {!! __js::button_modal_confirm_delete_caller('trader_delete') !!}

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

        $("#trader_rl").modal("show");
        $("#rl_body #form").attr("action", $(this).data("url"));
        
      }

    });

    @if(Session::has('TRADER_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('TRADER_UPDATE_SUCCESS')) !!}
    @endif

    @if(Session::has('TRADER_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('TRADER_DELETE_SUCCESS')) !!}
    @endif

    @if(Session::has('TRADER_RENEW_LICENSE_SUCCESS'))
      $('#trader_renew_success').modal('show');
    @endif

    @if(Session::has('TRADER_REG_IS_EXIST'))
      $('#tr_is_exist').modal('show');
    @endif

  </script>
    
@endsection
<?php

  $table_sessions = [
    Session::get('TRADER_RENEW_LICENSE_SUCCESS_TR_SLUG'),
    Session::get('TRADER_REG_IS_EXIST_SLUG'),
  ];

  $appended_requests = [
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Trader Renewal History</h1>
  </section>

  <section class="content">

      {{-- Form Start --}}
      <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.trader.index') }}">

      <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

        {{-- Table Search --}}        
        <div class="box-header with-border">
          <div class="pull-right">
            <a href="{{ route('dashboard.trader.index') }}" class="btn btn-sm btn-default">Back to List</a>
          </div> 
        </div>

      {{-- Form End --}}  
      </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('cropYear.name', 'Crop Year')</th>
            <th>@sortablelink('traderCategory.name', 'Trader Category')</th>
            <th>@sortablelink('control_no', 'Control No')</th>
            <th>@sortablelink('reg_date', 'Date of Registration')</th>
            <th>Action</th>
          </tr>
          @foreach($trader_reg_list as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ optional($data->cropYear)->name }}</td>
              <td id="mid-vert">{{ optional($data->traderCategory)->name }}</td>
              <td id="mid-vert">{{ $data->control_no }}</td>
              <td id="mid-vert">{{ __dataType::date_parse($data->reg_date, 'F d,Y') }}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.trader_registration.show', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="show_button" href="{{ route('dashboard.trader_registration.show', $data->slug) }}">
                      <i class="fa fa-eye"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.trader_registration.update', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default" 
                       id="update_button" 
                       data-crop_year_id="{{ $data->crop_year_id }}" 
                       data-trader_cat_id="{{ $data->trader_cat_id }}"
                       data-control_no="{{ $data->control_no }}"
                       data-reg_date="{{ __dataType::date_parse($data->reg_date, 'm/d/Y') }}"
                       data-action="update" 
                       data-url="{{ route('dashboard.trader_registration.update', $data->slug) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.trader_registration.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.trader_registration.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </table>
      </div>

      @if($trader_reg_list->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($trader_reg_list) !!}
        {!! $trader_reg_list->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection







@section('modals')


  {!! __html::modal_delete('trader_registration_delete') !!}


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
  <div class="modal fade" id="update_trader_reg" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">
            <i class="fa fa-certificate"></i> &nbsp;Edit License
          </h4>
        </div>
        <div class="modal-body" id="update_trader_reg_body">
          <p>Crop Year: {{ $global_current_cy->name }}</p>
          <form method="POST" id="update_trader_reg_form" autocomplete="off">
            
            @csrf

            <input name="_method" value="PUT" type="hidden">

            <div class="row">

              <input type="hidden" name="crop_year_id" id="crop_year_id">

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

@endsection 







@section('scripts')

  <script type="text/javascript">

    {!! __js::button_modal_confirm_delete_caller('trader_registration_delete') !!}

    $(document).on("click", "#update_button", function () {

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

      if($(this).data("action") == "update"){

        $("#update_trader_reg").modal("show");
        $("#update_trader_reg_body #update_trader_reg_form").attr("action", $(this).data("url"));

        $("#update_trader_reg_form #crop_year_id").val($(this).data("crop_year_id"));
        $("#update_trader_reg_form #trader_cat_id").val($(this).data("trader_cat_id")).change();
        $("#update_trader_reg_form #control_no").val($(this).data("control_no"));
        $("#update_trader_reg_form #reg_date").val($(this).data("reg_date"));
        
      }

    });

    @if(Session::has('TRADER_REG_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('TRADER_REG_DELETE_SUCCESS')) !!}
    @endif

    @if(Session::has('TRADER_RENEW_LICENSE_SUCCESS'))
      $('#trader_renew_success').modal('show');
    @endif

    @if(Session::has('TRADER_REG_IS_EXIST'))
      $('#tr_is_exist').modal('show');
    @endif

  </script>
    
@endsection
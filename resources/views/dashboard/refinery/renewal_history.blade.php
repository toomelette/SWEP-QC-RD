<?php

  $table_sessions = [
    Session::get('REFINERY_RENEW_LICENSE_SUCCESS_RR_SLUG'),
    Session::get('REFINERY_REG_IS_EXIST_SLUG'),
  ];

  $appended_requests = [
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Refinery Renewal History ({{ $refinery->name }})</h1>
      <div class="pull-right">
        <a href="{{ route('dashboard.refinery.index') }}" class="btn btn-md btn-default" style="margin-top: -45px;">
          <i class="fa fa-fw fa-arrow-left"></i>&nbsp;Back to List
        </a>
      </div> 
  </section>

  <section class="content">

      {{-- Form Start --}}
      <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.refinery.renewal_history', $refinery->slug) }}">

      <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.refinery.renewal_history', $refinery->slug)) !!}
      </div>

      {{-- Form End --}}  
      </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('cropYear.name', 'Crop Year')</th>
            <th>@sortablelink('license_no', 'License No.')</th>
            <th>@sortablelink('reg_date', 'Date of Registration')</th>
            <th>Action</th>
          </tr>
          @foreach($refinery_reg_list as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ optional($data->cropYear)->name }}</td>
              <td id="mid-vert">{{ $data->license_no }}</td>
              <td id="mid-vert">{{ __dataType::date_parse($data->reg_date, 'F d,Y') }}</td>
              <td id="mid-vert">{{ number_format($data->rated_capacity, 2) }}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.refinery_registration.show', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="show_button" href="{{ route('dashboard.refinery_registration.show', $data->slug) }}">
                      <i class="fa fa-eye"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.refinery_registration.update', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default" 
                       id="update_button"
                       data-crop_year_id="{{ $data->crop_year_id }}"
                       data-reg_date="{{ __dataType::date_parse($data->reg_date, 'm/d/Y') }}"
                       data-rated_capacity="{{ $data->rated_capacity }}"
                       data-action="update" 
                       data-url="{{ route('dashboard.refinery_registration.update', $data->slug) }}">
                      <i class="fa fa-pencil"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.refinery_registration.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.refinery_registration.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </table>
      </div>

      @if($refinery_reg_list->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($refinery_reg_list) !!}
        {!! $refinery_reg_list->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection







@section('modals')


  {!! __html::modal_delete('refinery_registration_delete') !!}


  {{-- RR UPDATE SUCCESS --}}
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
            <p><p style="font-size: 17px;">The License has been successfully updated!</p></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

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

          </div>
        </div>
      </div>
    </div>

  @endif


  {{-- REFINERY IS EXIST --}}  
  @if(Session::has('REFINERY_REG_IS_EXIST'))
    <div class="modal fade modal-danger" data-backdrop="static" id="rr_is_exist">
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
  <div class="modal fade" id="update_refinery_reg" data-backdrop="static">
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
        <div class="modal-body" id="update_refinery_reg_body">
          <form method="POST" id="update_refinery_reg_form" autocomplete="off">
            
            @csrf

            <input name="_method" value="PUT" type="hidden">

            <div class="row">

              {!! __form::select_dynamic(
                '12', 'crop_year_id', 'Crop Year', '', $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', 'style="width:100%; "required'
              ) !!}

              {!! __form::datepicker(
                '12', 'reg_date',  'Date of Registration', '', $errors->has('reg_date'), $errors->first('reg_date')
              ) !!}

              {!! __form::textbox_numeric(
                '12', 'rated_capacity', 'text', 'Rated Capacity', 'Rated Capacity', '', $errors->has('rated_capacity'), $errors->first('rated_capacity'), ''
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

    {!! __js::button_modal_confirm_delete_caller('refinery_registration_delete') !!}

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

        $("#update_refinery_reg").modal("show");
        $("#update_refinery_reg_body #update_refinery_reg_form").attr("action", $(this).data("url"));

        $("#update_refinery_reg_form #crop_year_id").val($(this).data("crop_year_id")).change();
        $("#update_refinery_reg_form #reg_date").val($(this).data("reg_date"));
        $("#update_refinery_reg_form #rated_capacity").val($(this).data("rated_capacity"));

        $(".priceformat").priceFormat({
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: true
        });
        
      }

    });

    @if(Session::has('REFINERY_REG_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('REFINERY_REG_DELETE_SUCCESS')) !!}
    @endif

    @if(Session::has('REFINERY_RENEW_LICENSE_SUCCESS'))
      $('#refinery_renew_success').modal('show');
    @endif

    @if(Session::has('REFINERY_REG_IS_EXIST'))
      $('#rr_is_exist').modal('show');
    @endif

  </script>
    
@endsection
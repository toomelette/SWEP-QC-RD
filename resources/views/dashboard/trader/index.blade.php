<?php

  $table_sessions = [ Session::get('TRADER_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Trader List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.trader.index') }}">

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
            <th>@sortablelink('address', 'Address')</th>
            <th style="width: 220px">Action</th>
          </tr>
          @foreach($traders as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->name }}</td>
              <td id="mid-vert">{{ $data->address }}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.trader.renew_license_post', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="rl_button" data-action="rl" data-url="{{ route('dashboard.trader.renew_license_post', $data->slug) }}">
                      Renew License
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
                '12', 'trader_cat_id', 'Category', old('trader_cat_id'), $global_trader_categories_all, 'trader_cat_id', 'name', $errors->has('trader_cat_id'), $errors->first('trader_cat_id'), 'select2', 'required'
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

  </script>
    
@endsection
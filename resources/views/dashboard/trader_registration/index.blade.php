<?php

  $table_sessions = [ Session::get('TRADER_REG_UPDATE_SUCCESS_SLUG') ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Trader Licenses</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax 
          class="form" 
          id="filter_form" 
          method="GET" 
          autocomplete="off" 
          action="{{ route('dashboard.trader_registration.index') }}">



    {{-- Advance Filters --}}
    {!! __html::filter_open() !!}

      {!! __form::select_dynamic_for_filter(
        '4', 't', 'Trader', old('t'), $global_traders_all, 'trader_id', 'name', 'submit_tr_filter', 'select2', 'style="width:100%;"'
      ) !!}

      {!! __form::select_dynamic_for_filter(
        '4', 'tc', 'Category', old('tc'), $global_trader_categories_all, 'trader_cat_id', 'name', 'submit_tr_filter', 'select2', 'style="width:100%;"'
      ) !!}

      {!! __form::select_dynamic_for_filter(
        '4', 'cy', 'Crop Year', old('cy'), $global_crop_years_all, 'crop_year_id', 'name', 'submit_tr_filter', 'select2', 'style="width:100%;"'
      ) !!}

      <div class="col-md-12 no-padding">
        
        <h5>Date Filter : </h5>

        {!! __form::datepicker('3', 'df',  'From', old('df'), '', '') !!}

        {!! __form::datepicker('3', 'dt',  'To', old('dt'), '', '') !!}

        <button type="submit" class="btn btn-primary" style="margin:25px;">Filter Date <i class="fa fa-fw fa-arrow-circle-right"></i></button>

      </div>

    {!! __html::filter_close('submit_tr_filter') !!}



    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.trader_registration.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('control_no', 'Control No.')</th>
            <th>@sortablelink('trader.name', 'Trader')</th>
            <th>@sortablelink('traderCategory.name', 'Category')</th>
            <th>@sortablelink('reg_date', 'Registration Date')</th>
            <th style="width: 150px">Action</th>
          </tr>
          @foreach($trader_registrations as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">{{ $data->control_no }}</td>
              <td id="mid-vert">{{ optional($data->trader)->name }}</td>
              <td id="mid-vert">{{ optional($data->traderCategory)->name }}</td>
              <td id="mid-vert">{{ __dataType::date_parse($data->reg_date, 'F d, Y') }}</td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.trader_registration.show', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="show_button" href="{{ route('dashboard.trader_registration.show', $data->slug) }}">
                      <i class="fa fa-print"></i>
                    </a>
                  @endif
                  @if(in_array('dashboard.trader_registration.edit', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="edit_button" href="{{ route('dashboard.trader_registration.edit', $data->slug) }}">
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

      @if($trader_registrations->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($trader_registrations) !!}
        {!! $trader_registrations->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection



@section('modals')

  {!! __html::modal_delete('trader_registration_delete') !!}

@endsection 



@section('scripts')

  <script type="text/javascript">

    {!! __js::button_modal_confirm_delete_caller('trader_registration_delete') !!}

    @if(Session::has('TRADER_REG_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('TRADER_REG_UPDATE_SUCCESS')) !!}
    @endif

    @if(Session::has('TRADER_REG_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('TRADER_REG_DELETE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection
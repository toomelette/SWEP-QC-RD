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
                       data-name="{{ optional($data->mill)->name }}"
                       data-license_no="{{ $data->license_no }}"
                       data-crop_year_id="{{ $data->crop_year_id }}"
                       data-reg_date="{{ __dataType::date_parse($data->reg_date, 'm/d/Y') }}"

                       data-mt="{{ $data->mt }}"
                       data-lkg="{{ $data->lkg }}"
                       data-milling_fee="{{ $data->milling_fee }}"
                       data-payment_status="{{ $data->payment_status }}"
                       data-under_payment="{{ $data->under_payment }}"
                       data-excess_payment="{{ $data->excess_payment }}"
                       data-balance_fee="{{ $data->balance_fee }}"

                       data-mill_share="{{ $data->mill_share }}"
                       data-planter_share="{{ $data->planter_share }}"
                       data-other_share="{{ $data->other_share }}"  
                       data-rated_capacity="{{ $data->rated_capacity }}"
                       data-est_start_milling="{{ __dataType::date_parse($data->est_start_milling, 'm/d/Y') }}"
                       data-est_end_milling="{{ __dataType::date_parse($data->est_end_milling, 'm/d/Y') }}"
                       data-start_milling="{{ __dataType::date_parse($data->start_milling, 'm/d/Y') }}"
                       data-end_milling="{{ __dataType::date_parse($data->end_milling, 'm/d/Y') }}"
                       data-molasses_tank_first="{{ $data->molasses_tank_first }}"
                       data-molasses_tank_second="{{ $data->molasses_tank_second }}"
                       data-gtcm_mt="{{ $data->gtcm_mt }}"
                       data-raw_mt="{{ $data->raw_mt }}"
                       data-raw_lkg="{{ $data->raw_lkg }}"
                       data-ah_plant_cane="{{ $data->ah_plant_cane }}"
                       data-ah_ratoon_cane="{{ $data->ah_ratoon_cane }}"
                       data-ap_plant_cane="{{ $data->ap_plant_cane }}"
                       data-ap_ratoon_cane="{{ $data->ap_ratoon_cane }}"

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

  @include('dashboard.mill.renewal_history_modal')  

@endsection 





@section('scripts')

  @include('dashboard.mill.renewal_history_js')
    
@endsection
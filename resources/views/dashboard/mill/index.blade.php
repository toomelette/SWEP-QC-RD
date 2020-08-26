<?php

  $table_sessions = [ 
    Session::get('MILL_UPDATE_SUCCESS_SLUG'),
    Session::get('MILL_RENEW_LICENSE_SUCCESS_SLUG'),
  ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                        'e' => Request::get('e'),
                        'page' => Request::get('page'),
                      ];

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Mills</h1>
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
          <th>Current Crop Year License</th>
          <th style="width: 700px">Action</th>
        </tr>
        @foreach($mills as $data) 
          <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
            <td id="mid-vert">{{ $data->name }}</td>
            <td id="mid-vert">{!! $data->displayLicensesStatusSpan($global_current_cy->crop_year_id) !!}</td>
            <td id="mid-vert">

              <div class="btn-group">
                
                {{-- Billing Statement Button --}}
                @if(in_array('dashboard.mill.renew_license_post', $global_user_submenus))
                  <a type="button" 
                     class="btn btn-default" 
                     @if ($data->billingStatus($global_current_cy->crop_year_id) == false)
                       id="bs_button" 
                       data-action="bs" 
                       data-url="{{ route('dashboard.mill.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                     @else
                       <?php
                        $mr = $data->getCurrentMillRegistration($global_current_cy->crop_year_id);
                       ?>
                       id="bs_button" 
                       data-action="bs" 
                       data-url="{{ route('dashboard.mill.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                       data-crop_year_id="{{ $mr->crop_year_id }}"
                       data-mt="{{ $mr->mt }}"
                       data-lkg="{{ $mr->lkg }}"
                       data-milling_fee="{{ $mr->milling_fee }}"
                       data-payment_status="{{ $mr->payment_status }}"
                       data-under_payment="{{ $mr->under_payment }}"
                       data-excess_payment="{{ $mr->excess_payment }}"
                       data-balance_fee="{{ $mr->balance_fee }}"
                     @endif
                  >
                    <i class="fa fa-usd"></i>&nbsp; Billing
                  </a>
                @endif

                {{-- Renew License Button --}}
                @if(in_array('dashboard.mill.renew_license_post', $global_user_submenus))
                  <a type="button" 
                     class="btn btn-default" 
                     @if ($data->licensesStatus($global_current_cy->crop_year_id) == false)
                       id="rl_button" 
                       data-action="rl" 
                       data-url="{{ route('dashboard.mill.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                     @else
                       <?php
                        $mr = $data->getCurrentMillRegistration($global_current_cy->crop_year_id);
                       ?>
                       id="rl_button" 
                       data-action="rl" 
                       data-url="{{ route('dashboard.mill.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                       data-crop_year_id="{{ $mr->crop_year_id }}"
                       data-reg_date="{{ __dataType::date_parse($mr->reg_date, 'm/d/Y') }}"
                     @endif
                  >
                    <i class="fa fa-certificate"></i>&nbsp; Renew License
                  </a>
                @endif

                {{-- Mill Library --}}
                @if(in_array('dashboard.mill.renew_license_post', $global_user_submenus))
                  <a type="button" 
                     class="btn btn-default" 
                     @if ($data->millLibStatus($global_current_cy->crop_year_id) == false)
                       id="ml_button" 
                       data-action="ml" 
                       data-url="{{ route('dashboard.mill.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                     @else
                       <?php
                        $mr = $data->getCurrentMillRegistration($global_current_cy->crop_year_id);
                       ?>
                       id="ml_button" 
                       data-action="ml" 
                       data-url="{{ route('dashboard.mill.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                       data-crop_year_id="{{ $mr->crop_year_id }}"
                       data-mill_share="{{ $mr->mill_share }}"
                       data-planter_share="{{ $mr->planter_share }}"
                       data-other_share="{{ $mr->other_share }}"  
                       data-rated_capacity="{{ $mr->rated_capacity }}"
                       data-est_start_milling="{{ __dataType::date_parse($mr->est_start_milling, 'm/d/Y') }}"
                       data-est_end_milling="{{ __dataType::date_parse($mr->est_end_milling, 'm/d/Y') }}"
                       data-start_milling="{{ __dataType::date_parse($mr->start_milling, 'm/d/Y') }}"
                       data-end_milling="{{ __dataType::date_parse($mr->end_milling, 'm/d/Y') }}"
                       data-molasses_tank_first="{{ $mr->molasses_tank_first }}"
                       data-molasses_tank_second="{{ $mr->molasses_tank_second }}"
                       data-gtcm_mt="{{ $mr->gtcm_mt }}"
                       data-raw_mt="{{ $mr->raw_mt }}"
                       data-raw_lkg="{{ $mr->raw_lkg }}"
                       data-ah_plant_cane="{{ $mr->ah_plant_cane }}"
                       data-ah_ratoon_cane="{{ $mr->ah_ratoon_cane }}"
                       data-ap_plant_cane="{{ $mr->ap_plant_cane }}"
                       data-ap_ratoon_cane="{{ $mr->ap_ratoon_cane }}"
                     @endif
                  >
                    <i class="fa fa-book"></i>&nbsp; Mill Library
                  </a>
                @endif
              </div>

              &nbsp;

              <div class="btn-group">
                @if(in_array('dashboard.mill.renewal_history', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="rh_button" href="{{ route('dashboard.mill.renewal_history', $data->slug) }}">
                    <i class="fa fa-tasks"></i>&nbsp; Renewal History
                  </a>
                @endif
                @if(in_array('dashboard.mill.files', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="files_button" href="{{ route('dashboard.mill.files', $data->slug) }}">
                    <i class="fa fa-file-text-o"></i>&nbsp; Files
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

  @include('dashboard.mill.index_modal')

@endsection 





@section('scripts')

  @include('dashboard.mill.index_js')

@endsection
<?php

  $table_sessions = [ 
    Session::get('REFINERY_UPDATE_SUCCESS_SLUG'),
    Session::get('REFINERY_RENEW_LICENSE_SUCCESS_SLUG'),
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
      <h1>Refineries</h1>
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
          <th>Current Crop Year License</th>
          <th style="width: 650px">Action</th>
        </tr>
        @foreach($refineries as $data) 
          <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
            <td id="mid-vert">{{ $data->name }}</td>
            <td id="mid-vert">
              {!! $data->displayLicensesStatusSpan($global_current_cy->crop_year_id) !!}
            </td>

            <td id="mid-vert">

              <div class="btn-group">

                {{-- Renew License --}}
                @if(in_array('dashboard.refinery.renew_license_post', $global_user_submenus))
                  <a type="button" 
                     class="btn btn-default" 
                     @if ($data->licensesStatus($global_current_cy->crop_year_id) == true)
                       <?php
                        $rr = $data->getCurrentRefineryRegistration($global_current_cy->crop_year_id);
                       ?>
                       id="rl_button" 
                       data-action="rl" 
                       data-url="{{ route('dashboard.refinery.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                       data-crop_year_id="{{ $rr->crop_year_id }}"
                       data-reg_date="{{ __dataType::date_parse($rr->reg_date, 'm/d/Y') }}"
                     @else
                       id="rl_button" 
                       data-action="rl" 
                       data-url="{{ route('dashboard.refinery.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                     @endif
                  >
                    <i class="fa fa-certificate"></i>&nbsp; Renew License
                  </a>
                @endif

                {{-- Rated Capacity --}}
                @if(in_array('dashboard.refinery.renew_license_post', $global_user_submenus))
                  <a type="button" 
                     class="btn btn-default" 
                     @if ($data->ratedCapacityStatus($global_current_cy->crop_year_id) == true)
                       <?php
                        $rr = $data->getCurrentRefineryRegistration($global_current_cy->crop_year_id);
                       ?>
                       id="rc_button" 
                       data-action="rc" 
                       data-url="{{ route('dashboard.refinery.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                       data-crop_year_id="{{ $rr->crop_year_id }}"
                       data-rated_capacity="{{ $rr->rated_capacity }}"
                     @else
                       id="rc_button" 
                       data-action="rc" 
                       data-url="{{ route('dashboard.refinery.renew_license_post', $data->slug) }}"
                       data-name="{{ $data->name }}"
                     @endif
                  >
                    <i class="fa fa-pie-chart"></i>&nbsp; Rated Capacity
                  </a>
                @endif

              </div>

              <div class="btn-group">
                @if(in_array('dashboard.refinery.renewal_history', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="rh_button" href="{{ route('dashboard.refinery.renewal_history', $data->slug) }}">
                    <i class="fa fa-tasks"></i>&nbsp; Renewal History
                  </a>
                @endif
                @if(in_array('dashboard.refinery.files', $global_user_submenus))
                  <a type="button" class="btn btn-default" id="files_button" href="{{ route('dashboard.refinery.files', $data->slug) }}">
                    <i class="fa fa-file-text-o"></i>&nbsp; Files
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

  @include('dashboard.refinery.index_modal')

@endsection 





@section('scripts')

  @include('dashboard.refinery.index_js')
    
@endsection
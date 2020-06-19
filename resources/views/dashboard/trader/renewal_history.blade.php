<?php

  $table_sessions = [];

  $appended_requests = [
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                      ];

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Renewal History List</h1>
  </section>

  <section class="content">

      {{-- Form Start --}}
      <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.trader.index') }}">

      <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

        {{-- Table Search --}}        
        <div class="box-header with-border">
          <a href="{{ route('dashboard.trader.index') }}" class="btn btn-sm btn-default">Back to List</a>
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
                  @if(in_array('dashboard.trader_registration.dl_word_file', $global_user_submenus))
                    <a type="button" class="btn btn-primary" id="dwf_button" href="{{ route('dashboard.trader_registration.dl_word_file', $data->slug) }}">
                      <i class="fa fa-download"></i> Download
                    </a>
                  @endif
                  @if(in_array('dashboard.trader_registration.show', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="show_button" href="{{ route('dashboard.trader_registration.show', $data->slug) }}">
                      <i class="fa fa-print"></i>
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

@endsection 







@section('scripts')

  <script type="text/javascript">

    {!! __js::button_modal_confirm_delete_caller('trader_registration_delete') !!}

    @if(Session::has('TRADER_REG_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('TRADER_REG_DELETE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection
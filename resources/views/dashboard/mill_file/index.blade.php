<?php

  $table_sessions = [ 
    Session::get('MILL_FILE_UPDATE_SUCCESS_SLUG'),
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
    <h1>MILL FILES ({{ $mill->name }})</h1>
    <div class="pull-right" style="margin-top: -27px;">
      <a href="{{ route('dashboard.mill.index') }}" class="btn btn-md btn-default">
        <i class="fa fa-fw fa-arrow-left"></i>Back to list
      </a>
      &nbsp;
      <button class="btn btn-md btn-primary" id="add_files">
        <i class="fa fa-plus"></i> Add Files
      </button>
    </div> 
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    <form data-pjax class="form" id="filter_form" method="GET" action="{{ route('dashboard.mill.files', $mill->slug) }}">

    <div class="box box-solid" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.mill.files', $mill->slug)) !!}
      </div>

    {{-- Form End --}}  
    </form>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table table-hover">
          <tr>
            <th>@sortablelink('filename', 'Filename')</th>
            <th>@sortablelink('updated_at', 'Last Modified')</th>
            <th>Action</th>
          </tr>
          @foreach($mill_file_list as $data) 
            <tr {!! __html::table_highlighter($data->slug, $table_sessions) !!} >
              <td id="mid-vert">
                <a href="{{ route('dashboard.mill_file.view_file', $data->slug) }}" target="_blank">
                  {{ $data->filename }}
                </a>
              </td>
              <td id="mid-vert">
                {{ __dataType::date_parse($data->updated_at, 'F d, Y H:i A') }}
              </td>
              <td id="mid-vert">
                <div class="btn-group">
                  @if(in_array('dashboard.mill_file.update', $global_user_submenus))
                    <a type="button" 
                       class="btn btn-default" 
                       id="update_button" 
                       data-filename="{{ $data->trimmed_filename }}"
                       data-action="rename" 
                       data-url="{{ route('dashboard.mill_file.update', $data->slug) }}">
                      Rename
                    </a>
                  @endif
                  @if(in_array('dashboard.mill_file.destroy', $global_user_submenus))
                    <a type="button" class="btn btn-default" id="delete_button" data-action="delete" data-url="{{ route('dashboard.mill_file.destroy', $data->slug) }}">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
          </table>
      </div>

      @if($mill_file_list->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($mill_file_list) !!}
        {!! $mill_file_list->appends($appended_requests)->render('vendor.pagination.bootstrap-4')!!}
      </div>

    </div>

  </section>

@endsection







@section('modals')


  {!! __html::modal_delete('mill_file_delete') !!}


  {{-- ADD FILE FORM --}}
  <div class="modal fade" id="add_files_modal" data-backdrop="static">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">
            <i class="fa fa-file-o"></i> &nbsp;Add File(s)
          </h4>
        </div>
        <div class="modal-body" id="rl_body">
          <form method="POST" 
                autocomplete="off" 
                enctype="multipart/form-data" 
                action="{{ route('dashboard.mill_file.store') }}">

            <div class="row">
            
              @csrf

              <input type="hidden" name="s" value="{{ $mill->slug }}">

              <div class="col-md-12" style="margin-bottom:20px;">
                <small class="text-danger">
                  {{ $errors->has('files') ? $errors->first('files') : '' }}
                </small>
                <div class="file-loading">
                  <input id="files" name="files[]" type="file" multiple>
                </div>  
              </div>

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


  {{-- RENAME FILE --}}
  <div class="modal fade" id="rename_modal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">
            <i class="fa fa-file-o"></i> &nbsp;Rename
          </h4>
        </div>
        <div class="modal-body" id="rename_body">
          <form method="POST" id="rename_form" autocomplete="off">
            
            @csrf

            <input name="_method" value="PUT" type="hidden">

            <div class="row">

              {!! __form::textbox(
                '12', 'filename', 'text', 'Filename', 'Filename', old('filename'), $errors->has('filename'), $errors->first('filename'), 'required'
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

    {!! __js::button_modal_confirm_delete_caller('mill_file_delete') !!}

    $(document).on("click", "#add_files", function () {
      $("#add_files_modal").modal("show");
    });


    $(document).on("click", "#update_button", function () {

      if($(this).data("action") == "rename"){

        $("#rename_modal").modal("show");
        $("#rename_body #rename_form").attr("action", $(this).data("url"));

        $("#rename_form #filename").val($(this).data("filename"));
        
      }

    });

    @if(Session::has('MILL_FILE_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_FILE_CREATE_SUCCESS')) !!}
    @endif

    @if(Session::has('MILL_FILE_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_FILE_UPDATE_SUCCESS')) !!}
    @endif

    @if(Session::has('MILL_FILE_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_FILE_DELETE_SUCCESS')) !!}
    @endif

    $("#files").fileinput({
        allowedFileExtensions: ["pdf", "png", "jpg", "jpeg"],
        showUpload: false,
        showCaption: false,
        maxFileCount: 100,
        browseClass: "btn btn-primary btn-md",
    }); 

  </script>
    
@endsection
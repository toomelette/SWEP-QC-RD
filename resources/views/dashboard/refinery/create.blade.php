@extends('layouts.admin-master')

@section('content')

<section class="content">
            
    <div class="box box-solid">
        
      <div class="box-header with-border">
        <h2 class="box-title">New Refinery</h2>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div> 
      </div>
      
      <form method="POST" autocomplete="off" action="{{ route('dashboard.refinery.store') }}">

        <div class="box-body">
          <div class="col-md-12">
                  
            @csrf   

            {!! __form::textbox(
              '12', 'name', 'text', 'Name of Refinery *', 'Name of Refinery', old('name'), $errors->has('name'), $errors->first('name'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address', 'text', 'Address *', 'Address', old('address'), $errors->has('address'), $errors->first('address'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_second', 'text', 'Second Address', 'Second Address', old('address_second'), $errors->has('address_second'), $errors->first('address_second'), ''
            ) !!}

            {!! __form::textbox(
              '12', 'address_third', 'text', 'Third Address', 'Third Address', old('address_third'), $errors->has('address_third'), $errors->first('address_third'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '6', 'tel_no', 'text', 'Tel No.', 'Tel No.', old('tel_no'), $errors->has('tel_no'), $errors->first('tel_no'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'tel_no_second', 'text', 'Tel No. Second', 'Tel No. Second', old('tel_no_second'), $errors->has('tel_no_second'), $errors->first('tel_no_second'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '6', 'fax_no', 'text', 'Fax No.', 'Fax No.', old('fax_no'), $errors->has('fax_no'), $errors->first('fax_no'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'fax_no_second', 'text', 'Fax No. Second', 'Fax No. Second', old('fax_no_second'), $errors->has('fax_no_second'), $errors->first('fax_no_second'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '6', 'email', 'text', 'Email', 'Email', old('email'), $errors->has('email'), $errors->first('email'), ''
            ) !!}

            {!! __form::select_dynamic(
              '6', 'region_id', 'Region', old('region_id'), $global_regions_all, 'region_id', 'name', $errors->has('region_id'), $errors->first('region_id'), 'select2', ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::select_static(
              '6', 'report_region', 'Report Region', old('report_region'), __static::report_regions(), $errors->has('report_region'), $errors->first('report_region'), 'select2', ''
            ) !!}

            {!! __form::textbox(
              '6', 'officer', 'text', 'Officer', 'Officer', old('officer'), $errors->has('officer'), $errors->first('officer'), ''
            ) !!}

            <div class="col-md-12"></div>

            {!! __form::textbox(
              '6', 'position', 'text', 'Position', 'Position', old('position'), $errors->has('position'), $errors->first('position'), ''
            ) !!}

            {!! __form::textbox(
              '6', 'salutation', 'text', 'Salutation', 'Salutation', old('salutation'), $errors->has('salutation'), $errors->first('salutation'), ''
            ) !!}

            <div class="col-md-12"></div>

            {{-- Cover Letter Address --}}
            <div class="form-group col-md-12">
              <div class="checkbox">
                <span>Cover Letter Address:</span><br><br>
                <label>
                  <input type="checkbox" 
                         class="minimal cover_letter_address" 
                         name="cover_letter_address" 
                         value="1" {{ old('cover_letter_address') == "1" ? 'checked' : '' }}>
                  First Address (Office Address)
                </label>
                &nbsp;
                <label>
                  <input type="checkbox" 
                         class="minimal cover_letter_address" 
                         name="cover_letter_address" 
                         value="2" {{ old('cover_letter_address') == "2" ? 'checked' : '' }}>
                  Second Address (Mill Site Address)
                </label>
                &nbsp;
                <label>
                  <input type="checkbox" 
                         class="minimal cover_letter_address" 
                         name="cover_letter_address" 
                         value="3" {{ old('cover_letter_address') == "3" ? 'checked' : '' }}>
                  Third Address
                </label>
                &nbsp;
                <small class="text-danger">{{ $errors->first('cover_letter_address') }}</small>
              </div>
            </div>

            <div class="col-md-12"></div>

            {{-- License Address --}}
            <div class="form-group col-md-12">
              <div class="checkbox">
                <span>License Address:</span><br><br>
                <label>
                  <input type="checkbox" 
                         class="minimal license_address" 
                         name="license_address" 
                         value="1" {{ old('license_address') == "1" ? 'checked' : '' }}>
                  First Address (Office Address)
                </label>
                &nbsp;
                <label>
                  <input type="checkbox" 
                         class="minimal license_address" 
                         name="license_address" 
                         value="2" {{ old('license_address') == "2" ? 'checked' : '' }}>
                  Second Address (Mill Site Address)
                </label>
                &nbsp;
                <label>
                  <input type="checkbox" 
                         class="minimal license_address" 
                         name="license_address" 
                         value="3" {{ old('license_address') == "3" ? 'checked' : '' }}>
                  Third Address
                </label>
                &nbsp;
                <small class="text-danger">{{ $errors->first('license_address') }}</small>
              </div>
            </div>

          </div>
        </div>

        <div class="box-footer">
          <button type="submit" class="btn btn-default">Save <i class="fa fa-fw fa-save"></i></button>
        </div>

      </form>

    </div>

</section>

@endsection




@section('scripts')

  <script type="text/javascript">

    @if(Session::has('REFINERY_CREATE_SUCCESS'))
      {!! __js::toast(Session::get('REFINERY_CREATE_SUCCESS')) !!}
    @endif

    $('.cover_letter_address').on('ifChecked', function(event){
      $('.cover_letter_address').not(this).iCheck('uncheck');
    });

    $('.license_address').on('ifChecked', function(event){
      $('.license_address').not(this).iCheck('uncheck');
    });

  </script>
    
@endsection
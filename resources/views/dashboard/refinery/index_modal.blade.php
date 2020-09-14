


  {!! __html::modal_delete('refinery_delete') !!}


  {{-- REGISTRATION SUCCESS MODAL --}}
  <div class="modal fade" id="refinery_renew_success">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><i class="fa fa-fw fa-check"></i> Saved!</h4>
        </div>
        <div class="modal-body">
          <p style="font-size: 17px;">
            @if (Session::get('RENEW_LICENSE_SUCCESS'))
              {{ Session::get('RENEW_LICENSE_SUCCESS') }}
            @endif
            @if (Session::get('RATED_CAPACITY_SUCCESS'))
              {{ Session::get('RATED_CAPACITY_SUCCESS') }}
            @endif
          </p>
        </div>
        <div class="modal-footer">

          @if (Session::get('RENEW_LICENSE_SUCCESS'))

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

          @endif

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>
  


  {{-- RENEW LICENSE FORM --}}
  <div class="modal fade" id="refinery_rl" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <i class="fa fa-certificate"></i> &nbsp;Refinery License Renewal
          </h4>
        </div>
        <div class="modal-body" id="rl_body">

          <form method="POST" id="rl_form" autocomplete="off">
            
            @csrf

            <div class="row">

              <div class="form-group col-md-12">
                <h4>Refinery: <span class="refinery_name"></span></h4>
              </div>

              <input type="hidden" name="ft" value="rl">

              {!! __form::select_dynamic(
                '12', 'crop_year_id', 'Crop Year', $global_current_cy->crop_year_id, $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', 'style="width:100%; "required'
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


  {{-- RATED CAPACITY FORM --}}
  <div class="modal fade" id="refinery_rc" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <i class="fa fa-pie-chart"></i> &nbsp;Refinery Rated Capacity
          </h4>
        </div>
        <div class="modal-body" id="rc_body">

          <form method="POST" id="rc_form" autocomplete="off">
            
            @csrf

            <div class="row">

              <div class="form-group col-md-12">
                <h4>Refinery: <span class="refinery_name"></span></h4>
              </div>

              <input type="hidden" name="ft" value="rc">

              {!! __form::select_dynamic(
                '12', 'crop_year_id', 'Crop Year', $global_current_cy->crop_year_id, $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', 'style="width:100%; "required'
              ) !!}

              {!! __form::textbox_numeric(
                '12', 'rated_capacity', 'text', 'Rated Capacity (Lkg/day)', 'Rated Capacity', old('rated_capacity') , $errors->has('rated_capacity'), $errors->first('rated_capacity'), ''
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
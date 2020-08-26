  


  {!! __html::modal_delete('mill_registration_delete') !!}




  {{-- TR UPDATE SUCCESS --}}
  @if(Session::has('MILL_RENEW_LICENSE_SUCCESS'))

    <div class="modal fade" id="mill_renew_success">
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

            @if (in_array('dashboard.mill_registration.dl_cover', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_cover', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> Cover Letter
              </a>
            @endif

            @if (in_array('dashboard.mill_registration.dl_billing', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_billing', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> Billing Statement
              </a>
            @endif

            @if (in_array('dashboard.mill_registration.dl_license', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_license', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> License
              </a>
            @endif

            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

          </div>
        </div>
      </div>
    </div>

  @endif




  {{-- MILL IS EXIST --}}  
  @if(Session::has('MILL_REG_IS_EXIST'))
    <div class="modal fade modal-danger" data-backdrop="static" id="mill_is_exist">
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
              {{ Session::get('MILL_REG_IS_EXIST') }}
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
  <div class="modal fade" id="mill_rl" data-backdrop="static">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <i class="fa fa-certificate"></i> &nbsp;Edit License
            <div class="pull-right">
              <code>Fields with asterisks(*) are required</code>
            </div> 
          </h4>
        </div>
        <div class="modal-body" id="mill_rl_body">

          <form method="POST" id="mill_rl_form" autocomplete="off">
            
            @csrf

            <div class="row">

              <div class="form-group col-md-12">
                <h4>Mill: <span class="mill_name"></span></h4>
              </div>

              <input type="hidden" name="_method" value="PUT">

              {!! __form::textbox(
                '6', 'license_no', 'text', 'License No.', 'License No.', '' , $errors->has('license_no'), $errors->first('license_no'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::select_dynamic(
                '6', 'crop_year_id', 'Crop Year *', '', $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', 'style="width:100%; "required'
              ) !!}

              {!! __form::datepicker(
                '6', 'reg_date',  'Date of Registration *', '', $errors->has('reg_date'), $errors->first('reg_date')
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'mt', 'text', 'MT', 'MT', '', $errors->has('mt'), $errors->first('mt'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'lkg', 'text', 'LKG', 'LKG', '', $errors->has('lkg'), $errors->first('lkg'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'milling_fee', 'text', 'Milling Fee', 'Milling Fee', '', $errors->has('milling_fee'), $errors->first('milling_fee'), ''
              ) !!}

              {!! __form::select_static(
                '6', 'payment_status', 'Payment Status', '', ['None' => 'N','Underpayment' => 'UP', 'Excess Payment ' => 'EP'], $errors->has('payment_status'), $errors->first('payment_status'), 'select2', 'style="width:100%;"'
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'under_payment', 'text', 'Underpayment', 'Underpayment', '', $errors->has('under_payment'), $errors->first('under_payment'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'excess_payment', 'text', 'Excess Payment', 'Excess Payment', '00' , $errors->has('excess_payment'), $errors->first('excess_payment'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'balance_fee', 'text', 'Balance', 'Balance', '', $errors->has('balance_fee'), $errors->first('balance_fee'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'rated_capacity', 'text', 'Rated Capacity', 'Rated Capacity', '', $errors->has('rated_capacity'), $errors->first('rated_capacity'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::datepicker(
                '6', 'start_milling',  'Start of Milling', '', $errors->has('start_milling'), $errors->first('start_milling')
              ) !!}

              {!! __form::datepicker(
                '6', 'end_milling',  'End of Milling', '', $errors->has('end_milling'), $errors->first('end_milling')
              ) !!}


              <div class="col-md-12 no-padding">

                <div class="col-md-12">
                  <h4>Mill Share</h4>
                </div>

                <div class="col-md-12">

                  {!! __form::textbox_numeric(
                    '6', 'planter_share', 'text', 'Planter (%)', 'Planter (%)', '' , $errors->has('planter_share'), $errors->first('planter_share'), ''
                  ) !!}

                  {!! __form::textbox_numeric(
                    '6', 'mill_share', 'text', 'Mill (%)', 'Mill (%)', '' , $errors->has('mill_share'), $errors->first('mill_share'), ''
                  ) !!}
                  
                  <div class="col-md-12"></div>

                  {!! __form::textbox(
                    '12', 'other_share', 'text', 'Others (%)', 'Others (%)', '' , $errors->has('other_share'), $errors->first('other_share'), ''
                  ) !!}
                  
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
  


  {!! __html::modal_delete('mill_delete') !!}



  {{-- LICENSE SUCCESS --}}
  <div class="modal fade" id="mill_renew_success">
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
            @if (Session::get('BILLING_STATEMENT_SUCCESS'))
              {{ Session::get('BILLING_STATEMENT_SUCCESS') }}
            @endif
            @if (Session::get('MILL_LIB_SUCCESS'))
              {{ Session::get('MILL_LIB_SUCCESS') }}
            @endif
          </p>
        </div>
        <div class="modal-footer">

          @if (Session::get('RENEW_LICENSE_SUCCESS'))

            @if (in_array('dashboard.mill_registration.dl_cover', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_cover', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> Cover Letter
              </a>
            @endif

            @if (in_array('dashboard.mill_registration.dl_license', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_license', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> License
              </a>
            @endif
            
          @endif


          @if (Session::get('BILLING_STATEMENT_SUCCESS'))

            @if (in_array('dashboard.mill_registration.dl_billing', $global_user_submenus))
              <a href="{{ route('dashboard.mill_registration.dl_billing', Session::get('MILL_RENEW_LICENSE_SUCCESS_TR_SLUG')) }}" 
                 type="button" 
                 class="btn btn-primary">
                <i class="fa fa-download"></i> Billing Statement
              </a>
            @endif
            
          @endif

          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        </div>
      </div>
    </div>
  </div>



  {{-- RENEW LICENSE FORM MODAL --}}
  <div class="modal fade" id="mill_rl" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <i class="fa fa-certificate"></i> &nbsp;Renew License
            <div class="pull-right">
              <code>Fields with asterisks(*) are required</code>
            </div> 
          </h4>
        </div>
        <div class="modal-body" id="rl_body">
          
          <form method="POST" id="rl_form" autocomplete="off">
            
            @csrf

            <div class="row">

              <div class="form-group col-md-12">
                <h4>Mill: <span class="mill_name"></span></h4>
              </div>

              <input type="hidden" name="ft" value="rl">

              {!! __form::select_dynamic(
                '12', 'crop_year_id', 'Crop Year *', $global_current_cy->crop_year_id, $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', 'style="width:100%;" required'
              ) !!}

              {!! __form::datepicker(
                '12', 'reg_date',  'Date of Registration *', old('reg_date') ? old('reg_date') : Carbon::now()->format('m/d/Y'), $errors->has('reg_date'), $errors->first('reg_date')
              ) !!}

          </div>

          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Save <i class="fa fa-fw fa-save"></i></button>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>




  {{-- BILLING STATEMENT MODAL --}}
  <div class="modal fade" id="mill_bs" data-backdrop="static">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <i class="fa fa-usd"></i> &nbsp;Billing Letter
            <div class="pull-right">
              <code>Fields with asterisks(*) are required</code>
            </div> 
          </h4>
        </div>
        <div class="modal-body" id="bs_body">
          
          <form method="POST" id="bs_form" autocomplete="off">
            
            @csrf

            <div class="row">

              <div class="form-group col-md-12">
                <h4>Mill: <span class="mill_name"></span></h4>
              </div>

              <input type="hidden" name="ft" value="bs">

              {!! __form::select_dynamic(
                '6', 'crop_year_id', 'Crop Year *', $global_current_cy->crop_year_id, $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', 'style="width:100%;" required'
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'mt', 'text', 'MT', 'MT', old('mt') , $errors->has('mt'), $errors->first('mt'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'lkg', 'text', 'LKG', 'LKG', old('lkg') , $errors->has('lkg'), $errors->first('lkg'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'milling_fee', 'text', 'Milling Fee', 'Milling Fee', old('milling_fee') , $errors->has('milling_fee'), $errors->first('milling_fee'), ''
              ) !!}

              {!! __form::select_static(
                '6', 'payment_status', 'Payment Status', old('payment_status'), ['None' => 'N','Underpayment' => 'UP', 'Excess Payment ' => 'EP'], $errors->has('payment_status'), $errors->first('payment_status'), 'select2', 'style="width:100%;"'
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'under_payment', 'text', 'Underpayment', 'Underpayment', old('under_payment') , $errors->has('under_payment'), $errors->first('under_payment'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '6', 'excess_payment', 'text', 'Excess Payment', 'Excess Payment', '00' , $errors->has('excess_payment'), $errors->first('excess_payment'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '6', 'balance_fee', 'text', 'Balance', 'Balance', old('balance_fee') , $errors->has('balance_fee'), $errors->first('balance_fee'), ''
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




  {{-- MILL LIBRARY --}}
  <div class="modal fade" id="mill_ml" data-backdrop="static">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">
            <i class="fa fa-pie-chart"></i> &nbsp;Crop Estimate
            <div class="pull-right">
              <code>Fields with asterisks(*) are required</code>
              <button type="submit" class="btn btn-default" id="mdl_edit_button">
                Edit <i class="fa fa-fw fa-pencil"></i>
              </button>
              <button type="submit" class="btn btn-default" id="mdl_view_button">
                Back <i class="fa fa-fw fa-arrow-left"></i>
              </button>
            </div> 
          </h4>
        </div>
        <div class="modal-body" id="ml_body">
          
          <form method="POST" id="ml_form" autocomplete="off">
            
            @csrf

            <div class="row">

              <div class="col-md-12">
                <p>Mill: <span class="mill_name"></span></p>
              </div>

              {{-- Details --}}
              <div class="col-md-12 no-padding" id="mdl_view">
                
                <div class="col-md-12">
                  <p>Crop Year: <span id="v_crop_year"></span></p>
                </div>

                <div class="col-md-6">


                  <table class="table table-bordered">
                    <tr>
                      <td>Planter Share</td>
                      <td><span id="v_planter_share"></span></td>
                    </tr>
                    <tr>
                      <td>Mill Share</td>
                      <td><span id="v_mill_share"></span></td>
                    </tr>
                    <tr>
                      <td>Other Share</td>
                      <td><span id="v_other_share"></span></td>
                    </tr>
                    <tr>
                      <td>Mill Rated Capacity</td>
                      <td><span id="v_rated_capacity"></span> Tc/day</td>
                    </tr>
                    <tr>
                      <td>Molasses Tank 1</td>
                      <td><span id="v_molasses_tank_first"></span> MT</td>
                    </tr>
                    <tr>
                      <td>Molasses Tank 2</td>
                      <td><span id="v_molasses_tank_second"></span> MT</td>
                    </tr>
                    <tr>
                      <td>Molasses Tank 3</td>
                      <td><span id="v_molasses_tank_third"></span> MT</td>
                    </tr>
                    <tr>
                      <td>Est. Start of Milling</td>
                      <td><span id="v_est_start_milling"></span></td>
                    </tr>
                    <tr>
                      <td>Est. End of Milling</td>
                      <td><span id="v_est_end_milling"></span></td>
                    </tr>
                  </table>
                </div>
                

                <div class="col-md-6">
                  <table class="table table-bordered">
                    <tr>
                      <td>Actual Start of Milling</td>
                      <td><span id="v_start_milling"></span></td>
                    </tr>
                    <tr>
                      <td>Actual End of Milling</td>
                      <td><span id="v_end_milling"></span></td>
                    </tr>
                    <tr>
                      <td>GTCM MT</td>
                      <td><span id="v_gtcm_mt"></span></td>
                    </tr>
                    <tr>
                      <td>Raw MT</td>
                      <td><span id="v_raw_mt"></span></td>
                    </tr>
                    <tr>
                      <td>Raw LKG</td>
                      <td><span id="v_raw_lkg"></span></td>
                    </tr>
                    <tr>
                      <td>Area Harvested Plant Cane</td>
                      <td><span id="v_ah_plant_cane"></span> HAS.</td>
                    </tr>
                    <tr>
                      <td>Area Harvested Ratoon Cane</td>
                      <td><span id="v_ah_ratoon_cane"></span> HAS.</td>
                    </tr>
                    <tr>
                      <td>Area Planted Plant Cane</td>
                      <td><span id="v_ap_plant_cane"></span> HAS.</td>
                    </tr>
                    <tr>
                      <td>Area Planted Ratoon Cane</td>
                      <td><span id="v_ap_ratoon_cane"></span> HAS.</td>
                    </tr>
                  </table>
                </div>

              </div>
              

            </div>



            {{-- Form --}}
            <div class="row" id="mdl_form">

              <input type="hidden" name="ft" value="ml">

              {!! __form::select_dynamic(
                '6', 'crop_year_id', 'Crop Year *', $global_current_cy->crop_year_id, $global_crop_years_all, 'crop_year_id', 'name', $errors->has('crop_year_id'), $errors->first('crop_year_id'), 'select2', 'style="width:100%; "required'
              ) !!}


              {{-- Mill Participation --}}
              <div class="col-md-12 no-padding">

                <div class="col-md-12">
                  <h4>Mill Participation</h4>
                </div>

                <div class="col-md-12">

                  {!! __form::textbox_numeric(
                    '6', 'planter_share', 'text', 'Planter Share (%)', 'Planter', old('planter_share') , $errors->has('planter_share'), $errors->first('planter_share'), ''
                  ) !!}

                  {!! __form::textbox_numeric(
                    '6', 'mill_share', 'text', 'Mill Share (%)', 'Mill', old('mill_share') , $errors->has('mill_share'), $errors->first('mill_share'), ''
                  ) !!}

                  {!! __form::textbox(
                    '12', 'other_share', 'text', 'Other Shares (%)', 'Others', old('other_share'), $errors->has('other_share'), $errors->first('other_share'), ''
                  ) !!}

                </div>

              </div>


              {!! __form::textbox_numeric(
                '12', 'rated_capacity', 'text', 'Mill Rated Capacity (Tc/day)', 'Mill Rated Capacity', old('rated_capacity') , $errors->has('rated_capacity'), $errors->first('rated_capacity'), ''
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::datepicker(
                '6', 'est_start_milling',  'Estimated Start of Milling', old('est_start_milling'), $errors->has('est_start_milling'), $errors->first('est_start_milling')
              ) !!}

              {!! __form::datepicker(
                '6', 'est_end_milling',  'Estimated End of Milling', old('est_end_milling'), $errors->has('est_end_milling'), $errors->first('est_end_milling')
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::datepicker(
                '6', 'start_milling',  'Actual Start of Milling', old('start_milling'), $errors->has('start_milling'), $errors->first('start_milling')
              ) !!}

              {!! __form::datepicker(
                '6', 'end_milling',  'Actual End of Milling', old('end_milling'), $errors->has('end_milling'), $errors->first('end_milling')
              ) !!}

              <div class="col-md-12"></div>

              {!! __form::textbox_numeric(
                '4', 'molasses_tank_first', 'text', 'Molases Tank 1 (MT)', 'Molases Tank 1', old('molasses_tank_first') , $errors->has('molasses_tank_first'), $errors->first('molasses_tank_first'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '4', 'molasses_tank_second', 'text', 'Molases Tank 2 (MT)', 'Molases Tank 2', old('molasses_tank_second') , $errors->has('molasses_tank_second'), $errors->first('molasses_tank_second'), ''
              ) !!}

              {!! __form::textbox_numeric(
                '4', 'molasses_tank_third', 'text', 'Molases Tank 3 (MT)', 'Molases Tank 3', old('molasses_tank_third') , $errors->has('molasses_tank_third'), $errors->first('molasses_tank_third'), ''
              ) !!}


              {{-- Mill Participation --}}
              <div class="col-md-12 no-padding">

                <div class="col-md-12">
                  <h4>Crop Estimates</h4>
                </div>

                <div class="col-md-12">

                  {!! __form::textbox_numeric(
                    '4', 'gtcm_mt', 'text', 'GTCM MT', 'GTCM MT', old('gtcm_mt') , $errors->has('gtcm_mt'), $errors->first('gtcm_mt'), ''
                  ) !!}

                  {!! __form::textbox_numeric(
                    '4', 'raw_mt', 'text', 'RAW MT', 'RAW MT', old('raw_mt') , $errors->has('raw_mt'), $errors->first('raw_mt'), ''
                  ) !!}

                  {!! __form::textbox_numeric(
                    '4', 'raw_lkg', 'text', 'RAW LKG', 'RAW LKG', old('raw_lkg') , $errors->has('raw_lkg'), $errors->first('raw_lkg'), ''
                  ) !!}

                </div>

              </div>


              {{-- Area Harvested --}}
              <div class="col-md-12 no-padding">

                <div class="col-md-12">
                  <h4>Area Harvested (Previous Crop Year)</h4>
                </div>

                <div class="col-md-12">

                  {!! __form::textbox_numeric(
                    '6', 'ah_plant_cane', 'text', 'Plant Cane (HAS.)', 'Plant Cane', old('ah_plant_cane') , $errors->has('ah_plant_cane'), $errors->first('ah_plant_cane'), ''
                  ) !!}

                  {!! __form::textbox_numeric(
                    '6', 'ah_ratoon_cane', 'text', 'Ratoon Cane (HAS.)', 'Ratoon Cane', old('ah_ratoon_cane') , $errors->has('ah_ratoon_cane'), $errors->first('ah_ratoon_cane'), ''
                  ) !!}

                </div>

              </div>


              {{-- Area Planted --}}
              <div class="col-md-12 no-padding">

                <div class="col-md-12">
                  <h4>Area Planted (Current Crop Year)</h4>
                </div>

                <div class="col-md-12">

                  {!! __form::textbox_numeric(
                    '6', 'ap_plant_cane', 'text', 'Plant Cane (HAS.)', 'Plant Cane', old('ap_plant_cane') , $errors->has('ap_plant_cane'), $errors->first('ap_plant_cane'), ''
                  ) !!}

                  {!! __form::textbox_numeric(
                    '6', 'ap_ratoon_cane', 'text', 'Ratoon Cane (HAS.)', 'Ratoon Cane', old('ap_ratoon_cane') , $errors->has('ap_ratoon_cane'), $errors->first('ap_ratoon_cane'), ''
                  ) !!}

                </div>

              </div>



            </div>

          </div>

          <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="mdl_update_button">Save <i class="fa fa-fw fa-save"></i></button>
          </form>

        </div>
      </div>
    </div>
  </div>
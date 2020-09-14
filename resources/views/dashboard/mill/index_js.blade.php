

<script type="text/javascript">


    {!! __js::button_modal_confirm_delete_caller('mill_delete') !!}


    // ON CLICK RENEW LICENSE
    $(document).on("click", "#rl_button", function () {
      if($(this).data("action") == "rl"){
        $('.select2').select2();
        $('.datepicker').each(function(){
            $(this).datepicker({
                autoclose: true,
                dateFormat: "mm/dd/yy",
                orientation: "bottom"
            });
        });

        $("#mill_rl").modal("show");
        $(".mill_name").text($(this).data("name"));
        $("#rl_body #rl_form").attr("action", $(this).data("url"));

        $("#rl_form #crop_year_id").val($(this).data("crop_year_id")).change();
        $("#rl_form #reg_date").val($(this).data("reg_date"));

      }
    });


    // ON CLICK BILLING STATEMENT
    $(document).on("click", "#bs_button", function () {
      
      if($(this).data("action") == "bs"){

        $('.select2').select2();

        $('.datepicker').each(function(){
            $(this).datepicker({
                autoclose: true,
                dateFormat: "mm/dd/yy",
                orientation: "bottom"
            });
        });

        $("#mill_bs").modal("show");
        $(".mill_name").text($(this).data("name"));
        $("#bs_body #bs_form").attr("action", $(this).data("url"));

        $("#bs_form #crop_year_id").val($(this).data("crop_year_id")).change();
        $("#bs_form #mt").val($(this).data("mt"));
        $("#bs_form #lkg").val($(this).data("lkg"));
        $("#bs_form #milling_fee").val($(this).data("milling_fee"));
        $("#bs_form #payment_status").val($(this).data("payment_status")).change();
        $("#bs_form #under_payment").val($(this).data("under_payment"));
        $("#bs_form #excess_payment").val($(this).data("excess_payment"));
        $("#bs_form #balance_fee").val($(this).data("balance_fee"));
        
        $(".priceformat").priceFormat({
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: true
        });

      }

    });



    // ON CLICK CROP ESTIMATE
    $(document).on("click", "#ml_button", function () {

      $('#mdl_form').hide();
      $('#mdl_update_button').hide();
      $('#mdl_view_button').hide();

      if($(this).data("action") == "ml"){

        $('.select2').select2();

        $('.datepicker').each(function(){
            $(this).datepicker({
                autoclose: true,
                dateFormat: "mm/dd/yy",
                orientation: "bottom"
            });
        });

        $("#mill_ml").modal("show");
        $("#ml_body #ml_form").attr("action", $(this).data("url"));

        {{-- View --}}
        $(".mill_name").text($(this).data("name"));
        $("#v_crop_year").text($(this).data("crop_year_name"));
        $("#v_planter_share").text($(this).data("planter_share"));
        $("#v_mill_share").text($(this).data("mill_share"));
        $("#v_other_share").text($(this).data("other_share"));
        $("#v_rated_capacity").text($(this).data("rated_capacity"));
        $("#v_molasses_tank_first").text($(this).data("molasses_tank_first"));
        $("#v_molasses_tank_second").text($(this).data("molasses_tank_second"));
        $("#v_molasses_tank_third").text($(this).data("molasses_tank_third"));
        $("#v_est_start_milling").text($(this).data("est_start_milling"));
        $("#v_est_end_milling").text($(this).data("est_end_milling"));
        $("#v_start_milling").text($(this).data("start_milling"));
        $("#v_end_milling").text($(this).data("end_milling"));
        $("#v_gtcm_mt").text($(this).data("gtcm_mt"));
        $("#v_raw_mt").text($(this).data("raw_mt"));
        $("#v_raw_lkg").text($(this).data("raw_lkg"));
        $("#v_ah_plant_cane").text($(this).data("ah_plant_cane"));
        $("#v_ah_ratoon_cane").text($(this).data("ah_ratoon_cane"));
        $("#v_ap_plant_cane").text($(this).data("ap_plant_cane"));
        $("#v_ap_ratoon_cane").text($(this).data("ap_ratoon_cane"));

        {{-- Form --}}
        $("#ml_form #crop_year_id").val($(this).data("crop_year_id")).change();
        $("#ml_form #mill_share").val($(this).data("mill_share"));
        $("#ml_form #planter_share").val($(this).data("planter_share"));
        $("#ml_form #other_share").val($(this).data("other_share"));
        $("#ml_form #rated_capacity").val($(this).data("rated_capacity"));
        $("#ml_form #est_start_milling").val($(this).data("est_start_milling"));
        $("#ml_form #est_end_milling").val($(this).data("est_end_milling"));
        $("#ml_form #start_milling").val($(this).data("start_milling"));
        $("#ml_form #end_milling").val($(this).data("end_milling"));
        $("#ml_form #molasses_tank_first").val($(this).data("molasses_tank_first"));
        $("#ml_form #molasses_tank_second").val($(this).data("molasses_tank_second"));
        $("#ml_form #molasses_tank_third").val($(this).data("molasses_tank_third"));
        $("#ml_form #gtcm_mt").val($(this).data("gtcm_mt"));
        $("#ml_form #raw_mt").val($(this).data("raw_mt"));
        $("#ml_form #raw_lkg").val($(this).data("raw_lkg"));
        $("#ml_form #ah_plant_cane").val($(this).data("ah_plant_cane"));
        $("#ml_form #ah_ratoon_cane").val($(this).data("ah_ratoon_cane"));
        $("#ml_form #ap_plant_cane").val($(this).data("ap_plant_cane"));
        $("#ml_form #ap_ratoon_cane").val($(this).data("ap_ratoon_cane"));

        $(".priceformat").priceFormat({
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: true
        });

      }

    });



    // ON CLICK MDL EDIT
    $(document).on("click", "#mdl_edit_button", function () {

      $('#mdl_form').show();
      $('#mdl_update_button').show();
      $('#mdl_view_button').show();
      
      $('#mdl_view').hide();
      $('#mdl_edit_button').hide();

    });



    // ON CLICK MDL VIEW (BACK)
    $(document).on("click", "#mdl_view_button", function () {

      $('#mdl_form').hide();
      $('#mdl_update_button').hide();
      $('#mdl_view_button').hide();
      
      $('#mdl_view').show();
      $('#mdl_edit_button').show();

    });



    // ONCLICK SELECT DISABLE
    $('#payment_status').on('select2:select', function (e) {
      val = $(this).val();
      if(val == "UP"){
        $("#excess_payment").attr('disabled','disabled').val('');
        $("#under_payment").removeAttr("disabled").val('');
        $("#balance_fee").val(0);
      }else if(val == "EP"){
        $("#under_payment").attr('disabled','disabled').val('');
        $("#excess_payment").removeAttr("disabled").val('');
        $("#balance_fee").val(0);
      }else{
        $("#excess_payment").removeAttr("disabled").val('');
        $("#under_payment").removeAttr("disabled").val('');
        $("#balance_fee").val(0);
      }
    });


    // SET KEYUP DELAY
    function delay(callback, ms) {
      var timer = 0;
      return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
          callback.apply(context, args);
        }, ms || 0);
      };
    }


    // INSTANTIATE PRICEFORMAT
    function pf(id) {
      $(id).priceFormat({
        prefix: "",
        thousandsSeparator: ",",
        clearOnEmpty: true,
        allowNegative: true
      });
    }


    // ON FILL UNDERPAYMENT
    $('#under_payment').keyup(delay(function() { 
      balance_fee = 0;
      if ($('#milling_fee').val() != ""){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        underpayment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        up_float = parseFloat(underpayment);
        balance_fee = mf_float + up_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#under_payment').keydown(delay(function() {
      balance_fee = 0;
      if ($('#milling_fee').val() != ""){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        underpayment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        up_float = parseFloat(underpayment);
        balance_fee = mf_float + up_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


    // ON FILL MT
    $('#mt').keyup(delay(function() { 
      lkg = 0;
      if ($('#mt').val() != ""){
        mt = $('#mt').val().replace(/,/g, "");
        mt_float = parseFloat(mt);
        lkg = mt_float * 20;
      }
      $('#lkg').val(lkg.toFixed(2)); 
      pf('#lkg');
    }, 50));

    $('#mt').keydown(delay(function() { 
      lkg = 0;
      if ($('#mt').val() != ""){
        mt = $('#mt').val().replace(/,/g, "");
        mt_float = parseFloat(mt);
        lkg = mt_float * 20;
      }
      $('#lkg').val(lkg.toFixed(2)); 
      pf('#lkg');
    }, 50));


    // ON FILL EXCESS PAYMENT
    $('#excess_payment').keyup(delay(function() { 
      balance_fee = 0;
      if ($('#milling_fee').val() != ""){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float - ep_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#excess_payment').keydown(delay(function() {
      balance_fee = 0;
      if ($('#milling_fee').val() != ""){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float - ep_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


     // ON FILL MILLING FEE
    $('#milling_fee').keyup(delay(function() {
      balance_fee = 0;
      if ($('#payment_status').val() == "UP"){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        under_payment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        up_float = parseFloat(under_payment);
        balance_fee = mf_float + up_float;
      }else if($('#payment_status').val() == "EP"){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float - ep_float;
      }else{
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        balance_fee = mf_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#milling_fee').keydown(delay(function() {
      balance_fee = 0;
      if ($('#payment_status').val() == "UP"){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        under_payment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        up_float = parseFloat(under_payment);
        balance_fee = mf_float + up_float;
      }else if($('#payment_status').val() == "EP"){
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float - ep_float;
      }else{
        milling_fee = $('#milling_fee').val().replace(/,/g, "");
        mf_float = parseFloat(milling_fee);
        balance_fee = mf_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


    // ON RAW MT
    $('#raw_mt').keyup(delay(function() { 
      raw_lkg = 0;
      if ($('#raw_mt').val() != ""){
        raw_mt = $('#raw_mt').val().replace(/,/g, "");
        raw_mt_float = parseFloat(raw_mt);
        raw_lkg = raw_mt_float * 20;
      }
      $('#raw_lkg').val(raw_lkg.toFixed(2)); 
      pf('#raw_lkg');
    }, 50));

    $('#raw_mt').keydown(delay(function() { 
      raw_lkg = 0;
      if ($('#raw_mt').val() != ""){
        raw_mt = $('#raw_mt').val().replace(/,/g, "");
        raw_mt_float = parseFloat(raw_mt);
        raw_lkg = raw_mt_float * 20;
      }
      $('#raw_lkg').val(raw_lkg.toFixed(2)); 
      pf('#raw_lkg');
    }, 50));


    // TOAST
    @if(Session::has('MILL_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_UPDATE_SUCCESS')) !!}
    @endif

    @if(Session::has('MILL_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_DELETE_SUCCESS')) !!}
    @endif

    @if(Session::has('RENEW_LICENSE_SUCCESS') || Session::has('BILLING_STATEMENT_SUCCESS') || Session::has('MILL_LIB_SUCCESS'))
      $('#mill_renew_success').modal('show');
    @endif


  </script>
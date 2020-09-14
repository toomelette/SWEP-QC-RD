<script type="text/javascript">


    {!! __js::button_modal_confirm_delete_caller('mill_registration_delete') !!}


    // ONCLICK UPDATE BUTTON
    $(document).on("click", "#update_button", function () {

      $('.select2').select2();

      $('.datepicker').each(function(){
          $(this).datepicker({
              autoclose: true,
              dateFormat: "mm/dd/yy",
              orientation: "bottom"
          });
      });

      if($(this).data("action") == "update"){

        $("#mill_rl").modal("show");

        $(".mill_name").text($(this).data("name"));
        
        $("#mill_rl_body #mill_rl_form").attr("action", $(this).data("url"));

        $("#mill_rl_form #license_no").val($(this).data("license_no"));
        $("#mill_rl_form #crop_year_id").val($(this).data("crop_year_id")).change();
        $("#mill_rl_form #reg_date").val($(this).data("reg_date"));

        $("#mill_rl_form #mt").val($(this).data("mt"));
        $("#mill_rl_form #lkg").val($(this).data("lkg"));
        $("#mill_rl_form #milling_fee").val($(this).data("milling_fee"));
        $("#mill_rl_form #payment_status").val($(this).data("payment_status")).change();
        $("#mill_rl_form #under_payment").val($(this).data("under_payment"));
        $("#mill_rl_form #excess_payment").val($(this).data("excess_payment"));
        $("#mill_rl_form #balance_fee").val($(this).data("balance_fee"));

        $("#mill_rl_form #mill_share").val($(this).data("mill_share"));
        $("#mill_rl_form #planter_share").val($(this).data("planter_share"));
        $("#mill_rl_form #other_share").val($(this).data("other_share"));
        $("#mill_rl_form #rated_capacity").val($(this).data("rated_capacity"));
        $("#mill_rl_form #est_start_milling").val($(this).data("est_start_milling"));
        $("#mill_rl_form #est_end_milling").val($(this).data("est_end_milling"));
        $("#mill_rl_form #start_milling").val($(this).data("start_milling"));
        $("#mill_rl_form #end_milling").val($(this).data("end_milling"));
        $("#mill_rl_form #molasses_tank_first").val($(this).data("molasses_tank_first"));
        $("#mill_rl_form #molasses_tank_second").val($(this).data("molasses_tank_second"));
        $("#mill_rl_form #molasses_tank_third").val($(this).data("molasses_tank_third"));
        $("#mill_rl_form #gtcm_mt").val($(this).data("gtcm_mt"));
        $("#mill_rl_form #raw_mt").val($(this).data("raw_mt"));
        $("#mill_rl_form #raw_lkg").val($(this).data("raw_lkg"));
        $("#mill_rl_form #ah_plant_cane").val($(this).data("ah_plant_cane"));
        $("#mill_rl_form #ah_ratoon_cane").val($(this).data("ah_ratoon_cane"));
        $("#mill_rl_form #ap_plant_cane").val($(this).data("ap_plant_cane"));
        $("#mill_rl_form #ap_ratoon_cane").val($(this).data("ap_ratoon_cane"));

        if($(this).data("payment_status") == "E"){
          $("#excess_payment").attr('disabled','disabled');
          $("#under_payment").attr('disabled','disabled');
        }else if($(this).data("payment_status") == "UP"){
          $("#excess_payment").attr('disabled','disabled');
        }else if($(this).data("payment_status") == "EP"){
          $("#under_payment").attr('disabled','disabled');
        }

        $(".priceformat").priceFormat({
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: true
        });
        
      }

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


    // TOAST NOTIFICATION
    @if(Session::has('MILL_REG_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_REG_DELETE_SUCCESS')) !!}
    @endif

    @if(Session::has('MILL_RENEW_LICENSE_SUCCESS'))
      $('#mill_renew_success').modal('show');
    @endif

    @if(Session::has('MILL_REG_IS_EXIST'))
      $('#mill_is_exist').modal('show');
    @endif

  </script>
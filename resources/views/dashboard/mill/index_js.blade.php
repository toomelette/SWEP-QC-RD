

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

        $(".mill_name").text($(this).data("name"));
        $("#mill_rl").modal("show");
        $("#rl_body #form").attr("action", $(this).data("url"));
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
        $(".priceformat").priceFormat({
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: true
        });

        $(".mill_name").text($(this).data("name"));
        $("#mill_bs").modal("show");
        $("#bs_body #form").attr("action", $(this).data("url"));
      }
    });


    // ON CLICK CROP ESTIMATE
    $(document).on("click", "#ml_button", function () {
      if($(this).data("action") == "ml"){
        $('.select2').select2();
        $('.datepicker').each(function(){
            $(this).datepicker({
                autoclose: true,
                dateFormat: "mm/dd/yy",
                orientation: "bottom"
            });
        });
        $(".priceformat").priceFormat({
            prefix: "",
            thousandsSeparator: ",",
            clearOnEmpty: true,
            allowNegative: true
        });

        $(".mill_name").text($(this).data("name"));
        $("#mill_ml").modal("show");
        $("#ml_body #form").attr("action", $(this).data("url"));
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


    // TOAST
    @if(Session::has('MILL_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_UPDATE_SUCCESS')) !!}
    @endif

    @if(Session::has('MILL_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('MILL_DELETE_SUCCESS')) !!}
    @endif

    @if(Session::has('RENEW_LICENSE_SUCCESS') || Session::has('BILLING_STATEMENT_SUCCESS') || Session::has('CROP_EST_SUCCESS'))
      $('#mill_renew_success').modal('show');
    @endif

    @if(Session::has('LICENSE_REG_IS_EXIST') || Session::has('BILLING_IS_EXIST') || Session::has('CROP_EST_IS_EXIST'))
      $('#mill_reg_is_exist').modal('show');
    @endif


  </script>
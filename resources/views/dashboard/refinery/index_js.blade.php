


<script type="text/javascript">


    {!! __js::button_modal_confirm_delete_caller('refinery_delete') !!}


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

        $("#refinery_rl").modal("show");
        $(".refinery_name").text($(this).data("name"));
        $("#rl_body #rl_form").attr("action", $(this).data("url"));

        $("#rl_form #crop_year_id").val($(this).data("crop_year_id")).change();
        $("#rl_form #reg_date").val($(this).data("reg_date"));


      }
    });


    // ON CLICK RATED CAPACITY
    $(document).on("click", "#rc_button", function () {
      if($(this).data("action") == "rc"){

        $('.select2').select2();

        $("#refinery_rc").modal("show");
        $(".refinery_name").text($(this).data("name"));
        $("#rc_body #rc_form").attr("action", $(this).data("url"));

        $("#rc_form #crop_year_id").val($(this).data("crop_year_id")).change();
        $("#rc_form #rated_capacity").val($(this).data("rated_capacity"));

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
      if ($('#refinerying_fee').val() != ""){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        underpayment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        up_float = parseFloat(underpayment);
        balance_fee = mf_float - up_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#under_payment').keydown(delay(function() {
      balance_fee = 0;
      if ($('#refinerying_fee').val() != ""){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        underpayment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        up_float = parseFloat(underpayment);
        balance_fee = mf_float - up_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


    // ON FILL EXCESS PAYMENT
    $('#excess_payment').keyup(delay(function() { 
      balance_fee = 0;
      if ($('#refinerying_fee').val() != ""){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#excess_payment').keydown(delay(function() {
      balance_fee = 0;
      if ($('#refinerying_fee').val() != ""){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


     // ON FILL REFINERYING FEE
    $('#refinerying_fee').keyup(delay(function() {
      balance_fee = 0;
      if ($('#payment_status').val() == "UP"){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        under_payment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        up_float = parseFloat(under_payment);
        balance_fee = mf_float - up_float;
      }else if($('#payment_status').val() == "EP"){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }else{
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        balance_fee = mf_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));

    $('#refinerying_fee').keydown(delay(function() {
      balance_fee = 0;
      if ($('#payment_status').val() == "UP"){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        under_payment = $('#under_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        up_float = parseFloat(under_payment);
        balance_fee = mf_float - up_float;
      }else if($('#payment_status').val() == "EP"){
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        excess_payment = $('#excess_payment').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        ep_float = parseFloat(excess_payment);
        balance_fee = mf_float + ep_float;
      }else{
        refinerying_fee = $('#refinerying_fee').val().replace(/,/g, "");
        mf_float = parseFloat(refinerying_fee);
        balance_fee = mf_float;
      }
      $('#balance_fee').val(balance_fee.toFixed(2)); 
      pf('#balance_fee');
    }, 50));


    // TOAST
    @if(Session::has('REFINERY_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('REFINERY_UPDATE_SUCCESS')) !!}
    @endif

    @if(Session::has('REFINERY_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('REFINERY_DELETE_SUCCESS')) !!}
    @endif

    @if(Session::has('RENEW_LICENSE_SUCCESS') || Session::has('RATED_CAPACITY_SUCCESS'))
      $('#refinery_renew_success').modal('show');
    @endif


  </script>
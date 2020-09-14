


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
// Generated by CoffeeScript 1.7.1
(function() {
  window.main = {
    init: function() {
      return main.dfpOrders();
    },
    dfpOrders: function() {
      $('#orders').change(function() {
        var order_id;
        order_id = $(this).val();
        $('#name_order').val($("#orders option:selected").text());
        return $.ajax({
          url: APP_JQ + "/admin/sites/getlinesitems",
          type: "POST",
          data: "order_id=" + order_id,
          beforeSend: function() {
            return $('.load_lines').show();
          },
          success: function(results) {
            $('.load_lines').hide();
            if (results !== "") {
              return $('#line_items').empty().html(results);
            } else {
              return alert("error al obtener lineas de pedido");
            }
          }
        });
      });
      $('.adunit_sel').change(function() {
        var id_adunit, name_adunit;
        id_adunit = $(this).attr("id");
        name_adunit = $("#" + id_adunit + " option:selected").text();
        return $(this).next().val(name_adunit);
      });
      $('.adunit_sel_single').change(function() {
        var id_adunit, name_adunit;
        id_adunit = $(this).attr("id");
        name_adunit = $("#" + id_adunit + " option:selected").text();
        return $("#ZonaAdunitName").val(name_adunit);
      });
      $('#line_items').change(function() {
        return $('#name_lineitem').val($("#line_items option:selected").text());
      });
      return $('#UserEmail').change(function() {
        var email;
        email = $(this).val();
        if (email === "") {
          return false;
        }
        return $.ajax({
          url: APP_JQ + "/admin/users/checkemail",
          type: "POST",
          data: "email=" + email,
          beforeSend: function() {
            $('.check_email').empty().html("Revisando disponibilidad de correo.").show();
            return $('input[type="submit"]').attr('disabled', 'disabled').css('opacity', '.5');
          },
          success: function(results) {
            if (results === "1") {
              $('.check_email').hide().empty();
              return $('input[type="submit"]').removeAttr('disabled').css('opacity', '1');
            } else {
              return $('.check_email').empty().html("El correo ingresado ya se encuentra utilizado.").show();
            }
          }
        });
      });
    }
  };

  $('document').ready(function() {
    return window.main.init();
  });

}).call(this);

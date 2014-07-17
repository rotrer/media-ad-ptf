window.main =
	init: () ->
		main.dfpOrders();
	dfpOrders: () ->
		$('#orders').change () ->
			order_id = $(this).val()
			#nombre orden
			$('#name_order').val( $("#orders option:selected").text() )
			$.ajax
				url: APP_JQ + "/admin/sites/getlinesitems"
				type: "POST"
				data: "order_id=" + order_id
				beforeSend: ->
					$('.load_lines').show()
				success: (results) ->
					$('.load_lines').hide()
					unless results is ""
						$('#line_items').empty().html(results);
					else
						alert "error al obtener lineas de pedido"

		$('.adunit_sel').change () ->
			id_adunit = $(this).attr("id")
			name_adunit = $("#" + id_adunit + " option:selected").text()
			$(this).next().val(name_adunit)

		$('.adunit_sel_single').change () ->
			id_adunit = $(this).attr("id")
			name_adunit = $("#" + id_adunit + " option:selected").text()
			$("#ZonaAdunitName").val(name_adunit)
						
		$('#line_items').change () ->
			#nombre linea pedido
			$('#name_lineitem').val( $("#line_items option:selected").text() )

		$('.checkemail').change () ->
			email = $(this).val()
			if email is ""
				return false
			$.ajax
				url: APP_JQ + "/admin/users/checkemail"
				type: "POST"
				data: "email=" + email
				beforeSend: ->
					$('.check_email').empty().html("Revisando disponibilidad de correo.").show()
					$('input[type="submit"]').attr('disabled','disabled').css('opacity', '.5');
				success: (results) ->
					if results is "1"
						$('.check_email').hide().empty()
						$('input[type="submit"]').removeAttr('disabled').css('opacity', '1');
					else
						$('.check_email').empty().html("El correo ingresado ya se encuentra utilizado.").show()
					

$('document').ready ->
	window.main.init()
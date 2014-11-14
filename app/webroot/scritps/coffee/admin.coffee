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

		$("#newZona").click () ->
			self = $(this)
			$.ajax
				url: APP_JQ + "/admin/plugins/addzona"
				type: "GET"
				data: ""
				beforeSend: ->
					$('.wait-agregar').show()
					self.prop('disabled', true)
				success: (results) ->
					$('.addZona').append results;
					$('.wait-agregar').hide()
					self.prop('disabled', false)
				fail: ->
					self.prop('disabled', false)
					alert	'Error, favor intentar nuevamente'
			return false

		$(document).on "click", ".removeRow", ->
			$(this).parent().parent().remove()

		$(document).on "click", ".zonaDelete", ->
			zona = $(this)
			$.ajax
				url: APP_JQ + "/admin/zonas/delete_async/" + zona.attr('data-zona')
				type: "POST"
				data: ""
				beforeSend: ->

				success: (results) ->
					unless results.response is "1"
						zona.parent().parent().remove()
					else
						alert "error al eliminar zona"
		
		$(document).on "change", ".selectedLine", ->
			adunits = $(this)
			selectTarget = adunits.parent().parent().next().find('select')
			waitSelected = adunits.parent().parent().next().find('.wait-select')
			$.ajax
				url: APP_JQ + "/admin/plugins/getadunits"
				type: "POST"
				data: "adunits=" + adunits.val()
				beforeSend: ->
					waitSelected.show()
					selectTarget.hide()
				success: (results) ->
					waitSelected.hide()
					selectTarget.show()
					unless results is ""
						selectTarget.empty().html(results)
					else
						alert "error al obtener lineas de pedido"
					

$('document').ready ->
	window.main.init()
window.main =
	init: () ->
		main.dfpOrders();
	dfpOrders: () ->
		$("#orders").change () ->
			order_id = $(this).val()
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
					

$('document').ready ->
	window.main.init()
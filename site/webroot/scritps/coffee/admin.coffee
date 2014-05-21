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
						
		$('#line_items').change () ->
			#nombre linea pedido
			$('#name_lineitem').val( $("#line_items option:selected").text() )
					

$('document').ready ->
	window.main.init()
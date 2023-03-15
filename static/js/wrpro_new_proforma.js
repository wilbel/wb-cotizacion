//Autocompletar campos clientes
jQuery(function () {//autocompletar campos productos
	var url = SolicitudesAjax.url;
	jQuery("#nombre_cliente").autocomplete({
		source: function (request, response) {
			jQuery.ajax({
				type: "POST",
				url: url,
				dataType: "json",
				data: {
					action: "wrpro_buscar_cliente",
					nonce: SolicitudesAjax.seguridad,
					term: request.term,
				},
				success: function (data) {
					response(data);
				},
				error: function (result) {
					alert("Error:");
				}
			});
		},
		minLength: 1,
		select: function (event, ui) {
			event.preventDefault();
			jQuery('#nombre_cliente').val(ui.item.value);
			jQuery('#id_cliente').val(ui.item.id_cliente);
			jQuery('#dni_ruc_cliente').val(ui.item.dni_ruc_cliente);
			jQuery('#telefono_cliente').val(ui.item.telefono_cliente);
			jQuery('#email_cliente').val(ui.item.email_cliente);
			jQuery('#cliente_direccion').val(ui.item.direccion_cliente);
		}
	});
});

//Registrar productos
function wrpro_guardar_producto() {
	let nom_prod = document.getElementById("articulo").value;
	let prec_pro = document.getElementById("prec_unit").value;
	let descrip_producto = document.getElementById("descrip_prod").value;
	descrip_producto = descrip_producto.replace(/\n/g, "<br />");
	var url = SolicitudesAjax.url;
	$.ajax({
		url: url,
		type: "POST",
		data: {
			nom_prod: nom_prod,
			descripcion: descrip_producto,
			precio: prec_pro,
			action: "wrpro_peticionRegistrar",
			nonce: SolicitudesAjax.seguridad,
		},
		success: function (datos) {
			agregarDetall(parseInt(datos), nom_prod, prec_pro, descrip_producto);
		}
	});
}

function recogerDatos_producto() {
	let id_pro = document.getElementById("id_pro").value;
	let nombre_producto = document.getElementById("articulo").value;
	let prec_pro = document.getElementById("prec_unit").value;
	let descrip_producto = document.getElementById("descrip_prod").value;
	if (!nombre_producto == '' && !prec_pro == '' && !descrip_producto == '') {
		id_pro = '';
		wrpro_guardar_producto();
	} else {
		alert("Debe ingresar almenos un producto");
	}
}

function wrpro_validar_ingresos() {
	var aux = true;
	var art_articulo = 0;
	var art__descripciones = 0;
	var art__cantidad = 0;
	var art__precio = 0;
	var art__subtotal = 0;
	var articulos = document.getElementsByName("articulo[]");
	var descripcion = document.getElementsByName("descrip_prod[]");
	var cantidad = document.getElementsByName("cantidad[]");
	var precio = document.getElementsByName("precio_venta[]");
	var subtotal = document.getElementsByName("subtotal[]");
	for (var i = 0; i < cantidad.length; i++) {
		var nom_articulo = articulos[i];
		var descripcion_articulo = descripcion[i];
		var cant_articulo = cantidad[i];
		var precio_articulo = precio[i];
		var subtotal_articulo = subtotal[i];
		art_articulo = nom_articulo.value;
		art__descripciones = descripcion_articulo.value;
		art__cantidad = cant_articulo.value;
		art__precio = precio_articulo.value;
		art__subtotal = subtotal_articulo.value;
	}
	if (art_articulo === '' || art__descripciones === '' || art__cantidad === '' || art__precio === '' || art__subtotal === '') {
		aux = false;
	}
	return aux;
}

/**Agregar una fila mas */
function wrpro_add_fila() {
	let nombre_producto = "";// document.getElementById("articulo1").value;
	let prec_pro = ""; //document.getElementById("prec_unit1").value;
	let descrip_producto = ""; //document.getElementById("descrip_prod1").value;
	if (wrpro_validar_ingresos()) {
		agregarDetall(1, nombre_producto, prec_pro, descrip_producto);
	} else {
		alert("Campos requeridos estan vacios");
	}
}

//validar registros
function wrpro_validar_registro() {
	document.getElementById('txtarea_tercond').disabled = false;
	if (wrpro_validar_ingresos()) {
		return true;
	} else {
		alert("Error, existen campos vacios");
		return false;
	}
}

var cont = 0;
var detalles = 0;
var acum = 0;
function agregarDetall(idarticulo, articulo, precio_venta, descrip_product) {

	let acumulador = document.getElementById("contador").value;
	if (acumulador != null || acumulador != '') {
		cont = Number(acumulador) + Number(acum);
		acum++;
	}

	var cantidad = 1;
	if (idarticulo != "") {
		//	let subtotal = cantidad * precio_venta;
		var fila = '<tr class="filas" id="fila' + cont + '">' +
			'<td style="width: 2%;" ><span step="2" id="numeracion" name="numeracion"></span></td>' +
			'<td style="width: 5%;"><input onchange="modificarSubtotales()" style="width: 100%;" min="1" type="number" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>' +
			//'<td><input class="form-control input-lg" type="text" name="articulo[]" id="articulo[]" autocomplete="off" value=""></td>' +
			'<td><textarea class="form-control input-lg" cols="30" rows="10" type="text" name="articulo[]" id="articulo[]" autocomplete="off" value=""></textarea></td>' +
			'<td><textarea style="width: 100%; height:80px " cols="30" rows="10" class="form-control input-sm" id="descrip_prod[]" name="descrip_prod[]" value="' + descrip_product + '">' + descrip_product + '</textarea></td>' +
			'<td  style="width:12%;"><input onchange="modificarSubtotales()" style="width: 100%;" type="number" step="any" name="precio_venta[]" id="precio_venta[]" value=""></td>' +
			'<td><input type="number" onchange="wrpro_calcular_precio()" step="any" id="subtotal[]' + cont + '" name="subtotal[]" value=""></td>' +
			'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')"><i class="fas fa-minus-circle"></i></button></td>' +
			'</tr>';
		cont++;
		detalles++;
		jQuery('#tabla').append(fila);
		modificarSubtotales();
		limpiarcampos();
	} else {
		alert("error al ingresar el detalle, revisar las datos del articulo ");
	}
}
/**
 * Fin del método
 */
function limpiarcampos() {
	jQuery('#id_pro').val("");
	jQuery('#articulo').val("");
	jQuery('#prec_unit').val("");
	jQuery('#descrip_prod').val("");
}
//Calcular total el precio total del producto y totales finales
function modificarSubtotales() {
	var cant = document.getElementsByName("cantidad[]");
	var prev = document.getElementsByName("precio_venta[]");
	var sub = document.getElementsByName("subtotal[]");
	for (var i = 0; i < cant.length; i++) {
		var inpV = cant[i];
		var inpP = prev[i];
		var inpS = sub[i];
		inpS.value = (inpV.value * inpP.value).toFixed(2);//calcular el total
	}
	wrpor_contar_items();
	calcularTotales();
}
//Calcular el precio del producto
function wrpro_calcular_precio() {
	var cant = document.getElementsByName("cantidad[]");
	var prev = document.getElementsByName("precio_venta[]");
	var sub = document.getElementsByName("subtotal[]");
	for (var i = 0; i < cant.length; i++) {
		var inpV = cant[i];
		var inpP = prev[i];
		var inpS = sub[i];
		//inpP.value = (inpS.value / inpV.value).toFixed(5);//calcuar precio de servicio
		inpP.value = (inpS.value / inpV.value);//calcuar precio de servicio
	}
	calcularTotales();
}

//Calcular subtotal e iva con el precio final
function wrpro_calcular_iva_subtotal() {
	let total = document.getElementById("total_all").value;
	let valor_iva = document.getElementById("txt_valor_iva").value;
	//alert(Number(valor_iva)+1);
	let subtotal = (Number(total) / (Number(valor_iva) + 1));//1.12
	iva = total - subtotal;
	jQuery("#iva").val(iva.toFixed(2));
	jQuery("#subtotalall").val(subtotal.toFixed(2));
}
function wrpro_calcular_iva_total() {
	let subtotal = document.getElementById("subtotalall").value;
	let valor_iva = document.getElementById("txt_valor_iva").value;
	let iva = (Number(subtotal) * Number(valor_iva));//0.12
	let total = Number(subtotal) + Number(iva);
	jQuery("#iva").val(iva.toFixed(2));
	jQuery("#total_all").val((total).toFixed(2));
	//dividir el total para   subtotal/1.12
}


function calcularTotales() {
	let sub = document.getElementsByName("subtotal[]");
	//IVA 
	let valor_iva = document.getElementById("txt_valor_iva").value;
	//Descuento
	//let valor_descuento = document.getElementById("txt_valor_desc").value;
	let valor_descuento = document.getElementById("wr_descuento").value;
	
	var total = 0.0;
	for (var i = 0; i < sub.length; i++) {
		total += parseFloat(document.getElementsByName("subtotal[]")[i].value);
	}
	//total
	jQuery("#total").html("$ " + Number(total).toFixed(2));
	jQuery("#subtotalall").val(Number(total).toFixed(2));
	//TOTAL CON DESCUENTO
	var subtotal_desc = Number(total) - Number(valor_descuento);
	jQuery("#txt_subt_desc").html("$ " + Number(subtotal_desc).toFixed(2));
	jQuery("#wr_subt_desc").val(subtotal_desc.toFixed(2));
	//iva
	var iva = subtotal_desc * valor_iva;//0.12
	jQuery("#totaliva").html("$ " + iva.toFixed(2));
	jQuery("#iva").val(iva.toFixed(2));
	//TOTAL
	var totalalls = parseFloat(subtotal_desc) + parseFloat(iva);
	jQuery("#totalall").html("$ " + parseFloat(totalalls).toFixed(2));
	jQuery("#total_all").val(parseFloat(totalalls).toFixed(2));
	wrpro_valiar_button();

}

function wrpor_contar_items() {
	var cont = 0;
	var cant = document.getElementsByName("cantidad[]");
	for (var i = 0; i < cant.length; i++) {
		cont = cont + 1;
		document.getElementsByName("numeracion")[i].innerHTML = cont;//.value.toFixed(2);
	}
}

function wrpro_descuentos() {
	//Descuento Nuevo
	let valor_iva = document.getElementById("txt_valor_iva").value;
	let subtotal = document.getElementById("subtotalall").value;
	let wr_valor_descuento = document.getElementById("wr_descuento").value;
	let subtotal_descuento = Number(subtotal - wr_valor_descuento);
	jQuery("#txt_subt_desc").html("$ " + Number(subtotal_descuento).toFixed(2));
	jQuery("#wr_subt_desc").val(subtotal_descuento.toFixed(2));
	var iva = subtotal_descuento * valor_iva;
	jQuery("#totaliva").html("$ " + iva.toFixed(2));
	jQuery("#iva").val(iva.toFixed(2));
	var totalalls = parseFloat(subtotal_descuento) + parseFloat(iva);
	jQuery("#totalall").html("$ " + parseFloat(totalalls).toFixed(2));
	jQuery("#total_all").val(parseFloat(totalalls).toFixed(2));
	wrpro_valiar_button();
}

function wrpro_valiar_button() {//Validar que registre en caso de  haber un producto
	var total_val = document.getElementById("total_all").value;

	if (detalles > 0 && total_val > 0) {
		document.getElementById('btnGuardar').disabled = false;
	}
	else {
		document.getElementById('btnGuardar').disabled = true;
	}
	//validacion si esta editando
	var validar_crud = document.getElementById("crud").value;
	if (validar_crud === "update") {
		document.getElementById('btnGuardar').disabled = false;
	}
}

function eliminarDetalle(indice) {
	//	alert(indice);
	modificarSubtotales();
	jQuery("#fila" + indice).remove();
	wrpor_contar_items();
	calcularTotales();
	detalles = detalles - 1;
}

function cancelar_operacion() {
	location.reload();
}
//Eliminar datos de los campos autocompletados
jQuery("#nombre_cliente").on("keydown", function (event) {
	if (event.keyCode == jQuery.ui.keyCode.LEFT || event.keyCode == jQuery.ui.keyCode.RIGHT || event.keyCode == jQuery.ui.keyCode.UP || event.keyCode == jQuery.ui.keyCode.DOWN || event.keyCode == jQuery.ui.keyCode.DELETE || event.keyCode == jQuery.ui.keyCode.BACKSPACE) {
		jQuery("#id_cliente").val("");
		jQuery("#dni_ruc_cliente").val("");
		jQuery("#telefono_cliente").val("");
		jQuery("#email_cliente").val("");
		jQuery("#cliente_direccion").val("");
	}
	if (event.keyCode == jQuery.ui.keyCode.DELETE) {
		jQuery("#nombre_cliente").val("");
		jQuery("#id_cliente").val("");
		jQuery("#dni_ruc_cliente").val("");
		jQuery("#telefono_cliente").val("");
		jQuery("#email_cliente").val("");
		jQuery("#cliente_direccion").val("");
	}
});

//activar text Area

function wrpor_activar_txtarea() {
	var isChecked = document.getElementById('txt_check').checked;
	if (isChecked) {
		document.getElementById('txtarea_tercond').disabled = false;
		document.getElementById('txtarea_tercond').disabled = false;
	} else {
		document.getElementById('txtarea_tercond').disabled = true;
	}
}

jQuery(document).ready(function () {
	document.formulario.txtarea_tercond.disabled = true;
	document.getElementById("txtarea_tercond").disabled = true;
	document.getElementById("txtarea_tercond").style.color = "black";
});
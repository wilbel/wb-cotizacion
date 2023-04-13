<div class="container-fluid">
    <div class="contenedor-principal">
        <div class="card-body">
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST" name="formulario">
                <input type='hidden' name='action' value='wrpro-pro-proforma'>
                <input type='hidden' name='crud' id="crud" value='<?= $aux; ?>'>
                <input type="hidden" id="txt_valor_iva" name="txt_valor_iva" value="<?= $valor_iva; ?>">
                <hr color="#1EB2B7">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <img class="img-logo" width="80%" src="<?= $url_imagen; ?>">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label><?=$titulo;?></label>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <u>
                                <h5 class="" style="border-radius: 4px; color:#1EB2B7"> <?= $mensaje; ?> </h5>
                            </u>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <label for="">Cotización N°: </label>
                            <input class="form-control text-center" value="<?= $codigo_cotizacion; ?>" type="number" name="id_proforma" id="id_proforma" required readonly>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <label for="">Fecha(*): </label>
                            <input type="date" class="form-control input-sm" name="fecha_ini" id="fecha_ini" value="<?= $fecha_proforma ?>" readonly>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <label for="">Valido Hasta(*): </label>
                            <input class="form-control" type="date" min="<?php echo date("Y-m-d") ?>" name="fecha_fin" id="fecha_fin" value="<?= $fecha__fin_proforma ?>" required>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <h4 class="header-titulo" style="padding:5px"><?php _e('Datos del Cliente para realizar la cotización') ?></h4>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <label for="">Cliente(*): </label>
                            <input type="text" class="form-control input-sm" name="nombre_cliente" id="nombre_cliente" placeholder="Seleccione un cliente" value="<?= $nombre_cliente ?>" required>
                            <input id="id_cliente" name="id_cliente" type='hidden' value="<?= $id_cliente; ?>">
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">RUC/Cédula : </label>
                                <input type="number" class="form-control input-sm" name="dni_ruc_cliente" id="dni_ruc_cliente" placeholder="Ruc/Cédula" value="<?= $dni_ruc_cliente ?>">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Teléfono: </label>
                                <input type="number" class="form-control input-sm" name="telefono_cliente" id="telefono_cliente" placeholder="Teléfono" value="<?= $telf_cliente  ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <label for="">Email: </label>
                            <input type="email" class="form-control input-sm" name="email_cliente" id="email_cliente" placeholder="Email" value="<?= $email_cliente ?>">
                        </div>
                        <div class="form-group col-lg-12 col-md-12 col-xs-12">
                            <label for="">Dirección: </label>
                            <input type="text" class="form-control input-sm" name="cliente_direccion" id="cliente_direccion" placeholder="Dirección" value="<?= $observ_cliente  ?>">
                        </div>
                    </div>
                </div>

                <div class="alert alert-secondary" role="alert">
                    <?php echo ('Para configurar el valor del IVA , diríjase a <a href="admin.php?page=wbct_menu_configuracion">Configuraciones</a>. Valor actual del IVA:' . ($valor_iva * 100)) . '%'; ?>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-lg-1 col-md-1 col-xs-12">
                        <button type="button" onclick="wrpro_add_fila();" name="registrar" class="btn btn-success btn-block"><i class="fas fa-plus-square"></i></button>
                    </div>
                </div>

                <table id="tabla" class="table-responsive table table-striped table-bordered table-condensed table-hover">
                    <thead style="background-color:#f7f7f7; color:#000000; font-size:14px;">
                        <th style="width:10%;">#</th>
                        <th style="width:5%;">Cantidad</th>
                        <th style="width:20%;">Producto</th>
                        <th style="width:35%;">Descripción</th>
                        <th style="width:10%;">Precio</th>
                        <th style="width:20%;">Valor</th>
                    </thead>
                    <?php
                    $cont = 0;
                    if (isset($_GET['id'])) {
                        foreach ($load_det_proforma  as  $key => $row) {
                            $nombre_producto = $wrpro_load_datos->wbct_retornar_nombre_producto("wbct_producto", $row->codigo_producto);
                            $descripcion_producto = $wrpro_load_datos->wbct_retornar_descripcion_producto("wbct_producto", $row->codigo_producto); ?>
                            <tr class="filas" id="fila<?= $key ?>">
                                <td style="width: 2%;"><span step="2" id="numeracion" name="numeracion"><?= $key + 1; ?></span> </td>
                                <td style="width: 5%;"><input onchange="modificarSubtotales()" style="width: 100%;" min="1" type="number" name="cantidad[]" id="cantidad[]" value="<?= $row->cant_item; ?>"></td>
                                <td><textarea style="width: 100%; height:80px" class="form-control input-lg" type="text" name="articulo[]" id="articulo[]" autocomplete="off" value="<?= $nombre_producto ?>"><?= $nombre_producto ?> </textarea></td>
                                <td><textarea style="width: 100%; height:80px" class="form-control input-sm" id="descrip_prod[]" name="descrip_prod[]" value="<?= $descripcion_producto ?>"><?= $descripcion_producto ?></textarea></td>
                                <?php $cantidad_decimales = strpos(strrev($row->prec_unit), ".");
                                if ($cantidad_decimales < 3) {
                                    $precio_uni_formateado = number_format($row->prec_unit, 2, '.', '');
                                } else {
                                    $precio_uni_formateado = number_format($row->prec_unit, 6, '.', '');
                                } ?>
                                <td style="width:12%;"><input onchange="modificarSubtotales()" style="width: 100%;" type="number" step="any" name="precio_venta[]" id="precio_venta[]" value="<?= $precio_uni_formateado;/* number_format($row->prec_unit, 5, '.', '')*/ ?>"></td>
                                <td><input type="number" onchange="wrpro_calcular_precio()" step="any" id="subtotal[]" name="subtotal[]" value="<?= number_format($row->subtotal, 2, '.', '') ?>"></td>
                                <td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(<?= $key; ?>)"><i class="fas fa-minus-circle"></i></button></td>
                            </tr>
                    <?php $cont++;
                        }
                    } ?>
                    <tfoot>
                        <th>TOTAL</th>
                        <th> </th>
                        <th> </th>
                        <th> </th>
                        <th>
                            <h6>Subtotal:</h6><br>
                            <h6>Desc. $:</h6><br>
                            <h6>Subt. Desc:</h6><br>
                            <h6>IVA <?= ($valor_iva * 100) ?>%:</h6><br>
                            <h6>Total:</h6>
                        </th>
                        <th>
                            <input type="hidden" name="contador" id="contador" value="<?= $cont ?>">
                            <div class="form-group">
                                <h6 style="display:none" id="total">$ <?= number_format($subtotal_proforma, 2, '.', '') ?></h6><input type="number" step="any" onchange="wrpro_calcular_iva_total();" name="subtotalall" id="subtotalall" value="<?= number_format($subtotal_proforma, 2, '.', '') ?>">
                            </div>
                            <div class="form-group">
                                <h6 style="display:none" id="txt_descuento">$ <?= number_format($decuento, 2, '.', '') ?></h6><input type="number" step="any" onchange="wrpro_descuentos();" name="wr_descuento" id="wr_descuento" value="<?= number_format($decuento, 2, '.', '') ?>">
                            </div>
                            <div class="form-group">
                                <h6 style="display:none" id="txt_subt_desc">$ <?= number_format($subtotal_desc, 2, '.', '') ?></h6><input type="number" step="any" name="wr_subt_desc" id="wr_subt_desc" value="<?= number_format($subtotal_desc, 2, '.', '') ?>" readonly>
                            </div>
                            <div class="form-group">
                                <h6 style="display:none" id="totaliva">$ <?= number_format($iva_proforma, 2, '.', '') ?></h6><input type="number" step="any" name="iva" id="iva" value="<?= number_format($iva_proforma, 2, '.', '') ?>" readonly>
                            </div>
                            <div class="form-group">
                                <h6 style="display:none" id="totalall">$ <?= number_format($total_proforma, 2, '.', '') ?></h6><input step="any" onchange="wrpro_calcular_iva_subtotal();" type="number" name="total_all" id="total_all" value="<?= number_format($total_proforma, 2, '.', '') ?>">
                            </div>
                        </th>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
                <div class="row">
                    <div class="form-group col-lg-8 col-md-6 col-sm-12 col-xs-12">
                        <p> <input type="checkbox" id="txt_check" onclick="wrpor_activar_txtarea();"> Editar </p>
                        <p><textarea style="height:auto; text-align:justify;" class="form-control" name="txtarea_tercond" id="txtarea_tercond" cols="0" rows="5" value="<?= $terminos_condiciones ?>"><?= $terminos_condiciones ?></textarea></p>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success" name="btnGuardar" id="btnGuardar" <?= $wrpro_estado ?> onclick="return wrpro_validar_registro();"><i class="fa fa-save"></i> Guardar</button>
                        </div>
                        <div class="btn-group">
                            <a style="display:<?= $ocultar_cancelar_save;  ?>" href="admin.php?page=wbct_menu" class="btn btn-warning"> <i class="fas fa-minus-circle"></i> Cancelar</a>
                        </div>
                        <div class="btn-group">
                            <a style="display:<?= $ocultar_cancelar_update; ?>" href="admin.php?page=wbct_menu" class="btn btn-warning"> <i class="fas fa-minus-circle"></i> Cancelar</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
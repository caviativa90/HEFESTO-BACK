<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;

class Pedido extends ResourceController
{
    protected $request;
    protected $modelName = 'App\Models\PedidoModel';
    protected $format = "json";

    public function cargar_archivo_pedido()
    {

        $contador_insertar = 0;
        $contador_error = 0;
        $data = json_decode(file_get_contents("php://input"), true);
        $myTime = new Time('now');

        $datos_carga_insertar = array(
            "ID_USUARIO" => $data["usuario"],
            "FECHA" => $myTime,
            "TIPO" => "PEDIDO",
            "INSERTADOS" => 0,
            "EDITADOS" => 0,
            "ERRORES" => 0
        );
        $id_carga = $this->model->insertar_carga($datos_carga_insertar);

        foreach ($data["data"] as $fila) {
            $errores_validacion = "";
            $validacion = true;
            $Tipo_Documento = trim($fila["TipoDocumento"]);
            if ($Tipo_Documento == "") {
                $validacion = false;
                $errores_validacion .= "El número de Tipo Documento no es válido. ";
            }
            $prefijo = trim($fila["prefijo"]);
            if ($prefijo == "") {
                $validacion = false;
                $errores_validacion .= "El campo prefijo no es válido. ";
            }
            $DocumentoNúmero = trim($fila["DocumentoNumero"]);
            if ($DocumentoNúmero == "") {
                $validacion = false;
                $errores_validacion .= "El campo DocumentoNúmero no es válido.";
            }

            $Fecha1 = trim($fila["Fecha"]);
            $UNIX_DATE = ($Fecha1 - 25569) * 86400;
            $Fecha = gmdate("Y-m-d", $UNIX_DATE);

            $Tercero_Externo = trim($fila["TerceroExterno"]);
            if ($Tercero_Externo == "") {
                $validacion = false;
                $errores_validacion .= "El campo Tercero Externo no es válido.";
            }
            $NúmDocumentoExterno = trim($fila["NumDocumentoExterno"]);
            if ($NúmDocumentoExterno == "") {
                $validacion = false;
                $errores_validacion .= "El campo NúmDocumentoExterno no es válido. ";
            }
            $Producto = trim($fila["Producto"]);
            if ($Producto == "") {
                $validacion = false;
                $errores_validacion .= "El campo Producto no es válido. ";
            }
            $Cantidad = trim($fila["Cantidad"]);
            if ($Cantidad == "") {
                $validacion = false;
                $errores_validacion .= "El campo Cantidad no es válido. ";
            }
            $Iva = trim($fila["Iva"]);
            if ($Iva == "") {
                $validacion = false;
                $errores_validacion .= "El campo Iva no es válido.";
            }
            $Valor = trim($fila["Valor"]);
            if ($Valor == "") {
                $validacion = false;
                $errores_validacion .= "El campo Valor no es válido. ";
            }
            $NOTA = trim($fila["Personalizado1Det"]);
            $NOTA_EQUIPO = trim($fila["Personalizado2Det"]);
            //datos
            $datos_insertar_carga = array(
                "DOCUMENTO" => $Tipo_Documento . " " . $prefijo . " " . $DocumentoNúmero,
                "FECHA" => $Fecha,
                "CLIENTE" => $Tercero_Externo,
                "DOCUMENTO_EXTERNO" => $NúmDocumentoExterno,
                "REFERENCIA" => $Producto,
                "CANTIDAD" => $Cantidad,
                "IVA" => $Iva,
                "VALOR" => $Valor,
                "NOTA" => $NOTA,
                "NOTA_EQUIPO" => $NOTA_EQUIPO

            );

            if ($validacion) {
                $documento = $Tipo_Documento . " " . $prefijo . " " . $DocumentoNúmero;
                $arr_ya_existe = $this->model->get_pedido_existe($documento, $Producto);
                if ($arr_ya_existe) {

                    //$contador_editar++;

                } else {
                    $this->model->insertar_pedidos($datos_insertar_carga);
                    $contador_insertar++;
                    $datos_item_carga = array(
                        "ID_CARGA" => $id_carga,
                        "TIPO" => "INSERCION",
                        "DATOS" => json_encode($datos_insertar_carga)
                    );
                    $this->model->insertar_item($datos_item_carga);
                }


            } else {
                // no pasa la validación
                $contador_error++;
                $datos_insertar_carga["ERROR"] = $errores_validacion;
                $datos_item_carga = array(
                    "ID_CARGA" => $id_carga,
                    "TIPO" => "ERROR",
                    "DATOS" => json_encode($datos_insertar_carga)
                );
                $this->model->insertar_item($datos_item_carga);

            }
        }

        $carga_datos_editar = array(
            "INSERTADOS" => $contador_insertar,
            "ERRORES" => $contador_error
        );
        $this->model->editar_carga($id_carga, $carga_datos_editar);
        return $this->respond(array("code" => 200, "msg" => $carga_datos_editar));
    }
    public function cargar_archivo_contrato()
    {
        $contador_insertar = 0;
        $contador_error = 0;
        $contador_editar = 0;
        $data = json_decode(file_get_contents("php://input"), true);
        $fecha_hora_actual = date('Y-m-d H:i:s');

        $datos_carga_insertar = array(
            "ID_USUARIO" => $data["usuario"],
            "FECHA" => $fecha_hora_actual,
            "TIPO" => "CONTRATO",
            "INSERTADOS" => 0,
            "EDITADOS" => 0,
            "ERRORES" => 0
        );
        $id_carga = $this->model->insertar_carga($datos_carga_insertar);
        // Agrupar los registros por NumDocumentoContrato
        $agrupados_por_documento = [];

        // Iterar sobre cada fila de datos
        foreach ($data["data"] as $fila) {
            $NumDocumentoContrato = trim($fila["NumDocumentoContrato"]);
            $agrupados_por_documento[$NumDocumentoContrato][] = $fila;
        }
        $contador = 0;

        // Recorrer los grupos de registros
        foreach ($agrupados_por_documento as $NumDocumentoContrato => $registros) {
            // Verificar si el contrato ya existe en la base de datos
            $arr_ya_existe = $this->model->get_contrato_existe($NumDocumentoContrato);

            if (!$arr_ya_existe) {
                // Insertar todos los registros con el mismo número de contrato
                foreach ($registros as $fila) {
                    $errores_validacion = "";
                    $validacion = true;
                    $Pedido = trim($fila["Pedido"]);
                    if ($Pedido == "") {
                        $validacion = false;
                        $errores_validacion .= "El campo Pedido no es válido.";
                    }

                    $Fecha1 = trim($fila["FechaProgramacion"]);
                    $UNIX_DATE = ($Fecha1 - 25569) * 86400;
                    $FechaProgramacion = gmdate("Y-m-d", $UNIX_DATE);

                    $Fecha2 = trim($fila["FechaLimite"]);
                    $UNIX_DATE = ($Fecha2 - 25569) * 86400;
                    $FechaLimite = gmdate("Y-m-d", $UNIX_DATE);

                    $Tercero_Externo = trim($fila["TerceroExterno"]);
                    if ($Tercero_Externo == "") {
                        $validacion = false;
                        $errores_validacion .= "El campo TerceroExterno no es válido.";
                    }
                    $NumDocumentoContrato = trim($fila["NumDocumentoContrato"]);
                    if ($NumDocumentoContrato == "") {
                        $validacion = false;
                        $errores_validacion .= "El campo NumDocumentoContrato no es válido. ";
                    }
                    $Producto = trim($fila["Producto"]);
                    if ($Producto == "") {
                        $validacion = false;
                        $errores_validacion .= "El campo Producto no es válido. ";
                    }
                    $Cantidad = trim($fila["Cantidad"]);
                    if ($Cantidad == "") {
                        $validacion = false;
                        $errores_validacion .= "El campo Cantidad no es válido. ";
                    }
                    $Iva = trim($fila["Iva"]);
                    if ($Iva == "") {
                        $validacion = false;
                        $errores_validacion .= "El campo Iva no es válido.";
                    }
                    $Valor = trim($fila["Valor"]);
                    if ($Valor == "") {
                        $validacion = false;
                        $errores_validacion .= "El campo Valor no es válido. ";
                    }
                    $Nota = trim($fila["Nota"]);
                    $Equipo = trim($fila["Equipo"]);
                    //datos
                    $datos_insertar_carga = array(
                        "DOCUMENTO" => $Pedido,
                        "FECHA" => $FechaProgramacion,
                        "CLIENTE" => $Tercero_Externo,
                        "DOCUMENTO_EXTERNO" => $NumDocumentoContrato,
                        "REFERENCIA" => $Producto,
                        "CANTIDAD" => $Cantidad,
                        "IVA" => $Iva,
                        "VALOR" => $Valor,
                        "NOTA" => $Nota,
                        "NOTA_EQUIPO" => $Equipo,
                        "ESTADO" => 0,
                        "FECHA_LIMITE" => $FechaLimite
                    );

                    if ($validacion) {

                        $datos_insertar_carga = array(
                            "DOCUMENTO" => $Pedido,
                            "FECHA" => $FechaProgramacion,
                            "CLIENTE" => $Tercero_Externo,
                            "DOCUMENTO_EXTERNO" => $NumDocumentoContrato,
                            "REFERENCIA" => $Producto,
                            "CANTIDAD" => $Cantidad,
                            "IVA" => $Iva,
                            "VALOR" => $Valor,
                            "NOTA" => $Nota,
                            "NOTA_EQUIPO" => $Equipo,
                            "ESTADO" => 0,
                            "FECHA_LIMITE" => $FechaLimite
                        );


                        // Insertar los datos en la base de datos
                        $this->model->insertar_contratos($datos_insertar_carga);
                        $contador_insertar++;

                        // Insertar el item correspondiente
                        $datos_item_carga = [
                            "ID_CARGA" => $id_carga,
                            "TIPO" => "INSERCION",
                            "DATOS" => json_encode($datos_insertar_carga)
                        ];
                        $this->model->insertar_item($datos_item_carga);

                    } else {
                        // no pasa la validación
                        $contador_error++;
                        $datos_insertar_carga["ERROR"] = $errores_validacion;
                        $datos_item_carga = array(
                            "ID_CARGA" => $id_carga,
                            "TIPO" => "ERROR",
                            "DATOS" => json_encode($datos_insertar_carga)
                        );
                        $this->model->insertar_item($datos_item_carga);

                    }


                }
            } else {
                $contador_editar++;
            }
        }
        $carga_datos_editar = array(
            "INSERTADOS" => $contador_insertar,
            "EDITADOS" => $contador_editar,
            "ERRORES" => $contador_error
        );
        $this->model->editar_carga($id_carga, $carga_datos_editar);
        return $this->respond(array("code" => 200, "msg" => $agrupados_por_documento));
    }
    public function cargar_archivo_contrato_()
    {
        $contador_insertar = 0;
        $contador_error = 0;
        $contador_editar = 0;
        $data = json_decode(file_get_contents("php://input"), true);
        $fecha_hora_actual = date('Y-m-d H:i:s');

        $datos_carga_insertar = array(
            "ID_USUARIO" => $data["usuario"],
            "FECHA" => $fecha_hora_actual,
            "TIPO" => "CONTRATO",
            "INSERTADOS" => 0,
            "EDITADOS" => 0,
            "ERRORES" => 0
        );
        $id_carga = $this->model->insertar_carga($datos_carga_insertar);

        foreach ($data["data"] as $fila) {
            $errores_validacion = "";
            $validacion = true;
            $Pedido = trim($fila["Pedido"]);
            if ($Pedido == "") {
                $validacion = false;
                $errores_validacion .= "El campo Pedido no es válido.";
            }

            $Fecha1 = trim($fila["FechaProgramacion"]);
            $UNIX_DATE = ($Fecha1 - 25569) * 86400;
            $FechaProgramacion = gmdate("Y-m-d", $UNIX_DATE);

            $Fecha2 = trim($fila["FechaLimite"]);
            $UNIX_DATE = ($Fecha2 - 25569) * 86400;
            $FechaLimite = gmdate("Y-m-d", $UNIX_DATE);

            $Tercero_Externo = trim($fila["TerceroExterno"]);
            if ($Tercero_Externo == "") {
                $validacion = false;
                $errores_validacion .= "El campo TerceroExterno no es válido.";
            }
            $NumDocumentoContrato = trim($fila["NumDocumentoContrato"]);
            if ($NumDocumentoContrato == "") {
                $validacion = false;
                $errores_validacion .= "El campo NumDocumentoContrato no es válido. ";
            }
            $Producto = trim($fila["Producto"]);
            if ($Producto == "") {
                $validacion = false;
                $errores_validacion .= "El campo Producto no es válido. ";
            }
            $Cantidad = trim($fila["Cantidad"]);
            if ($Cantidad == "") {
                $validacion = false;
                $errores_validacion .= "El campo Cantidad no es válido. ";
            }
            $Iva = trim($fila["Iva"]);
            if ($Iva == "") {
                $validacion = false;
                $errores_validacion .= "El campo Iva no es válido.";
            }
            $Valor = trim($fila["Valor"]);
            if ($Valor == "") {
                $validacion = false;
                $errores_validacion .= "El campo Valor no es válido. ";
            }
            $Nota = trim($fila["Nota"]);
            $Equipo = trim($fila["Equipo"]);
            //datos
            $datos_insertar_carga = array(
                "DOCUMENTO" => $Pedido,
                "FECHA" => $FechaProgramacion,
                "CLIENTE" => $Tercero_Externo,
                "DOCUMENTO_EXTERNO" => $NumDocumentoContrato,
                "REFERENCIA" => $Producto,
                "CANTIDAD" => $Cantidad,
                "IVA" => $Iva,
                "VALOR" => $Valor,
                "NOTA" => $Nota,
                "NOTA_EQUIPO" => $Equipo,
                "ESTADO" => 0,
                "FECHA_LIMITE" => $FechaLimite
            );

            if ($validacion) {
                $arr_ya_existe = $this->model->get_contrato_existe($NumDocumentoContrato);
                if ($arr_ya_existe) {

                    $contador_editar++;

                } else {
                    $this->model->insertar_contratos($datos_insertar_carga);
                    $contador_insertar++;
                    $datos_item_carga = array(
                        "ID_CARGA" => $id_carga,
                        "TIPO" => "INSERCION",
                        "DATOS" => json_encode($datos_insertar_carga)
                    );
                    $this->model->insertar_item($datos_item_carga);
                }


            } else {
                // no pasa la validación
                $contador_error++;
                $datos_insertar_carga["ERROR"] = $errores_validacion;
                $datos_item_carga = array(
                    "ID_CARGA" => $id_carga,
                    "TIPO" => "ERROR",
                    "DATOS" => json_encode($datos_insertar_carga)
                );
                $this->model->insertar_item($datos_item_carga);

            }
        }

        $carga_datos_editar = array(
            "INSERTADOS" => $contador_insertar,
            "EDITADOS" => $contador_editar,
            "ERRORES" => $contador_error
        );
        $this->model->editar_carga($id_carga, $carga_datos_editar);
        return $this->respond(array("code" => 200, "msg" => $carga_datos_editar));
    }
    function get_pedido()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_PEDIDO = $data->ID_PEDIDO;
        $USER = $this->model->get_pedido($ID_PEDIDO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }

    function get_contrato()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_PEDIDO = $data->ID_PEDIDO;
        $USER = $this->model->get_contrato($ID_PEDIDO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    function listar_cargas_pedidos()
    {
        $arr_cargas = $this->model->consultarTodosCargaPedidos();
        return $this->respond($arr_cargas);
    }

    function listar_cargas_contratos()
    {
        $arr_cargas = $this->model->consultarTodosCargaContratos();
        return $this->respond($arr_cargas);
    }
    function obtener_detalle_insertados_carga()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_CARGA = $data->ID_CARGA;
        $datos = $this->model->obtener_detalle_insertados_carga($ID_CARGA);
        return $this->respond($datos);
    }

    function obtener_detalle_errores_carga()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_CARGA = $data->ID_CARGA;
        $datos = $this->model->obtener_detalle_errores_carga($ID_CARGA);
        return $this->respond($datos);
    }
    function listar_pedidos()
    {
        $arr_cargas = $this->model->listar_pedidos();
        return $this->respond($arr_cargas);
    }
    function listar_contratos()
    {
        $arr_cargas = $this->model->listar_contratos();
        return $this->respond($arr_cargas);
    }
    function listar_odt()
    {
        $arr_cargas = $this->model->listar_odt();
        return $this->respond($arr_cargas);
    }
    function listar_odt_nueva()
    {
        $arr_cargas = $this->model->listar_odt_nueva();
        return $this->respond($arr_cargas);
    }
    function listar_odt_terceros()
    {
        $arr_cargas = $this->model->listar_odt_terceros();
        return $this->respond($arr_cargas);
    }
    function listar_odt_contratos()
    {
        $arr_cargas = $this->model->listar_odt_contratos();
        return $this->respond($arr_cargas);
    }
    function listar_odt_all()
    {
        $arr_cargas = $this->model->listar_odt_all();
        return $this->respond($arr_cargas);
    }
    function listar_odt_all_fechas()// ACA
    {
        $data = json_decode(file_get_contents("php://input"));
        $FECHA_INICIO = $data->FECHA_INICIO;
        $FECHA_FIN = $data->FECHA_FIN;
        $array_evniar = array();
        $arr_odt = $this->model->listar_odt_all_fechas($FECHA_INICIO, $FECHA_FIN);
        foreach ($arr_odt as $registro) {
            $odt_original_garantia = $this->model->get_odt_id_all($registro->NOTA); //consulta normal 
            if (!empty($odt_original_garantia)) {

                $registro->ODT_ID__ORIGINAL = $odt_original_garantia[0]->ID_ODT;
                $registro->ODT_SERVICIO_ORIGINAL = $odt_original_garantia[0]->SERVICO;
                $registro->TIPO_SERVICIO_ORIGINAL = $odt_original_garantia[0]->TIPO_SERVICIO;
                $registro->NOMBRES_INGENIERO_ORIGINAL = $odt_original_garantia[0]->NOMBRES_INGENIERO;

            }

            array_push($array_evniar, $registro);
        }
        return $this->respond($array_evniar);
    }

    function listar_odt_ingenieros_nueva()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_INGENIERO = $data->ID_INGENIERO;
        $arr_cargas = $this->model->listar_odt_ingenieros_nueva($ID_INGENIERO);
        return $this->respond($arr_cargas);
    }
    function listar_odt_ingenieros()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_INGENIERO = $data->ID_INGENIERO;
        $arr_cargas = $this->model->listar_odt_ingenieros($ID_INGENIERO);
        return $this->respond($arr_cargas);
    }

    function get_ultima_ingeniero_odt()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_INGENIERO = $data->ID_INGENIERO;
        $result = $this->model->get_ultima_ingeniero_odt($ID_INGENIERO);
        return $this->respond($result);
    }
    function get_ingenieroS_nivel()
    {
        $data = json_decode(file_get_contents("php://input"));
        $NIVEL = $data->NIVEL;
        $result = $this->model->get_ingenieroS_nivel($NIVEL);
        return $this->respond($result);
    }
    function programar_pedidos()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_USUARIO = $data->ID_USUARIO;
        $contador_insertar = 0;
        $contador_error = 0;
        $pedidos = $this->model->listar_pedidos();
        $contador_ingneiro = 0;

        foreach ($pedidos as $pedido) {


            $nit_cliente = $pedido->CLIENTE;
            $REFERENCIA = $pedido->REFERENCIA;
            $NOTA_EQUIPO = $pedido->NOTA_EQUIPO;

            $existe_cliente = $this->model->get_existe_cliente($nit_cliente);
            if (!empty($existe_cliente)) {
                $existe_servicio = $this->model->get_servicio_codigo($REFERENCIA);

                if (!empty($existe_servicio)) {
                    $existe_equipo = $this->model->get_equipo_cliente($NOTA_EQUIPO, $nit_cliente);
                    if (!empty($existe_equipo)) {

                        $array_ingenieros_nivel = $this->model->get_ingenieroS_nivel($existe_servicio[0]->NIVEL_INGENIERO);
                        $cont = count($array_ingenieros_nivel);

                        $ingeniero = $array_ingenieros_nivel[$contador_ingneiro];
                        $id_ingeniero = $ingeniero->ID;
                        $odt_ingeniero = $this->model->get_ultima_ingeniero_odt($id_ingeniero);
                        $hoy = new \DateTime();
                        $hoy->setTimezone(new \DateTimeZone('America/Bogota'));
                        $hoy->modify('+7 day');
                        $hoy_mas = $hoy->format('Y-m-d H:i:s');
                        $validar = true;
                        if (!empty($odt_ingeniero)) {

                            if ($odt_ingeniero[0]->FECHA_FIN_PROGRAMACION > $hoy_mas) {
                                $contador_ingneiro = $contador_ingneiro + 1;

                                if ($contador_ingneiro <= $cont) {
                                    $ingeniero = $array_ingenieros_nivel[$contador_ingneiro];
                                    $id_ingeniero = $ingeniero->ID;


                                } else {

                                    $validar = false;
                                    $contador_error++;


                                }
                            }
                        }
                        if ($validar) {


                            $i = 1;

                            for ($i; $i <= 7; $i++) {

                                $inicio = new \DateTime();
                                $inicio->setTimezone(new \DateTimeZone('America/Bogota'));
                                $inicio->modify('+' . $i . 'day');
                                $numero_dia_semana = (int) $inicio->format('w');
                                if ($numero_dia_semana === 6 || $numero_dia_semana === 0) {

                                } else {
                                    $inicio->setTime(8, 0, 0);
                                    $fecha_final_dia = clone $inicio;
                                    $fecha_final_dia->setTime(17, 0, 0);
                                    $final = clone $inicio;
                                    $final->modify('+' . $existe_servicio[0]->DURACION_ESTIMADA . ' hours');
                                    $fecha_para_bd_inicio = $inicio->format('Y-m-d H:i:s');
                                    $fecha_para_bd_final = $final->format('Y-m-d H:i:s');

                                    $x = true;
                                    while ($x) {
                                        $programacion_ing = $this->model->get_programacion_ingeniero_hora($id_ingeniero, $fecha_para_bd_inicio, $fecha_para_bd_final);
                                        if (!empty($programacion_ing)) {

                                            $inicial_a = \DateTime::createFromFormat('Y-m-d H:i:s', $programacion_ing[0]->FECHA_FIN_PROGRAMACION);
                                            $inicial_a->modify('+1 hours');
                                            $final_a = clone $inicial_a;
                                            $final_a->modify('+' . $existe_servicio[0]->DURACION_ESTIMADA . ' hours');
                                            $fecha_para_bd_inicio2 = $inicial_a->format('Y-m-d H:i:s');
                                            $fecha_para_bd_final2 = $final_a->format('Y-m-d H:i:s');
                                            if ($final_a > $fecha_final_dia) {
                                                $x = false;
                                            } else {

                                                $programacion_ing2 = $this->model->get_programacion_ingeniero_hora($id_ingeniero, $fecha_para_bd_inicio2, $fecha_para_bd_final2);
                                                if (!empty($programacion_ing2)) {

                                                    $inicial_b = \DateTime::createFromFormat('Y-m-d H:i:s', $programacion_ing2[0]->FECHA_FIN_PROGRAMACION);
                                                    $inicial_b->modify('+1 hours');
                                                    $fecha_final_dia = clone $inicial_b;
                                                    $fecha_final_dia->setTime(17, 0, 0);
                                                    $final_b = clone $inicial_b;
                                                    $final_b->modify('+' . $existe_servicio[0]->DURACION_ESTIMADA . ' hours');
                                                    $fecha_para_bd_inicio3 = $inicial_b->format('Y-m-d H:i:s');
                                                    $fecha_para_bd_final3 = $final_b->format('Y-m-d H:i:s');

                                                    if ($final_b > $fecha_final_dia) {
                                                        $x = false;
                                                    } else {
                                                        $programacion_ing3 = $this->model->get_programacion_ingeniero_hora($id_ingeniero, $fecha_para_bd_inicio3, $fecha_para_bd_final3);
                                                        if (!empty($programacion_ing3)) {

                                                            $inicial_c = \DateTime::createFromFormat('Y-m-d H:i:s', $programacion_ing3[0]->FECHA_FIN_PROGRAMACION);
                                                            $inicial_c->modify('+1 hours');
                                                            $fecha_final_dia = clone $inicial_c;
                                                            $fecha_final_dia->setTime(17, 0, 0);
                                                            $final_c = clone $inicial_c;
                                                            $final_c->modify('+' . $existe_servicio[0]->DURACION_ESTIMADA . ' hours');
                                                            $fecha_para_bd_inicio4 = $inicial_c->format('Y-m-d H:i:s');
                                                            $fecha_para_bd_final4 = $final_c->format('Y-m-d H:i:s');

                                                            if ($final_c > $fecha_final_dia) {
                                                                $x = false;
                                                            } else {
                                                                $programacion_ing3 = $this->model->get_programacion_ingeniero_hora($id_ingeniero, $fecha_para_bd_inicio4, $fecha_para_bd_final4);
                                                                if (!empty($programacion_ing3)) {
                                                                    $x = false;
                                                                } else {
                                                                    $ID_PEDIDO = $pedido->ID_PEDIDO;
                                                                    $PEDIDO = $pedido->DOCUMENTO;
                                                                    $CLIENTE = $pedido->CLIENTE;
                                                                    $SERVICO = $pedido->REFERENCIA;
                                                                    $CANTIDAD = $pedido->CANTIDAD;
                                                                    $IVA = $pedido->IVA;
                                                                    $VALOR = $pedido->VALOR;
                                                                    $NOTA = $pedido->NOTA;
                                                                    $CODIGO_EQUIPO = $pedido->NOTA_EQUIPO;
                                                                    $ID_INGENIERO = $id_ingeniero;
                                                                    $FECHA_PROGRAMACION = $fecha_para_bd_inicio4;
                                                                    $FECHA_FIN_PROGRAMACION = $fecha_para_bd_final4;
                                                                    $datos_insertar = array(
                                                                        "PEDIDO" => $PEDIDO,
                                                                        "CLIENTE" => $CLIENTE,
                                                                        "SERVICO" => $SERVICO,
                                                                        "CANTIDAD" => $CANTIDAD,
                                                                        "IVA" => $IVA,
                                                                        "VALOR" => $VALOR,
                                                                        "NOTA" => $NOTA,
                                                                        "CODIGO_EQUIPO" => $CODIGO_EQUIPO,
                                                                        "ID_INGENIERO" => $ID_INGENIERO,
                                                                        "FECHA_PROGRAMACION" => $FECHA_PROGRAMACION,
                                                                        "FECHA_FIN_PROGRAMACION" => $FECHA_FIN_PROGRAMACION,
                                                                        "CREADO_POR" => $ID_USUARIO

                                                                    );
                                                                    $id_odt_insertada = $this->model->insertar_odt($datos_insertar);

                                                                    $datos_EDITAR = array(
                                                                        "ESTADO" => 1
                                                                    );
                                                                    $this->model->update_pedido_estado($datos_EDITAR, $ID_PEDIDO);
                                                                    $datos_formulario = array(
                                                                        "ID_ODT" => $id_odt_insertada
                                                                    );
                                                                    $this->model->insertar_formulario_01_06($datos_formulario);
                                                                    $i = 11;
                                                                    $x = false;
                                                                    $contador_insertar++;

                                                                }

                                                            }




                                                        } else {
                                                            $ID_PEDIDO = $pedido->ID_PEDIDO;
                                                            $PEDIDO = $pedido->DOCUMENTO;
                                                            $CLIENTE = $pedido->CLIENTE;
                                                            $SERVICO = $pedido->REFERENCIA;
                                                            $CANTIDAD = $pedido->CANTIDAD;
                                                            $IVA = $pedido->IVA;
                                                            $VALOR = $pedido->VALOR;
                                                            $NOTA = $pedido->NOTA;
                                                            $CODIGO_EQUIPO = $pedido->NOTA_EQUIPO;
                                                            $ID_INGENIERO = $id_ingeniero;
                                                            $FECHA_PROGRAMACION = $fecha_para_bd_inicio3;
                                                            $FECHA_FIN_PROGRAMACION = $fecha_para_bd_final3;
                                                            $datos_insertar = array(
                                                                "PEDIDO" => $PEDIDO,
                                                                "CLIENTE" => $CLIENTE,
                                                                "SERVICO" => $SERVICO,
                                                                "CANTIDAD" => $CANTIDAD,
                                                                "IVA" => $IVA,
                                                                "VALOR" => $VALOR,
                                                                "NOTA" => $NOTA,
                                                                "CODIGO_EQUIPO" => $CODIGO_EQUIPO,
                                                                "ID_INGENIERO" => $ID_INGENIERO,
                                                                "FECHA_PROGRAMACION" => $FECHA_PROGRAMACION,
                                                                "FECHA_FIN_PROGRAMACION" => $FECHA_FIN_PROGRAMACION,
                                                                "CREADO_POR" => $ID_USUARIO

                                                            );
                                                            $id_odt_insertada = $this->model->insertar_odt($datos_insertar);

                                                            $datos_EDITAR = array(
                                                                "ESTADO" => 1
                                                            );
                                                            $this->model->update_pedido_estado($datos_EDITAR, $ID_PEDIDO);
                                                            $datos_formulario = array(
                                                                "ID_ODT" => $id_odt_insertada
                                                            );
                                                            $this->model->insertar_formulario_01_06($datos_formulario);
                                                            $i = 11;
                                                            $x = false;
                                                            $contador_insertar++;

                                                        }

                                                    }


                                                } else {
                                                    $ID_PEDIDO = $pedido->ID_PEDIDO;
                                                    $PEDIDO = $pedido->DOCUMENTO;
                                                    $CLIENTE = $pedido->CLIENTE;
                                                    $SERVICO = $pedido->REFERENCIA;
                                                    $CANTIDAD = $pedido->CANTIDAD;
                                                    $IVA = $pedido->IVA;
                                                    $VALOR = $pedido->VALOR;
                                                    $NOTA = $pedido->NOTA;
                                                    $CODIGO_EQUIPO = $pedido->NOTA_EQUIPO;
                                                    $ID_INGENIERO = $id_ingeniero;
                                                    $FECHA_PROGRAMACION = $fecha_para_bd_inicio2;
                                                    $FECHA_FIN_PROGRAMACION = $fecha_para_bd_final2;
                                                    $datos_insertar = array(
                                                        "PEDIDO" => $PEDIDO,
                                                        "CLIENTE" => $CLIENTE,
                                                        "SERVICO" => $SERVICO,
                                                        "CANTIDAD" => $CANTIDAD,
                                                        "IVA" => $IVA,
                                                        "VALOR" => $VALOR,
                                                        "NOTA" => $NOTA,
                                                        "CODIGO_EQUIPO" => $CODIGO_EQUIPO,
                                                        "ID_INGENIERO" => $ID_INGENIERO,
                                                        "FECHA_PROGRAMACION" => $FECHA_PROGRAMACION,
                                                        "FECHA_FIN_PROGRAMACION" => $FECHA_FIN_PROGRAMACION,
                                                        "CREADO_POR" => $ID_USUARIO

                                                    );
                                                    $id_odt_insertada = $this->model->insertar_odt($datos_insertar);

                                                    $datos_EDITAR = array(
                                                        "ESTADO" => 1
                                                    );
                                                    $this->model->update_pedido_estado($datos_EDITAR, $ID_PEDIDO);
                                                    $datos_formulario = array(
                                                        "ID_ODT" => $id_odt_insertada
                                                    );
                                                    $this->model->insertar_formulario_01_06($datos_formulario);
                                                    $i = 11;
                                                    $x = false;
                                                    $contador_insertar++;



                                                }


                                            }

                                        } else {

                                            $ID_PEDIDO = $pedido->ID_PEDIDO;
                                            $PEDIDO = $pedido->DOCUMENTO;
                                            $CLIENTE = $pedido->CLIENTE;
                                            $SERVICO = $pedido->REFERENCIA;
                                            $CANTIDAD = $pedido->CANTIDAD;
                                            $IVA = $pedido->IVA;
                                            $VALOR = $pedido->VALOR;
                                            $NOTA = $pedido->NOTA;
                                            $CODIGO_EQUIPO = $pedido->NOTA_EQUIPO;
                                            $ID_INGENIERO = $id_ingeniero;
                                            $FECHA_PROGRAMACION = $fecha_para_bd_inicio;
                                            $FECHA_FIN_PROGRAMACION = $fecha_para_bd_final;
                                            $datos_insertar = array(
                                                "PEDIDO" => $PEDIDO,
                                                "CLIENTE" => $CLIENTE,
                                                "SERVICO" => $SERVICO,
                                                "CANTIDAD" => $CANTIDAD,
                                                "IVA" => $IVA,
                                                "VALOR" => $VALOR,
                                                "NOTA" => $NOTA,
                                                "CODIGO_EQUIPO" => $CODIGO_EQUIPO,
                                                "ID_INGENIERO" => $ID_INGENIERO,
                                                "FECHA_PROGRAMACION" => $FECHA_PROGRAMACION,
                                                "FECHA_FIN_PROGRAMACION" => $FECHA_FIN_PROGRAMACION,
                                                "CREADO_POR" => $ID_USUARIO

                                            );
                                            $id_odt_insertada = $this->model->insertar_odt($datos_insertar);

                                            $datos_EDITAR = array(
                                                "ESTADO" => 1
                                            );
                                            $this->model->update_pedido_estado($datos_EDITAR, $ID_PEDIDO);
                                            $datos_formulario = array(
                                                "ID_ODT" => $id_odt_insertada
                                            );
                                            $this->model->insertar_formulario_01_06($datos_formulario);
                                            $i = 11;
                                            $x = false;
                                            $contador_insertar++;
                                        }


                                        $programacion_ing = '';


                                    }




                                }

                            }

                        }







                    }
                }





            }




        }



        $carga_datos_editar = array(
            "PROGRAMADOS" => $contador_insertar,
            "NO PROGRAMADOS" => $contador_error
        );
        return $this->respond(array("code" => 200, "msg" => $carga_datos_editar));
    }

    function get_odt_id()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $USER = $this->model->get_odt_id($ID_ODT);

        return $this->respond($USER);

    }
    function get_odt_equipo()
    {
        $data = json_decode(file_get_contents("php://input"));
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $NIT_CLIENTE = $data->NIT_CLIENTE;
        $USER = $this->model->get_odt_equipo($CODIGO_EQUIPO, $NIT_CLIENTE);

        return $this->respond($USER);

    }
    public function insertar_odt()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_PEDIDO = $data->ID_PEDIDO;
        $PEDIDO = $data->PEDIDO;
        $CLIENTE = $data->CLIENTE;
        $SERVICO = $data->SERVICO;
        $CANTIDAD = $data->CANTIDAD;
        $IVA = $data->IVA;
        $VALOR = $data->VALOR;
        $NOTA = $data->NOTA;
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $ID_INGENIERO = $data->ID_INGENIERO;
        $FECHA_PROGRAMACION = $data->FECHA_PROGRAMACION;
        $FECHA_FIN_PROGRAMACION = $data->FECHA_FIN_PROGRAMACION;
        $datos_insertar = array(
            "PEDIDO" => $PEDIDO,
            "CLIENTE" => $CLIENTE,
            "SERVICO" => $SERVICO,
            "CANTIDAD" => $CANTIDAD,
            "IVA" => $IVA,
            "VALOR" => $VALOR,
            "NOTA" => $NOTA,
            "CODIGO_EQUIPO" => $CODIGO_EQUIPO,
            "ID_INGENIERO" => $ID_INGENIERO,
            "FECHA_PROGRAMACION" => $FECHA_PROGRAMACION,
            "FECHA_FIN_PROGRAMACION" => $FECHA_FIN_PROGRAMACION

        );
        $id_odt_insertada = $this->model->insertar_odt($datos_insertar);

        $datos_EDITAR = array(
            "ESTADO" => 1
        );
        $this->model->update_pedido_estado($datos_EDITAR, $ID_PEDIDO);
        $datos_formulario = array(
            "ID_ODT" => $id_odt_insertada
        );
        $this->model->insertar_formulario_01_06($datos_formulario);

        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function insertar_odt_manual()
    {

        $data = json_decode(file_get_contents("php://input"));

        $PEDIDO = $data->PEDIDO;
        $CLIENTE = $data->CLIENTE;
        $SERVICO = $data->SERVICO;
        $CANTIDAD = $data->CANTIDAD;
        $IVA = $data->IVA;
        $VALOR = $data->VALOR;
        $NOTA = $data->NOTA;
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $ID_INGENIERO = $data->ID_INGENIERO;
        $FECHA_PROGRAMACION = $data->FECHA_PROGRAMACION;
        $FECHA_FIN_PROGRAMACION = $data->FECHA_FIN_PROGRAMACION;
        $SUBCONTRATADO = $data->SUBCONTRATADO;
        $CONTRATO = $data->CONTRATO;
        $NCONTRATO = $data->NCONTRATO;
        $EMERGENCIA = $data->EMERGENCIA;
        
        $datos_insertar = array(
            "PEDIDO" => $PEDIDO,
            "CLIENTE" => $CLIENTE,
            "SERVICO" => $SERVICO,
            "CANTIDAD" => $CANTIDAD,
            "IVA" => $IVA,
            "VALOR" => $VALOR,
            "NOTA" => $NOTA,
            "CODIGO_EQUIPO" => $CODIGO_EQUIPO,
            "ID_INGENIERO" => $ID_INGENIERO,
            "FECHA_PROGRAMACION" => $FECHA_PROGRAMACION,
            "FECHA_FIN_PROGRAMACION" => $FECHA_FIN_PROGRAMACION,
            "SUBCONTRATADO" => $SUBCONTRATADO,
            "CONTRATO" => $CONTRATO,
            "NCONTRATO" => $NCONTRATO,
            "EMERGENCIA" => $EMERGENCIA

        );
        $id_odt_insertada = $this->model->insertar_odt($datos_insertar);


        $datos_formulario = array(
            "ID_ODT" => $id_odt_insertada
        );
        $this->model->insertar_formulario_01_06($datos_formulario);

        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function eliminar_odt()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $BANDERA = $this->model->eliminar_odt($ID_ODT);
        if ($BANDERA) {
            return $this->respond(array("code" => 200, "msg" => "OK"));
        } else {
            return $this->respond(array("code" => 400, "msg" => "OK"));
        }

    }
    public function guardar_imagen_tercero()
    {
        $VALOR = $this->request->getPost('VALOR');
        $ID_ODT = $this->request->getPost('ID_ODT');
        $VALOR = $this->archivo_subir($ID_ODT);
        $datos_insertar = array(
            "INFORME_TERCEROS" => $VALOR
        );
        $this->model->updateODT($datos_insertar, $ID_ODT);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }

    public function guardar_adjunto_externo()
    {
        $VALOR = $this->request->getPost('VALOR');
        $ID_ODT = $this->request->getPost('ID_ODT');
        $ID_FORMULARIO = $this->request->getPost('ID_FORMULARIO');
        $VALOR = $this->archivo_subir_externo($ID_ODT);
        $datos_insertar = array(
            "INFROME_EXTERNO_PDF" => $VALOR,
            "ID_FORMULARIO" => $ID_FORMULARIO,
            "ID_ODT" => $ID_ODT
        );
        $this->model->insertar_formulario_odt($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function archivo_subir($id)
    {
        if ($ADJUNTO = $this->request->getfile('VALOR')) {
            if ($ADJUNTO->isvalid() && !$ADJUNTO->hasMoved()) {
                $newName = $ADJUNTO->getRandomName();
                $ADJUNTO->move(WRITEPATH . 'uploads/informe_terceros/' . $id, $newName);
                return $newName;
            }
        }
    }

    function get_odt_equipo_cliente()
    {
        $data = json_decode(file_get_contents("php://input"));
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $ID_DEPENDENCIA = $data->ID_DEPENDENCIA;
        $NIT_CLIENTE = $this->model->nit_clientebyDependecia($ID_DEPENDENCIA);
        $result = $NIT_CLIENTE[0]->NIT;
        $data = $this->model->get_odt_equipo_cliente($CODIGO_EQUIPO, $result);

        return $this->respond($data);

    }
    public function archivo_subir_externo($id)
    {
        if ($ADJUNTO = $this->request->getfile('VALOR')) {
            if ($ADJUNTO->isvalid() && !$ADJUNTO->hasMoved()) {
                $newName = $ADJUNTO->getRandomName();
                $ADJUNTO->move(WRITEPATH . 'uploads/infrome_externos/' . $id, $newName);
                return $newName;
            }
        }
    }
    function infrome_terceros_pdf($ID_ODT = null, $INFORME_TERCEROS = null)
    {
        // abre el archivo en modo binario
        if (!$ID_ODT) { // $movieId== null
            $ID_ODT = $this->request->getGet('ID_ODT');
        }
        if (!$INFORME_TERCEROS) { // $image== null
            $INFORME_TERCEROS = $this->request->getGet('INFORME_TERCEROS');
        }

        if ($ID_ODT == '' || $INFORME_TERCEROS == '') {

        }
        $name = WRITEPATH . 'uploads/informe_terceros/' . $ID_ODT . '/' . $INFORME_TERCEROS;


        if (!file_exists($name)) {

        }
        $fp = fopen($name, 'rb');
        // envía las cabeceras correctas
        header("Content-type:application/pdf");
        header("Content-Length: " . filesize($name));
        // vuelca la imagen y detiene el script
        fpassthru($fp);
        exit;
    }

    function infrome_externos_pdf($ID_ODT = null, $INFORME_EXTERNO_PDF = null)
    {
        // abre el archivo en modo binario
        if (!$ID_ODT) { // $movieId== null
            $ID_ODT = $this->request->getGet('ID_ODT');
        }
        if (!$INFORME_EXTERNO_PDF) { // $image== null
            $INFORME_EXTERNO_PDF = $this->request->getGet('INFORME_EXTERNO_PDF');
        }

        if ($ID_ODT == '' || $INFORME_EXTERNO_PDF == '') {

        }
        $name = WRITEPATH . 'uploads/infrome_externos/' . $ID_ODT . '/' . $INFORME_EXTERNO_PDF;


        if (!file_exists($name)) {

        }
        $fp = fopen($name, 'rb');
        // envía las cabeceras correctas
        header("Content-type:application/pdf");
        header("Content-Length: " . filesize($name));
        // vuelca la imagen y detiene el script
        fpassthru($fp);
        exit;
    }


    public function update_odt()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $ID_INGENIERO = $data->ID_INGENIERO;
        $FECHA_PROGRAMACION = $data->FECHA_PROGRAMACION;
        $FECHA_FIN_PROGRAMACION = $data->FECHA_FIN_PROGRAMACION;
        $DATOS_EDITAR = array(
            "ID_INGENIERO" => $ID_INGENIERO,
            "FECHA_PROGRAMACION" => $FECHA_PROGRAMACION,
            "FECHA_FIN_PROGRAMACION" => $FECHA_FIN_PROGRAMACION,
            "ESTADO_ODT" => 0

        );
        $this->model->update_odt($ID_ODT, $DATOS_EDITAR);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function listar_repuestos_odt()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $clientes = $this->model->listar_repuestos_odt($ID_ODT);
        return $this->respond($clientes);
    }

    public function update_observaciones_odt()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $OBSERVACIONES = $data->OBSERVACIONES;
        $PERSONA_ENCARGADA = $data->PERSONA_ENCARGADA;
        $datos_EDITAR = array(
            "ID_ODT" => $ID_ODT,
            "OBSERVACIONES" => $OBSERVACIONES,
            "ESTADO_ODT" => 1,
            "PERSONA_ENCARGADA" => $PERSONA_ENCARGADA

        );
        $this->model->update_odt_estado($datos_EDITAR, $ID_ODT);
        $USER = $this->model->get_odt_id_USUARIO($ID_ODT);
        $this->envio_correo_ingeniero($USER[0]->NOMBRES_INGENIERO, $ID_ODT, $USER[0]->RAZON_SOCIAL, $USER[0]->DESCRIPCION_SERVICIO, $USER[0]->CODIGO_EQUIPO, $USER[0]->FECHA_PROGRAMACION, $USER[0]->CORREO);
        $bandera = $this->envio_correo_cliente($USER[0]->NOMBRES_INGENIERO, $ID_ODT, $USER[0]->RAZON_SOCIAL, $USER[0]->DESCRIPCION_SERVICIO, $USER[0]->CODIGO_EQUIPO, $USER[0]->FECHA_PROGRAMACION, $PERSONA_ENCARGADA, $USER[0]->ID_INGENIERO, );
        if ($bandera) {
            return $this->respond(array("code" => 200, "msg" => "OK"));
        } else {
            return $this->respond(array("code" => 200, "msg" => "ERROR AL ENVIO DEL CORREO"));
        }

    }

    function envio_correo_ingeniero($nombres, $id_odt, $cliente, $descripcion_servicio, $EQUIPO, $FECHA, $CORREO)
    {
        $mensaje = '<div class="rps_451c">
        <div id="x_outlook"
            style="padding: 0px; margin: 0px; background-color: rgb(255, 255, 255); font: 15px / 22px Arial, Helvetica, sans-serif, serif, EmojiFont;">
            <table cellpadding="0" cellspacing="0" bgcolor="#f7f7f7" border="0" width="100%" align="center">
                <tbody>
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" bgcolor="#f7f7f7" border="0" width="626" align="center">
                                <tbody>
                                    <tr>
                                        <td height="31" valign="middle" width="300"
                                            style="font:bold 11px Arial; line-height:11px; color:#9c9c9c">Bienvenido a
                                            HEFESTO!</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="100%">
                <tbody>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
                                <tbody>
                                    <tr>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" border="0" width="640" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" height="13" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="140" height="62"><a href="https://quimitronica.com"
                                                                target="_blank" rel="noopener noreferrer"
                                                                data-auth="NotApplicable" class="x_links"
                                                                data-safelink="true" data-linkindex="0"><img
                                                                    data-imagetype="External"
                                                                    src="https://www.quimitronica.com/wp-content/uploads/2021/02/cropped-Quimitro%CC%81nica-Favicon-180x180.png"
                                                                    width="64" height="64" alt="HEFESTO"
                                                                    style="display:block; border:none"></a></td>
                                                        <td width="500">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                                                align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="color:#6b6b6b; color:#1b365d; font:bold 26px/35px arial; padding:10px 5px 10px 0">
                                                                            Notificación Hefesto </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" height="20" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="640"
                                                align="center" style="border-top:2px solid #1b365d">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" height="16" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="320" align="left"
                                                            style="font:16px/18px Arial; color:#383838; text-decoration:none">
                                                            <span
                                                                style="font: 16px / 18px Arial, serif, EmojiFont; color: rgb(56, 56, 56); text-decoration: none;">Estimado:
                                                                ' . $nombres . ' </span>
                                                        </td>
                                                 
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" height="16" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="100%" align="center">
                                <tbody>
                                    <tr>
                                        <td width="10">&nbsp;</td>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="626"
                                                align="center">
                                                <tbody>
                                                    <tr>
                                                        <td align="left"
                                                            style="font:16px/24px Arial; color:#2b2b2b; padding:45px 0 0">
                                                            <p>Tiene una Nueva Orden de trabajo
                                                                <br aria-hidden="true">
                                                                
                                                                <br />
                                                                ORDEN DE TRABAJO : 
                                                                ' . $id_odt . '<br />
                                                                CLIENTE : ' . $cliente . '
                                                                <br />
                                                                DESCRIPCIÓN DEL SERVICIO : ' . $descripcion_servicio . ' <br />
                                                                EQUIPO : ' . $EQUIPO . ' <br />
                                                                FECHA PROGRAMADA : ' . $FECHA . ' <br />
                                                            </p>
    
                                                           
                                                           
                                                            <p>Hefesto</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="10">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" border="0" width="646" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td height="0"
                                                            style="font-size:0; line-height:0; padding-bottom:24px; border-bottom:1px solid #dddddd">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font:11px/16px Arial; color:#999999; padding:23px 0 0 10px">
                                                            <p><strong>Este es un mensaje automatico – por favor no
                                                                    responder.</strong><br aria-hidden="true">Si desea
                                                                responder a este correo electrónico, por favor <a href="#"
                                                                    target="_blank" rel="noopener noreferrer"
                                                                    style="color:#999999; font:11px/15px Arial; text-decoration:underline"
                                                                    data-safelink="true" data-linkindex="5">Contactar a
                                                                    Soporte tecnico@quimitronica.com</a>. </p>
                                                            <p><strong>Hefesto</strong> es un software de
                                                                <strong>QUIMITRONICA SAS.</strong> © 2023<strong>
                                                                    QUIMITRONICA SAS</strong>. Derechos Reservados. </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="0"
                                                            style="font-size:0; line-height:0; padding-bottom:24px; border-bottom:1px solid #dddddd">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center"
                                                            style="font:11px/24px Arial; color:#999999; padding-top:7px">
                                                            Cra. 49b # 93-93, Bogotá - Colombia </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="0"
                                                            style="font-size:0; line-height:0; padding-bottom:15px">&nbsp;
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>';
        $email = \Config\Services::email();
        $email->setFrom('notificaciones@quimitronica.com', 'HEFESTO');
        $email->setTo($CORREO);
        $email->setSubject('HEFESTO NOTIFICACION');
        $email->setMessage($mensaje);
        $email->send();



    }
    function envio_correo_cliente($nombres, $id_odt, $cliente, $descripcion_servicio, $EQUIPO, $FECHA, $CORREO, $ID_INGENIERO)
    {
        $mensaje = '<div class="rps_451c">
        <div id="x_outlook"
            style="padding: 0px; margin: 0px; background-color: rgb(255, 255, 255); font: 15px / 22px Arial, Helvetica, sans-serif, serif, EmojiFont;">
            <table cellpadding="0" cellspacing="0" bgcolor="#f7f7f7" border="0" width="100%" align="center">
                <tbody>
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" bgcolor="#f7f7f7" border="0" width="626" align="center">
                                <tbody>
                                    <tr>
                                        <td height="31" valign="middle" width="300"
                                            style="font:bold 11px Arial; line-height:11px; color:#9c9c9c">Bienvenido a
                                            HEFESTO!</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="100%">
                <tbody>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
                                <tbody>
                                    <tr>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" border="0" width="640" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" height="13" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="140" height="62"><a href="https://quimitronica.com"
                                                                target="_blank" rel="noopener noreferrer"
                                                                data-auth="NotApplicable" class="x_links"
                                                                data-safelink="true" data-linkindex="0"><img
                                                                    data-imagetype="External"
                                                                    src="https://www.quimitronica.com/wp-content/uploads/2021/02/cropped-Quimitro%CC%81nica-Favicon-180x180.png"
                                                                    width="64" height="64" alt="HEFESTO"
                                                                    style="display:block; border:none"></a></td>
                                                        <td width="500">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                                                align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="color:#6b6b6b; color:#1b365d; font:bold 26px/35px arial; padding:10px 5px 10px 0">
                                                                            Programación servicio QUIMITRONICA </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" height="20" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="640"
                                                align="center" style="border-top:2px solid #1b365d">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" height="16" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="320" align="left"
                                                            style="font:16px/18px Arial; color:#383838; text-decoration:none">
                                                            <span
                                                                style="font: 16px / 18px Arial, serif, EmojiFont; color: rgb(56, 56, 56); text-decoration: none;">Estimado Cliente:' . $cliente . ' </span>
                                                        </td>
                                                      
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" height="16" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="100%" align="center">
                                <tbody>
                                    <tr>
                                        <td width="10">&nbsp;</td>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="626"
                                                align="center">
                                                <tbody>
                                                    <tr>
                                                        <td align="left"
                                                            style="font:16px/24px Arial; color:#2b2b2b; padding:45px 0 0">
                                                            <p>Tiene una Nueva Orden de trabajo programada
                                                                <br aria-hidden="true">
                                                                
                                                                <br />
                                                                Fecha  :' . $FECHA . '<br />
                                                                Ingeniero que los visitará : ' . $nombres . ' 
                                                                <br />
                                                                Descripción del servicio : ' . $descripcion_servicio . ' <br />
                                                                Equipo : ' . $EQUIPO . ' <br />
                                                               
                                                            </p>
    
                                                           
                                                           
                                                            <p>Adjunto encontrará planilla de aportes parafiscales.</p>
                                                            <p>Si desea responder a este correo electrónico, por favor contactar a tecnico@quimitronica.com</p>

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="10">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" border="0" width="646" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td height="0"
                                                            style="font-size:0; line-height:0; padding-bottom:24px; border-bottom:1px solid #dddddd">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font:11px/16px Arial; color:#999999; padding:23px 0 0 10px">
                                                            <p><strong>Este es un mensaje automatico – por favor no
                                                            responder.</strong><br aria-hidden="true">Si desea responder a este correo electrónico, por favor contactar a<a href="#"
                                                            target="_blank" rel="noopener noreferrer"
                                                            style="color:#999999; font:11px/15px Arial; text-decoration:underline"
                                                            data-safelink="true" data-linkindex="5">
                                                            tecnico@quimitronica.com</a>. </p>
                                                        <p><strong>Hefesto</strong> es un software de
                                                        <strong>QUIMITRONICA SAS.</strong> © 2023<strong>
                                                            QUIMITRONICA SAS</strong>. Derechos Reservados.
                                                    </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="0"
                                                            style="font-size:0; line-height:0; padding-bottom:24px; border-bottom:1px solid #dddddd">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center"
                                                            style="font:11px/24px Arial; color:#999999; padding-top:7px">
                                                            Cra. 49b # 93-93, Bogotá - Colombia </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="0"
                                                            style="font-size:0; line-height:0; padding-bottom:15px">&nbsp;
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>';

        $USER = $this->model->get_parafiscal($ID_INGENIERO);

        if (!empty($USER)) {
            $attachmentPath = WRITEPATH . 'uploads/ingenieros/parafiscales/' . $ID_INGENIERO . '/' . $USER[0]->ADJUNTO;
            $email = \Config\Services::email();
            $email->setFrom('notificaciones@quimitronica.com', 'QUIMITRONICA');
            $email->setTo($CORREO);
            $email->setSubject('Programación de servicio');
            $email->setMessage($mensaje);
            $email->attach($attachmentPath);
            $email->send();



            return true;

        } else {
            return false;
        }





    }

}
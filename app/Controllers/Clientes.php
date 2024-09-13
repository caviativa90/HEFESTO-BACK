<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;

class Clientes extends ResourceController
{
    protected $request;
    protected $modelName = 'App\Models\ClientesModel';
    protected $format = "json";
    /*-------------------------------clientes------------------------------------------- */
    public function listar_clientes()
    {
        $clientes = $this->model->get_lista_clientes();
        return $this->respond($clientes);
    }
    public function insertar_cliente()
    {

        $data = json_decode(file_get_contents("php://input"));
        $NIT = $data->NIT;
        $RAZON_SOCIAL = $data->RAZON_SOCIAL;
        $ALIAS = $data->ALIAS;
        $datos_insertar = array(
            "NIT" => $NIT,
            "RAZON_SOCIAL" => $RAZON_SOCIAL,
            "ALIAS" => $ALIAS,

        );
        $this->model->insertar_cliente($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function update_cliente()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_CLIENTE = $data->ID_CLIENTE;
        $NIT = $data->NIT;
        $RAZON_SOCIAL = $data->RAZON_SOCIAL;
        $ALIAS = $data->ALIAS;
        $datos_insertar = array(
            "NIT" => $NIT,
            "RAZON_SOCIAL" => $RAZON_SOCIAL,
            "ALIAS" => $ALIAS
        );
        $this->model->update_cliente($datos_insertar, $ID_CLIENTE);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function get_cliente()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $USER = $this->model->get_cliente($ID);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "cliente" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    function get_cliente_nit()
    {
        $data = json_decode(file_get_contents("php://input"));
        $NIT = $data->NIT;
        $CLIENTE = $this->model->get_existe_cliente($NIT);
        $UCLIENTESER = $this->model->get_existe_cliente($NIT);

        // Verificar el resultado y retornar la respuesta adecuada
        if (count($CLIENTE) > 0) {
            return $this->respond(array("codigo" => 200, "cliente" => $CLIENTE));
        } else {
            return $this->respond(array("codigo" => 404, "message" => "Cliente no encontrado"));
        }
    }
    /*-------------------------------clientes------------------------------------------- */
    /*-------------------------------dependencias------------------------------------------- */
    public function listar_dependecias_clientes()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_CLIENTE = $data->ID_CLIENTE;
        $clientes = $this->model->listar_dependecias_clientes($ID_CLIENTE);
        return $this->respond($clientes);
    }
    public function insertar_dependencia_cliente()
    {

        $data = json_decode(file_get_contents("php://input"));
        $SUCURSAL = $data->SUCURSAL;
        $DEPENDENCIA = $data->DEPENDENCIA;
        $ID_CLIENTE = $data->ID_CLIENTE;
        $DIRECCION = $data->DIRECCION;
        $datos_insertar = array(
            "ID_CLIENTE" => $ID_CLIENTE,
            "SUCURSAL" => $SUCURSAL,
            "DEPENDENCIA" => $DEPENDENCIA,
            "DIRECCION" => $DIRECCION

        );
        $this->model->insertar_dependencia_cliente($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function get_dependencia()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_DEPENDENCIA = $data->ID_DEPENDENCIA;
        $USER = $this->model->get_dependencia($ID_DEPENDENCIA);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "cliente" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function update_dependencia()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_DEPENDENCIA = $data->ID_DEPENDENCIA;
        $SUCURSAL = $data->SUCURSAL;
        $DEPENDENCIA = $data->DEPENDENCIA;
        $ID_CLIENTE = $data->ID_CLIENTE;
        $DIRECCION = $data->DIRECCION;
        $CIUDAD = $data->CIUDAD;
       
        $datos_insertar = array(
            "ID_CLIENTE" => $ID_CLIENTE,
            "SUCURSAL" => $SUCURSAL,
            "DEPENDENCIA" => $DEPENDENCIA,
            "DIRECCION" => $DIRECCION,
            "CIUDAD" => $CIUDAD
            

        );
        $this->model->update_dependencia($datos_insertar, $ID_DEPENDENCIA);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    /*-------------------------------dependencias------------------------------------------- */

    /*-------------------------------contactos------------------------------------------- */
    public function listar_contactos_dependecias_clientes()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_DEPENDENCIA = $data->ID_DEPENDENCIA;
        $clientes = $this->model->listar_contactos_dependecias_clientes($ID_DEPENDENCIA);
        return $this->respond($clientes);
    }
    public function insertar_contactos_dependencia_cliente()
    {

        $data = json_decode(file_get_contents("php://input"));
        $NOMBRE = $data->NOMBRE;
        $CARGO = $data->CARGO;
        $TELEFONO = $data->TELEFONO;
        $CORREO = $data->CORREO;
        $ID_DEPENDENCIA = $data->ID_DEPENDENCIA;
        $datos_insertar = array(
            "NOMBRE" => $NOMBRE,
            "CARGO" => $CARGO,
            "TELEFONO" => $TELEFONO,
            "CORREO" => $CORREO,
            "ID_DEPENDENCIA" => $ID_DEPENDENCIA


        );
        $this->model->insertar_contactos_dependencia_cliente($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function get_contacto_dependencia()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_CONTACTO = $data->ID_CONTACTO;
        $USER = $this->model->get_contacto_dependencia($ID_CONTACTO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "cliente" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function update_contacto_dependencia()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_CONTACTO = $data->ID_CONTACTO;
        $NOMBRE = $data->NOMBRE;
        $CARGO = $data->CARGO;
        $TELEFONO = $data->TELEFONO;
        $CORREO = $data->CORREO;

        $datos_insertar = array(
            "NOMBRE" => $NOMBRE,
            "CARGO" => $CARGO,
            "TELEFONO" => $TELEFONO,
            "CORREO" => $CORREO



        );
        $this->model->update_contacto_dependencia($datos_insertar, $ID_CONTACTO);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    /*-------------------------------contactos------------------------------------------- */

    /*-------------------------------ARCHIVOS------------------------------------------- */
    public function cargar_archivo_clientes()
    {

        $contador_insertar = 0;
        $contador_editar = 0;
        $contador_error = 0;
        $data = json_decode(file_get_contents("php://input"), true);
        $myTime = new Time('now');

        $datos_carga_insertar = array(
            "ID_USUARIO" => $data["usuario"],
            "FECHA" => $myTime,
            "TIPO" => "CLIENTES",
            "INSERTADOS" => 0,
            "EDITADOS" => 0,
            "ERRORES" => 0
        );
        $id_carga = $this->model->insertar_carga($datos_carga_insertar);

        foreach ($data["data"] as $fila) {
            $errores_validacion = "";
            $validacion = true;
            $NIT = trim($fila["NIT"]);
            if ($NIT == "") {
                $validacion = false;
                $errores_validacion .= "El número de NIT no es válido. ";
            }
            $RAZON_SOCIAL = trim($fila["RAZON SOCIAL"]);
            if ($RAZON_SOCIAL == "") {
                $validacion = false;
                $errores_validacion .= "El campo RAZON SOCIAL no es válido. ";
            }
            $SUCURSAL = trim($fila["SUCURSAL"]);
            if ($SUCURSAL == "") {
                $validacion = false;
                $errores_validacion .= "El campo SUCURSAL no es válido.";
            }
            $DEPENDENCIA = trim($fila["DEPENDENCIA"]);
            if ($DEPENDENCIA == "") {
                $validacion = false;
                $errores_validacion .= "El campo DEPENDENCIA no es válido.";
            }
            $DIRECCION = trim($fila["DIRECCION"]);
            if ($DIRECCION == "") {
                $validacion = false;
                $errores_validacion .= "El campo DIRECCIÓN no es válido. ";
            }
            $NOMBRE_CONTACTO = trim($fila["NOMBRE DE CONTACTO"]);
            if ($NOMBRE_CONTACTO == "") {
                $validacion = false;
                $errores_validacion .= "El campo NOMBRE DE CONTACTO no es válido. ";
            }
            $CARGO = trim($fila["CARGO"]);
            if ($CARGO == "") {
                $validacion = false;
                $errores_validacion .= "El campo CARGO no es válido. ";
            }
            $TELEFONO = trim($fila["TELEFONO"]);
            if ($TELEFONO == "") {
                $validacion = false;
                $errores_validacion .= "El campo TELEFONO no es válido.";
            }
            $CORREO = trim($fila["CORREO"]);
            if ($CORREO == "") {
                $validacion = false;
                $errores_validacion .= "El campo CORREO no es válido. ";
            }
            $CIUDAD = trim($fila["CIUDAD"]);

            if ($CIUDAD == "") {
                $validacion = false;
                $errores_validacion .= "El campo CIUDAD no es válido.";
            }

            //datos
            $datos_insertar_carga = array(
                "NIT" => $NIT,
                "RAZON_SOCIAL" => $RAZON_SOCIAL,
                "CIUDAD" => $CIUDAD,
                "SUCURSAL" => $SUCURSAL,
                "DEPENDENCIA" => $DEPENDENCIA,
                "DIRECCION" => $DIRECCION,
                "NOMBRE" => $NOMBRE_CONTACTO,
                "CARGO" => $CARGO,
                "TELEFONO" => $TELEFONO,
                "CORREO" => $CORREO

            );

            if ($validacion) {

                $arr_ya_existe = $this->model->get_cliente_dependecia_contacto($NIT, $SUCURSAL, $CIUDAD, $CORREO); //validar este

                if ($arr_ya_existe) {

                    //$contador_editar++;

                } else {
                    $existe_cliente = $this->model->get_existe_cliente($NIT);

                    if (count($existe_cliente) > 0) {
                        $ID_CLIENTE = $existe_cliente[0]->ID_CLIENTE;

                    } else {
                        $datos_insertar_cliente = array(
                            "NIT" => $NIT,
                            "RAZON_SOCIAL" => $RAZON_SOCIAL

                        );
                        $ID_CLIENTE = $this->model->insertar_cliente($datos_insertar_cliente);
                    }
                    $existe_cliente_dependencia = $this->model->get_existe_cliente_dependencia($NIT, $SUCURSAL, $CIUDAD);

                    if (count($existe_cliente_dependencia) > 0) {
                        $ID_DEPENDENCIA = $existe_cliente_dependencia[0]->ID_DEPENDENCIA;

                    } else {
                        $datos_insertar_dependecia = array(
                            "ID_CLIENTE" => $ID_CLIENTE,
                            "CIUDAD" => $CIUDAD,
                            "SUCURSAL" => $SUCURSAL,
                            "DEPENDENCIA" => $DEPENDENCIA,
                            "DIRECCION" => $DIRECCION

                        );
                        $ID_DEPENDENCIA = $this->model->insertar_dependencia_cliente($datos_insertar_dependecia);
                    }

                    $datos_insertar_contacto = array(
                        "NOMBRE" => $NOMBRE_CONTACTO,
                        "CARGO" => $CARGO,
                        "TELEFONO" => $TELEFONO,
                        "CORREO" => $CORREO,
                        "ID_DEPENDENCIA" => $ID_DEPENDENCIA

                    );
                    $this->model->insertar_contactos_dependencia_cliente($datos_insertar_contacto);
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
    function listar_cargas_clientes()
    {
        $arr_cargas = $this->model->consultarTodosCargaClientes();
        return $this->respond($arr_cargas);
    }
    function obtener_detalle_insertados_carga()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_CARGA = $data->ID_CARGA;
        $datos = $this->model->obtener_detalle_insertados_carga($ID_CARGA);
        return $this->respond($datos);
    }
    function obtener_detalle_editados_carga()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_CARGA = $data->ID_CARGA;
        $datos = $this->model->obtener_detalle_editados_carga($ID_CARGA);
        return $this->respond($datos);
    }
    function obtener_detalle_errores_carga()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_CARGA = $data->ID_CARGA;
        $datos = $this->model->obtener_detalle_errores_carga($ID_CARGA);
        return $this->respond($datos);
    }
    /*-------------------------------ARCHIVOS------------------------------------------- */

    /*-------------------------------EQUIPOS------------------------------------------- */

    public function listar_equipos_dependencia()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_DEPENDENCIA = $data->ID_DEPENDENCIA;
        $equipos = $this->model->listar_equipos_dependencia($ID_DEPENDENCIA);
        return $this->respond($equipos);
    }
    public function insertar_equipo_dependencia()
    {

        $data = json_decode(file_get_contents("php://input"));
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $EQUIPO = $data->EQUIPO;
        $MARCA = $data->MARCA;
        $MODELO = $data->MODELO;
        $TIPO_EQUIPO = $data->TIPO_EQUIPO;
        $SERIE = $data->SERIE;
        $ID_DEPENDENCIA = $data->ID_DEPENDENCIA;

        $datos_insertar = array(
            "CODIGO_EQUIPO" => $CODIGO_EQUIPO,
            "EQUIPO" => $EQUIPO,
            "MARCA" => $MARCA,
            "MODELO" => $MODELO,
            "TIPO_EQUIPO" => $TIPO_EQUIPO,
            "SERIE" => $SERIE,
            "ID_DEPENDENCIA" => $ID_DEPENDENCIA

        );
        $this->model->insertar_equipo_dependencia($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function get_equipo_dependencia()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_EQUIPO = $data->ID_EQUIPO;
        $USER = $this->model->get_equipo_dependencia($ID_EQUIPO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    function get_equipo_cliente()
    {
        $data = json_decode(file_get_contents("php://input"));
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $NIT_CLIENTE = $data->NIT_CLIENTE;
        $USER = $this->model->get_equipo_cliente($CODIGO_EQUIPO, $NIT_CLIENTE);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    function get_equipo_cliente_all()
    {
        $data = json_decode(file_get_contents("php://input"));
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $NIT_CLIENTE = $data->NIT_CLIENTE;
        $equipo = $this->model->get_equipo_cliente_all($CODIGO_EQUIPO, $NIT_CLIENTE);
        return $this->respond($equipo);
    }
    function get_programacion_ingeniero_hora()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_INGENIERO = $data->ID_INGENIERO;
        $FECHA_INICIO = $data->FECHA_INICIO;
        $FECHA_FIN = $data->FECHA_FIN;
       
        $USER = $this->model->get_programacion_ingeniero_hora($ID_INGENIERO, $FECHA_INICIO,$FECHA_FIN);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }

    function get_programacion_ingeniero_hora_update()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_INGENIERO = $data->ID_INGENIERO;
        $FECHA_INICIO = $data->FECHA_INICIO;
        $FECHA_FIN = $data->FECHA_FIN;
        $ID_ODT = $data->ID_ODT;
        $USER = $this->model->get_programacion_ingeniero_hora_update($ID_INGENIERO, $FECHA_INICIO,$FECHA_FIN,$ID_ODT);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function update_equipo_dependencia()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_EQUIPO = $data->ID_EQUIPO;
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $EQUIPO = $data->EQUIPO;
        $MARCA = $data->MARCA;
        $MODELO = $data->MODELO;
        $TIPO_EQUIPO = $data->TIPO_EQUIPO;
        $SERIE = $data->SERIE;
        $ID_DEPENDENCIA = $data->ID_DEPENDENCIA;

        $datos_insertar = array(
            "CODIGO_EQUIPO" => $CODIGO_EQUIPO,
            "EQUIPO" => $EQUIPO,
            "MARCA" => $MARCA,
            "MODELO" => $MODELO,
            "TIPO_EQUIPO" => $TIPO_EQUIPO,
            "SERIE" => $SERIE,
            "ID_DEPENDENCIA" => $ID_DEPENDENCIA

        );
        $this->model->update_equipo_dependencia($datos_insertar, $ID_EQUIPO);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    /*-------------------------------EQUIPOS------------------------------------------- */
    public function listar_equipos_cliente()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_CLIENTE = $data->ID_CLIENTE;
        $equipos = $this->model->listar_equipos_cliente($ID_CLIENTE);
        return $this->respond($equipos);
    }
    public function listar_equipos_cliente_nit()
    {
        $data = json_decode(file_get_contents("php://input"));
        $NIT = $data->NIT;
        $equipos = $this->model->listar_equipos_cliente_nit($NIT);
        return $this->respond($equipos);
    }
}
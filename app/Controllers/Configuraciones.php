<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Configuraciones extends ResourceController
{

    protected $request;
    protected $modelName = 'App\Models\ConfiguracionesModel';
    protected $format = "json";

    /*-------------------------------EQUIPOS MATERIALES------------------------------------------- */
    public function listar_equipos_materiales()
    {
        $clientes = $this->model->listar_equipos_materiales();
        return $this->respond($clientes);
    }
    public function insertar_equipos_materiales()
    {

        $data = json_decode(file_get_contents("php://input"));
        $CODIGO = $data->CODIGO;
        $NOMBRE = $data->NOMBRE;
        $CANTIDAD = $data->CANTIDAD;

        $datos_insertar = array(
            "CODIGO" => $CODIGO,
            "NOMBRE" => $NOMBRE,
            "CANTIDAD" => $CANTIDAD

        );
        $this->model->insertar_equipos_materiales($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function get_equipos_materiales()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_EQUIPOS_MATERIALES = $data->ID_EQUIPOS_MATERIALES;
        $USER = $this->model->get_equipos_materiales($ID_EQUIPOS_MATERIALES);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function update_equipos_materiales()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_EQUIPOS_MATERIALES = $data->ID_EQUIPOS_MATERIALES;
        $CODIGO = $data->CODIGO;
        $NOMBRE = $data->NOMBRE;
        $CANTIDAD = $data->CANTIDAD;

        $datos_insertar = array(
            "CODIGO" => $CODIGO,
            "NOMBRE" => $NOMBRE,
            "CANTIDAD" => $CANTIDAD

        );
        $this->model->update_equipos_materiales($datos_insertar, $ID_EQUIPOS_MATERIALES);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    /*-------------------------------EQUIPOS MATERIALES------------------------------------------- */
    /*-------------------------------REPUESTOS------------------------------------------- */

    public function listar_repuestos()
    {
        $clientes = $this->model->listar_repuestos();
        return $this->respond($clientes);
    }
    public function insertar_repuestos()
    {

        $data = json_decode(file_get_contents("php://input"));
        $CODIGO = $data->CODIGO;
        $DESCRIPCION = $data->DESCRIPCION;
        $CANTIDAD = $data->CANTIDAD;
        $UNIDAD = $data->UNIDAD;

        $datos_insertar = array(
            "CODIGO" => $CODIGO,
            "DESCRIPCION" => $DESCRIPCION,
            "CANTIDAD" => $CANTIDAD,
            "UNIDAD" => $UNIDAD

        );
        $this->model->insertar_repuestos($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function get_repuestos()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_REPUESTO = $data->ID_REPUESTO;
        $USER = $this->model->get_repuestos($ID_REPUESTO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function update_repuestos()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_REPUESTO = $data->ID_REPUESTO;
        $CODIGO = $data->CODIGO;
        $DESCRIPCION = $data->DESCRIPCION;
        $CANTIDAD = $data->CANTIDAD;
        $UNIDAD = $data->UNIDAD;

        $datos_insertar = array(
            "CODIGO" => $CODIGO,
            "DESCRIPCION" => $DESCRIPCION,
            "CANTIDAD" => $CANTIDAD,
            "UNIDAD" => $UNIDAD

        );
        $this->model->update_repuestos($datos_insertar, $ID_REPUESTO);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    /*-------------------------------REPUESTOS------------------------------------------- */

    /*-------------------------------SERVICIOS------------------------------------------- */

    public function listar_servicios()
    {
        $clientes = $this->model->listar_servicios();
        return $this->respond($clientes);
    }
    public function insertar_servicios()
    {

        $data = json_decode(file_get_contents("php://input"));
        $CODIGO = $data->CODIGO;
        $DESCRIPCION = $data->DESCRIPCION;
        $SUBCONTRATADO = $data->SUBCONTRATADO;
        $NIVEL_INGENIERO = $data->NIVEL_INGENIERO;
        $DURACION_ESTIMADA = $data->DURACION_ESTIMADA;
        $PRECIO = $data->PRECIO;
        $TIPO_SERVICIO = $data->TIPO_SERVICIO;

        $datos_insertar = array(
            "CODIGO" => $CODIGO,
            "DESCRIPCION" => $DESCRIPCION,
            "SUBCONTRATADO" => $SUBCONTRATADO,
            "NIVEL_INGENIERO" => $NIVEL_INGENIERO,
            "DURACION_ESTIMADA" => $DURACION_ESTIMADA,
            "PRECIO" => $PRECIO,
            "TIPO_SERVICIO" => $TIPO_SERVICIO

        );
        $this->model->insertar_servicios($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function get_servicios()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_SERVICIO = $data->ID_SERVICIO;
        $USER = $this->model->get_servicios($ID_SERVICIO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    function get_servicio_codigo()
    {
        $data = json_decode(file_get_contents("php://input"));
        $CODIGO = $data->CODIGO;
        $USER = $this->model->get_servicio_codigo($CODIGO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function update_servicios()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_SERVICIO = $data->ID_SERVICIO;
        $CODIGO = $data->CODIGO;
        $DESCRIPCION = $data->DESCRIPCION;
        $SUBCONTRATADO = $data->SUBCONTRATADO;
        $NIVEL_INGENIERO = $data->NIVEL_INGENIERO;
        $DURACION_ESTIMADA = $data->DURACION_ESTIMADA;
        $PRECIO = $data->PRECIO;
        $TIPO_SERVICIO = $data->TIPO_SERVICIO;


        $datos_insertar = array(
            "CODIGO" => $CODIGO,
            "DESCRIPCION" => $DESCRIPCION,
            "SUBCONTRATADO" => $SUBCONTRATADO,
            "NIVEL_INGENIERO" => $NIVEL_INGENIERO,
            "DURACION_ESTIMADA" => $DURACION_ESTIMADA,
            "PRECIO" => $PRECIO,
            "TIPO_SERVICIO" => $TIPO_SERVICIO

        );
        $this->model->update_servicios($datos_insertar, $ID_SERVICIO);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    /*-------------------------------SERVICIOS------------------------------------------- */

    /*-------------------------------FORMULARIOS------------------------------------------- */

    public function listar_formularios()
    {
        $clientes = $this->model->listar_formularios();
        return $this->respond($clientes);
    }
    public function insertar_formularios()
    {

        $data = json_decode(file_get_contents("php://input"));
        $DESCRIPCION = $data->DESCRIPCION;
        $datos_insertar = array(

            "DESCRIPCION" => $DESCRIPCION,


        );
        $this->model->insertar_formularios($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function get_formularios()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_FORMULARIO = $data->ID_FORMULARIO;
        $USER = $this->model->get_formularios($ID_FORMULARIO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }

    function get_formulario_servicio_nombre()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_FORMULARIO = $data->ID_FORMULARIO;
        $USER = $this->model->get_formularios($ID_FORMULARIO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function update_formularios()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_FORMULARIO = $data->ID_FORMULARIO;
        $DESCRIPCION = $data->DESCRIPCION;
        $datos_insertar = array(
            "DESCRIPCION" => $DESCRIPCION,
        );
        $this->model->update_formularios($datos_insertar, $ID_FORMULARIO);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    /*-------------------------------FORMULARIOS------------------------------------------- */
    /*-------------------------------ASIGNACION MATERIALES------------------------------------------- */

    public function listar_materiales_equipos_servicios()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_SERVICIO = $data->ID_SERVICIO;
        $clientes = $this->model->listar_materiales_equipos_servicios($ID_SERVICIO);
        return $this->respond($clientes);
    }
    public function insertar_materiales_equipos_servicios()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_SERVICIO = $data->ID_SERVICIO;
        $ID_EQUIPOS_MATERIALES = $data->ID_EQUIPOS_MATERIALES;
        $datos_insertar = array(

            "ID_SERVICIO" => $ID_SERVICIO,
            "ID_EQUIPOS_MATERIALES" => $ID_EQUIPOS_MATERIALES

        );
        $this->model->insertar_materiales_equipos_servicios($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function delete_materiales_equipos_servicios()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $this->model->delete_materiales_equipos_servicios($ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }

    /*-------------------------------ASIGNACION MATERIALES------------------------------------------- */
    /*-------------------------------ASIGNACION REPUESTOS------------------------------------------- */

    public function listar_repuestos_servicio()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_SERVICIO = $data->ID_SERVICIO;
        $clientes = $this->model->listar_repuestos_servicio($ID_SERVICIO);
        return $this->respond($clientes);
    }
    public function insertar_repuestos_servicio()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_SERVICIO = $data->ID_SERVICIO;
        $ID_REPUESTO = $data->ID_REPUESTO;
        $datos_insertar = array(

            "ID_SERVICIO" => $ID_SERVICIO,
            "ID_REPUESTO " => $ID_REPUESTO

        );
        $this->model->insertar__repuestos_servicio($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function insertar_repuesto_servicio_odt()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $ID_REPUESTOS = $data->ID_REPUESTOS;

        $datos_insertar = array(

            "ID_ODT" => $ID_ODT,
            "ID_REPUESTO " => $ID_REPUESTOS

        );
        $this->model->insertar_repuestos_servicio_od($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function delete_repuestos_odt()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $this->model->delete_repuestos_odt($ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function delete_repuestos_servicio()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $this->model->delete__repuestos_servicio($ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }

    /*-------------------------------ASIGNACION REPUESTOS------------------------------------------- */

    /*-------------------------------ASIGNACION FORMULARIOS------------------------------------------- */

    public function listar_formularios_servicio_archivo()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_SERVICIO = $data->ID_SERVICIO;
        $ID_ODT = $data->ID_ODT;
        $array_enviar = array();
        $formularios = $this->model->listar_formularios_servicio($ID_SERVICIO);
        foreach ($formularios as &$formulario) { // Agrega el & para usar una referencia

            $nombre = $this->model->get_formularios_servicio_odt($formulario->ID_FORMULARIO, $ID_ODT);
            $formulario->INFORME_EXTERNO_PDF = $nombre;
            array_push($array_enviar, $formulario);
        }
        return $this->respond($array_enviar);
    }

    public function listar_formularios_servicio()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_SERVICIO = $data->ID_SERVICIO;
        $clientes = $this->model->listar_formularios_servicio_archivo($ID_SERVICIO);

        return $this->respond($clientes);
    }
    public function insertar_formularios_servicio()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_SERVICIO = $data->ID_SERVICIO;
        $ID_FORMULARIO = $data->ID_FORMULARIO;
        $datos_insertar = array(

            "ID_SERVICIO" => $ID_SERVICIO,
            "ID_FORMULARIO " => $ID_FORMULARIO

        );
        $this->model->insertar_formularios_servicio($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function delete_formularios_servicio()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $this->model->delete_formularios_servicio($ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }

    /*-------------------------------ASIGNACION FORMULARIOS------------------------------------------- */
    /*-------------------------------MODULOS-EQUIPOS------------------------------------------- */

    public function listar_modulos_equipo()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_EQUIPO = $data->ID_EQUIPO;
        $clientes = $this->model->listar_modulos_equipo($ID_EQUIPO);
        return $this->respond($clientes);
    }
    public function insertar_modulos_equipo()
    {

        $data = json_decode(file_get_contents("php://input"));
        $DESCRIPCION_MODULO_EQUIPO = $data->DESCRIPCION_MODULO_EQUIPO;
        $MARCA_MODULO_EQUIPO = $data->MARCA_MODULO_EQUIPO;
        $MODELO_MODULO_EQUIPO = $data->MODELO_MODULO_EQUIPO;
        $SERIE_MODULO_EQUIPO = $data->SERIE_MODULO_EQUIPO;
        $ID_EQUIPO = $data->ID_EQUIPO;


        $datos_insertar = array(
            "DESCRIPCION_MODULO_EQUIPO" => $DESCRIPCION_MODULO_EQUIPO,
            "MARCA_MODULO_EQUIPO" => $MARCA_MODULO_EQUIPO,
            "MODELO_MODULO_EQUIPO" => $MODELO_MODULO_EQUIPO,
            "SERIE_MODULO_EQUIPO" => $SERIE_MODULO_EQUIPO,
            "ID_EQUIPO" => $ID_EQUIPO


        );
        $this->model->insertar_modulos_equipo($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    function get_modulos_equipo()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_MODULO_EQUIPO = $data->ID_MODULO_EQUIPO;
        $USER = $this->model->get_modulos_equipo($ID_MODULO_EQUIPO);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function update_modulos_equipo()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_MODULO_EQUIPO = $data->ID_MODULO_EQUIPO;
        $DESCRIPCION_MODULO_EQUIPO = $data->DESCRIPCION_MODULO_EQUIPO;
        $MARCA_MODULO_EQUIPO = $data->MARCA_MODULO_EQUIPO;
        $MODELO_MODULO_EQUIPO = $data->MODELO_MODULO_EQUIPO;
        $SERIE_MODULO_EQUIPO = $data->SERIE_MODULO_EQUIPO;
        $ID_EQUIPO = $data->ID_EQUIPO;


        $datos_insertar = array(
            "DESCRIPCION_MODULO_EQUIPO" => $DESCRIPCION_MODULO_EQUIPO,
            "MARCA_MODULO_EQUIPO" => $MARCA_MODULO_EQUIPO,
            "MODELO_MODULO_EQUIPO" => $MODELO_MODULO_EQUIPO,
            "SERIE_MODULO_EQUIPO" => $SERIE_MODULO_EQUIPO,
            "ID_EQUIPO" => $ID_EQUIPO


        );
        $this->model->update_modulos_equipo($datos_insertar, $ID_MODULO_EQUIPO);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    /*-------------------------------MODULOS-EQUIPOS------------------------------------------- */
}
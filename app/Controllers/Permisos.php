<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;

class Permisos extends ResourceController
{
    protected $request;
    protected $modelName = 'App\Models\PermisosModel';
    protected $format = "json";

    public function listar_Perfiles()
    {
        $recursos = $this->model->listar_Perfiles();
        return $this->respond($recursos);
    }
    public function modulos_perfil()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_PERFIL = $data->ID_PERFIL;
        $recursos = $this->model->modulos_perfil($ID_PERFIL);
        return $this->respond($recursos);
    }

    public function modulos_perfil_asignar()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_PERFIL = $data->ID_PERFIL;
        $recursos = $this->model->modulos_perfil_asignar($ID_PERFIL);
        return $this->respond($recursos);
    }

    public function modulos_no_perfil()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_PERFIL = $data->ID_PERFIL;
        $recursos = $this->model->modulos_no_perfil($ID_PERFIL);
        return $this->respond($recursos);
    }

    public function delete_modulo()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_PERFIL = $data->ID_PERFIL;
        $ID_SERVICIO = $data->ID_SERVICIO;
        $recursos = $this->model->delete_modulo($ID_PERFIL, $ID_SERVICIO);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function insertar_modulo()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_PERFIL = $data->ID_PERFIL;
        $ID_SERVICIO = $data->ID_SERVICIO;
        $datos_insertar = array(
            "ID_PERFIL" => $ID_PERFIL,
            "ID_SERVICIO" => $ID_SERVICIO,

        );
        $this->model->insertar_modulo($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function editar_permiso()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $ACCION = $data->ACCION;
        $VALOR = $data->VALOR;
        switch ($ACCION) {
            case 'CREAR':
                if ($VALOR == 1) {
                    $data = array(
                        'CREAR' => "1",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                } else {
                    $data = array(
                        'CREAR' => "0",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                }
            case 'ELIMINAR':
                if ($VALOR == 1) {
                    $data = array(
                        'ELIMINAR' => "1",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                } else {
                    $data = array(
                        'ELIMINAR' => "0",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                }
            case 'EDITAR':
                if ($VALOR == 1) {
                    $data = array(
                        'EDITAR' => "1",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                } else {
                    $data = array(
                        'EDITAR' => "0",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                }
            case 'VISTA':
                if ($VALOR == 1) {
                    $data = array(
                        'VISTA' => "1",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                } else {
                    $data = array(
                        'VISTA' => "0",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                }
            case 'CONFIGURAR':
                if ($VALOR == 1) {
                    $data = array(
                        'CONFIGURAR' => "1",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                } else {
                    $data = array(
                        'CONFIGURAR' => "0",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                }
            case 'INFORMES':
                if ($VALOR == 1) {
                    $data = array(
                        'INFORMES' => "1",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                } else {
                    $data = array(
                        'INFORMES' => "0",
                    );
                    $this->model->update_permisos($data, $ID);
                    return $this->respond(array("code" => 200, "msg" => "OK"));
                }
            default:
                return $this->respond(array("code" => 400, "msg" => "ERROR"));
        }


    }

}
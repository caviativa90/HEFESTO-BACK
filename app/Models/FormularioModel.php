<?php

namespace App\Models;

use CodeIgniter\Model;



class FormularioModel extends Model
{

    function update_FM_DP_ST_01_06($data, $id)
    {
        $db = \Config\Database::connect();
        $db->table('fm-01-06')->update($data, ['ID_ODT' => $id]);
    }

    function update_odt_nombre_formulario($data, $id)
    {
        $db = \Config\Database::connect();
        $db->table('odt')->update($data, ['ID_ODT' => $id]);
    }
    function update_FM_DP_ST_01_12($data, $id)
    {
        $db = \Config\Database::connect();
        $db->table('fm-01-12')->update($data, ['ID_ODT' => $id]);
    }
    function get_01_06($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('fm-01-06');
        $builder->select('*');
        $where = "fm-01-06.ID_ODT ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function update_repuestos_odt($data, $ID_ODT, $ID_REPUESTO)
    {
        $db = \Config\Database::connect();

        $db->table('repuestos_odt')
            ->where(['ID_ODT' => $ID_ODT, 'ID_REPUESTO' => $ID_REPUESTO])
            ->update($data);
    }



    function get_01_12($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('fm-01-12');
        $builder->select('*');
        $where = "fm-01-12.ID_ODT ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_04_01($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('fm-in-st-04-01');
        $builder->select('*');
        $where = "fm-in-st-04-01.ID_ODT ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_repuestos_proximos($data)
    {
        $db = \Config\Database::connect();
        $db->table('repuestos_odt_proximos')->insert($data);
        return $db->insertID();
    }
    function update_repuestos_proximos($data, $ID_ODT, $ID_REPUESTO)
    {
        $db = \Config\Database::connect();

        $db->table('repuestos_odt_proximos')
            ->where(['ID_ODT' => $ID_ODT, 'ID_REPUESTO' => $ID_REPUESTO])
            ->update($data);
    }
    function get_repuestos_proximos($ID_ODT, $ID_REPUESTO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repuestos_odt_proximos');
        $builder->select('*');
        $where = "repuestos_odt_proximos.ID_ODT ='$ID_ODT' AND repuestos_odt_proximos.ID_REPUESTO ='$ID_REPUESTO'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function listar_repuestos_proximos($ID_ODT)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repuestos_odt_proximos');
        $builder->select('repuestos_odt_proximos.*,repuesto.CODIGO AS CODIGO_REPUESTO, repuesto.DESCRIPCION AS DESCRIPCION_REPUESTO, repuesto.CANTIDAD  AS CANTIDAD_REPUESTO, repuesto.UNIDAD AS UNIDAD_REPUESTO');
        $builder->join('repuesto', 'repuesto.ID_REPUESTO = repuestos_odt_proximos.ID_REPUESTO  ');
        $where = "repuestos_odt_proximos.ID_ODT ='$ID_ODT'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function listar_repuestos($ID_ODT)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repuestos_odt');
        $builder->select('repuestos_odt.*,repuesto.CODIGO AS CODIGO_REPUESTO, repuesto.DESCRIPCION AS DESCRIPCION_REPUESTO, repuesto.CANTIDAD  AS CANTIDAD_REPUESTO, repuesto.UNIDAD AS UNIDAD_REPUESTO');
        $builder->join('repuesto', 'repuesto.ID_REPUESTO = repuestos_odt.ID_REPUESTO  ');
        $where = "repuestos_odt.ID_ODT ='$ID_ODT'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function delete_repuesto_proximo($ID_ODT, $ID_REPUESTO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repuestos_odt_proximos');
        $builder->where('ID_ODT ', $ID_ODT);
        $builder->where('ID_REPUESTO ', $ID_REPUESTO);
        $builder->delete();
    }

    function insertar_formulario_01_12($data)
    {
        $db = \Config\Database::connect();
        $db->table('fm-01-12')->insert($data);
        return $db->insertID();
    }
    function insertar_formulario_04_01($data)
    {
        $db = \Config\Database::connect();
        $db->table('fm-in-st-04-01')->insert($data);
        return $db->insertID();
    }
    function get_formulario__01_06($ID_FORMULARIO, $ID_SERVICIO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('formulario_servicio');
        $builder->select('*');
        $where = "formulario_servicio.ID_FORMULARIO ='$ID_FORMULARIO' AND  formulario_servicio.ID_SERVICIO ='$ID_SERVICIO'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_odt_id($ID_ODT)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('odt.*,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE,servicios.ID_SERVICIO ,cliente.RAZON_SOCIAL, servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA,servicios.TIPO_SERVICIO');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $where = "odt.ID_ODT  ='$ID_ODT '";
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();


    }
    function update_odt_estado($data, $ID_ODT)
    {
        $db = \Config\Database::connect();

        $db->table('odt')->update($data, ['ID_ODT' => $ID_ODT]);
    }
    function get_equipo_cliente_all($CODIGO_EQUIPO, $NIT_CLIENTE)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipo');
        $builder->select('dependecias.*, cliente.*,contacto_dependencias.*');
        $builder->join('dependecias', 'dependecias.ID_DEPENDENCIA   = equipo.ID_DEPENDENCIA ');
        $builder->join('cliente', 'cliente.ID_CLIENTE    = dependecias.ID_CLIENTE ');
        $builder->join('contacto_dependencias', 'contacto_dependencias.ID_DEPENDENCIA  = dependecias.ID_DEPENDENCIA  ');
        $where = "equipo.ID_EQUIPO   ='$CODIGO_EQUIPO ' AND cliente.NIT = '$NIT_CLIENTE' ";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

    function get_ingeniero($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ingeniero');
        $builder->select('ingeniero.ALIAS,ingeniero.ID,ingeniero.NIVEL,ingeniero.COSTO_MANO, usuario.ID AS ID_USUARIO,usuario.USUARIO ,usuario.NOMBRES,usuario.ID_PERFIL,usuario.ACTIVO,usuario.IDENTIFICACION');
        $builder->join('usuario', 'usuario.ID = ingeniero.ID_USUARIO')->groupBy('usuario.ID');
        $where = "ingeniero.ID='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

    function get_equipo_cliente($CODIGO_EQUIPO, $NIT_CLIENTE)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipo');
        $builder->select('equipo.*');
        $builder->join('dependecias', 'dependecias.ID_DEPENDENCIA   = equipo.ID_DEPENDENCIA ');
        $builder->join('cliente', 'cliente.ID_CLIENTE    = dependecias.ID_CLIENTE ');
        $where = "equipo.ID_EQUIPO   ='$CODIGO_EQUIPO ' AND cliente.NIT = '$NIT_CLIENTE' ";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

}

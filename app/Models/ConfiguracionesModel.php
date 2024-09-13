<?php

namespace App\Models;

use CodeIgniter\Model;



class ConfiguracionesModel extends Model
{

    /*-------------------------------EQUIPOS MATERIALES------------------------------------------- */
    function listar_equipos_materiales()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipos_materiales');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_equipos_materiales($data)
    {
        $db = \Config\Database::connect();
        $db->table('equipos_materiales')->insert($data);
    }
    function get_equipos_materiales($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipos_materiales');
        $builder->select('*');
        $where = "equipos_materiales.ID_EQUIPOS_MATERIALES ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

    function get_equipos_materiales_($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipos_materiales');
        $builder->select('*');
        $where = "equipos_materiales.ID_EQUIPOS_MATERIALES ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function update_equipos_materiales($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('equipos_materiales')->update($data, ['ID_EQUIPOS_MATERIALES ' => $id]);
    }
    /*-------------------------------EQUIPOS MATERIALES------------------------------------------- */



    /*-------------------------------REPUESTOS------------------------------------------- */
    function listar_repuestos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repuesto');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_repuestos($data)
    {
        $db = \Config\Database::connect();
        $db->table('repuesto')->insert($data);
    }
    function get_repuestos($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repuesto');
        $builder->select('*');
        $where = "repuesto.ID_REPUESTO ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function update_repuestos($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('repuesto')->update($data, ['ID_REPUESTO ' => $id]);
    }
    /*-------------------------------REPUESTOS------------------------------------------- */

    /*-------------------------------SERVICIOS------------------------------------------- */
    function listar_servicios()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('servicios');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_servicios($data)
    {
        $db = \Config\Database::connect();
        $db->table('servicios')->insert($data);
    }
    function get_servicios($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('servicios');
        $builder->select('*');
        $where = "servicios.ID_SERVICIO ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_servicio_codigo($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('servicios');
        $builder->select('*');
        $where = "servicios.CODIGO ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function update_servicios($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('servicios')->update($data, ['ID_SERVICIO ' => $id]);
    }
    /*-------------------------------SERVICIOS------------------------------------------- */
    /*-------------------------------FORMULARIOS------------------------------------------- */
    function listar_formularios()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('formulario');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_formularios($data)
    {
        $db = \Config\Database::connect();
        $db->table('formulario')->insert($data);
    }
    function get_formularios($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('formulario');
        $builder->select('*');
        $where = "formulario.ID_FORMULARIO  ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function update_formularios($data, $id)
    {
        $db = \Config\Database::connect();
        $db->table('formulario')->update($data, ['ID_FORMULARIO  ' => $id]);
    }
    /*-------------------------------FORMULARIOS------------------------------------------- */
    /*-------------------------------ASIGNACION MATERIALES------------------------------------------- */
    function listar_materiales_equipos_servicios($ID_SERVICIO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipos_materiales_servicio');
        $builder->select('equipos_materiales_servicio.*,servicios.CODIGO AS CODIGO_SERVICIO, servicios.DESCRIPCION AS DESCRIPCION_SERVICIO,servicios.SUBCONTRATADO AS SUBCONTRATADO_SERVICIO, servicios.NIVEL_INGENIERO AS NIVEL_INGENIERO_SERVICIO,servicios.DURACION_ESTIMADA AS DURACION_ESTAMADA_SERVICIO, servicios.PRECIO AS PRECIO_SERVICIO ,equipos_materiales.CODIGO AS CODIGO_EQUIPOS_MATERIAL, equipos_materiales.NOMBRE AS NOMBRE_EQUIPO_MATERIALES, equipos_materiales.CANTIDAD  AS CANTIDAD_EQUIPO_MATERIALES');
        $builder->join('servicios', 'servicios.ID_SERVICIO = equipos_materiales_servicio.ID_SERVICIO');
        $builder->join('equipos_materiales', 'equipos_materiales.ID_EQUIPOS_MATERIALES  = equipos_materiales_servicio.ID_EQUIPOS_MATERIALES ');
        $where = "equipos_materiales_servicio.ID_SERVICIO   ='$ID_SERVICIO'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_materiales_equipos_servicios($data)
    {
        $db = \Config\Database::connect();
        $db->table('equipos_materiales_servicio')->insert($data);
    }


    function delete_materiales_equipos_servicios($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipos_materiales_servicio');
        $builder->where('ID', $id);
        $builder->delete();
    }
    /*-------------------------------ASIGNACION MATERIALES------------------------------------------- */
    /*-------------------------------ASIGNACION REPUESTOS------------------------------------------- */
    function listar_repuestos_servicio($ID_SERVICIO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repuestos_servicios');
        $builder->select('repuestos_servicios.*,servicios.CODIGO AS CODIGO_SERVICIO, servicios.DESCRIPCION AS DESCRIPCION_SERVICIO,servicios.SUBCONTRATADO AS SUBCONTRATADO_SERVICIO, servicios.NIVEL_INGENIERO AS NIVEL_INGENIERO_SERVICIO,servicios.DURACION_ESTIMADA AS DURACION_ESTAMADA_SERVICIO, servicios.PRECIO AS PRECIO_SERVICIO ,repuesto.CODIGO AS CODIGO_REPUESTO, repuesto.DESCRIPCION AS DESCRIPCION_REPUESTO, repuesto.CANTIDAD  AS CANTIDAD_REPUESTO, repuesto.UNIDAD AS UNIDAD_REPUESTO');
        $builder->join('servicios', 'servicios.ID_SERVICIO = repuestos_servicios.ID_SERVICIO');
        $builder->join('repuesto', 'repuestos_servicios.ID_REPUESTO   = repuesto.ID_REPUESTO  ');
        $where = "repuestos_servicios.ID_SERVICIO   ='$ID_SERVICIO'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar__repuestos_servicio($data)
    {
        $db = \Config\Database::connect();
        $db->table('repuestos_servicios')->insert($data);
    }
    function insertar_repuestos_servicio_od($data)
    {
        $db = \Config\Database::connect();
        $db->table('repuestos_odt')->insert($data);
    }
    function delete_repuestos_odt($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repuestos_odt');
        $builder->where('ID', $id);
        $builder->delete();
    }

    function delete__repuestos_servicio($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('repuestos_servicios');
        $builder->where('ID', $id);
        $builder->delete();
    }
    /*-------------------------------ASIGNACION REPUESTOS------------------------------------------- */

    /*-------------------------------ASIGNACION REPUESTOS------------------------------------------- */
    function listar_formularios_servicio($ID_SERVICIO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('formulario_servicio');
        $builder->select('formulario_servicio.*,servicios.CODIGO AS CODIGO_SERVICIO, servicios.DESCRIPCION AS DESCRIPCION_SERVICIO,servicios.SUBCONTRATADO AS SUBCONTRATADO_SERVICIO, servicios.NIVEL_INGENIERO AS NIVEL_INGENIERO_SERVICIO,servicios.DURACION_ESTIMADA AS DURACION_ESTAMADA_SERVICIO, servicios.PRECIO AS PRECIO_SERVICIO ,formulario.DESCRIPCION AS DESCRIPCION_FORMULARIO');
        $builder->join('servicios', 'servicios.ID_SERVICIO = formulario_servicio.ID_SERVICIO');
        $builder->join('formulario', 'formulario.ID_FORMULARIO    = formulario_servicio.ID_FORMULARIO  ');
        $where = "formulario_servicio.ID_SERVICIO   ='$ID_SERVICIO'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

    function get_formularios_servicio_odt($ID_FORMULARIO, $ID_ODT)
    {
        $db = \Config\Database::connect();
        $query = $this->db->query("SELECT INFROME_EXTERNO_PDF FROM formularios_odt WHERE ID_FORMULARIO ='$ID_FORMULARIO' AND ID_ODT ='$ID_ODT' ORDER BY ID DESC LIMIT 1");
        $resultado = $query->getResultArray();
        if (!empty($resultado)) {
            // Accediendo al nombre de la primera fila
            $nombre = $resultado[0]['INFROME_EXTERNO_PDF'];
        
            return $nombre;
        } else {
            // No se encontraron resultados
            return "NR";
        }
       
    }


    function listar_formularios_servicio_archivo($ID_SERVICIO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('formulario_servicio');
        $builder->select('formulario_servicio.*,servicios.CODIGO AS CODIGO_SERVICIO, servicios.DESCRIPCION AS DESCRIPCION_SERVICIO,servicios.SUBCONTRATADO AS SUBCONTRATADO_SERVICIO, servicios.NIVEL_INGENIERO AS NIVEL_INGENIERO_SERVICIO,servicios.DURACION_ESTIMADA AS DURACION_ESTAMADA_SERVICIO, servicios.PRECIO AS PRECIO_SERVICIO ,formulario.DESCRIPCION AS DESCRIPCION_FORMULARIO');
        $builder->join('servicios', 'servicios.ID_SERVICIO = formulario_servicio.ID_SERVICIO');
        $builder->join('formulario', 'formulario.ID_FORMULARIO    = formulario_servicio.ID_FORMULARIO  ');
        $where = "formulario_servicio.ID_SERVICIO   ='$ID_SERVICIO'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_formularios_servicio($data)
    {
        $db = \Config\Database::connect();
        $db->table('formulario_servicio')->insert($data);
    }


    function delete_formularios_servicio($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('formulario_servicio');
        $builder->where('ID', $id);
        $builder->delete();
    }
    /*-------------------------------ASIGNACION REPUESTOS------------------------------------------- */

    /*-------------------------------MODULOS-EQUIPOS------------------------------------------- */
    function listar_modulos_equipo($id_equipo)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('modulos_equipo');
        $builder->select('*');
        $where = "modulos_equipo.ID_EQUIPO  ='$id_equipo'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_modulos_equipo($data)
    {
        $db = \Config\Database::connect();
        $db->table('modulos_equipo')->insert($data);
    }
    function get_modulos_equipo($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('modulos_equipo');
        $builder->select('*');
        $where = "modulos_equipo.ID_MODULO_EQUIPO ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function update_modulos_equipo($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('modulos_equipo')->update($data, ['ID_MODULO_EQUIPO ' => $id]);
    }
    /*-------------------------------MODULOS-EQUIPOS------------------------------------------- */
}
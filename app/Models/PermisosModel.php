<?php

namespace App\Models;

use CodeIgniter\Model;



class PermisosModel extends Model
{
    function listar_Perfiles()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('perfil');
        $builder->select('*');

        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_modulo($data)
    {
        $db = \Config\Database::connect();
        $db->table('asoc_perfil_servicio')->insert($data);
    }
    function delete_modulo($ID_PERFIL, $ID_SERVICIO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('asoc_perfil_servicio');
        $builder->where('ID_PERFIL ', $ID_PERFIL);
        $builder->where('ID_SERVICIO ', $ID_SERVICIO);
        $builder->delete();
    }
    function modulos_perfil($id_perfil)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('asoc_perfil_servicio');
        $builder->select('asoc_perfil_servicio.*, menu.NOMBRE AS NOMBRE_MENU, servicio.NOMBRE AS NOMBRE_SERVICIO');
        $builder->join('perfil', 'perfil.ID = asoc_perfil_servicio.ID_PERFIL ');
        $builder->join('servicio', 'servicio.ID   = asoc_perfil_servicio.ID_SERVICIO ');
        $builder->join('menu', 'servicio.ID_MENU   = menu.ID ');
        $where = "asoc_perfil_servicio.ID_PERFIL   ='$id_perfil'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();

    }

    function modulos_no_perfil($id_perfil)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('asoc_perfil_servicio');
        $builder->select('servicio.ID');
        $builder->join('servicio', 'servicio.ID   = asoc_perfil_servicio.ID_SERVICIO ');
        $where = "asoc_perfil_servicio.ID_PERFIL   ='$id_perfil'";
        $builder->where($where);
        $subQuery = $builder->getCompiledSelect();

        // $subQuery = $this->db->table('table_name')->select('column_name')->where('condition', 'value')->getCompiledSelect();

        $query = $this->db->table('servicio')
            ->select('servicio.ID AS ID_SERVICIO ,menu.NOMBRE AS NOMBRE_MENU, servicio.NOMBRE AS NOMBRE_SERVICIO')
            ->join('menu', 'servicio.ID_MENU   = menu.ID ')
            ->where("servicio.ID NOT IN ($subQuery)", null, false)->get();
        return $query->getResult();
        // Output the result
        // $result = $query->getResult();


    }
    function modulos_perfil_asignar($id_perfil)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('asoc_perfil_servicio');
        $builder->select('servicio.ID AS ID_SERVICIO ,menu.NOMBRE AS NOMBRE_MENU, servicio.NOMBRE AS NOMBRE_SERVICIO');
        $builder->join('servicio', 'servicio.ID   = asoc_perfil_servicio.ID_SERVICIO ');
        $builder->join('menu', 'servicio.ID_MENU   = menu.ID ');
        $where = "asoc_perfil_servicio.ID_PERFIL   ='$id_perfil'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();

    }
    function update_permisos($data, $id)
    {
        $db = \Config\Database::connect();
        $db->table('asoc_perfil_servicio')->update($data, ['ID ' => $id]);
    }

}
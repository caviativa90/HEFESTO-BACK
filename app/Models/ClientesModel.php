<?php

namespace App\Models;

use CodeIgniter\Model;



class ClientesModel extends Model
{

    protected $table = 'cliente';

    function get_lista_clientes()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cliente');
        $builder->select('cliente.*');
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_cliente($data)
    {
        $db = \Config\Database::connect();
        $db->table('cliente')->insert($data);
        return $db->insertID();
    }
    function update_cliente($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('cliente')->update($data, ['ID_CLIENTE ' => $id]);
    }
    function get_cliente($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cliente');
        $builder->select('*');
        $where = "cliente.ID_CLIENTE='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

    function listar_dependecias_clientes($ID_CLIENTE)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dependecias');
        $builder->select('*');
        $where = "dependecias.ID_CLIENTE='$ID_CLIENTE' ";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_dependencia_cliente($data)
    {
        $db = \Config\Database::connect();
        $db->table('dependecias')->insert($data);
        return $db->insertID();
    }
    function get_dependencia($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dependecias');
        $builder->select('*');
        $where = "dependecias.ID_DEPENDENCIA ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function update_dependencia($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('dependecias')->update($data, ['ID_DEPENDENCIA ' => $id]);
    }
    function listar_contactos_dependecias_clientes($ID_DEPENDECIA)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('contacto_dependencias');
        $builder->select('*');
        $where = "contacto_dependencias.ID_DEPENDENCIA='$ID_DEPENDECIA' ";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_contactos_dependencia_cliente($data)
    {
        $db = \Config\Database::connect();
        $db->table('contacto_dependencias')->insert($data);
        return $db->insertID();
    }
    function get_contacto_dependencia($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('contacto_dependencias');
        $builder->select('*');
        $where = "contacto_dependencias.ID_CONTACTO ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function update_contacto_dependencia($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('contacto_dependencias')->update($data, ['ID_CONTACTO ' => $id]);
    }

    function get_cliente_dependecia_contacto($NIT, $SUCURSAL, $CIUDAD, $CORREO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('contacto_dependencias');
        $builder->select('*');
        $builder->join('dependecias', 'dependecias.ID_DEPENDENCIA = contacto_dependencias.ID_DEPENDENCIA');
        $builder->join('cliente', 'cliente.ID_CLIENTE = dependecias.ID_CLIENTE');
        $where = "cliente.NIT='$NIT' AND dependecias.SUCURSAL='$SUCURSAL' AND dependecias.CIUDAD = '$CIUDAD' AND contacto_dependencias.CORREO = '$CORREO'";
        $builder->where($where);
        $query = $builder->get();
        if (count($query->getResult()) > 0) {
            return true;
        } else {
            return false;
        }

    }
    function get_existe_cliente($NIT)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cliente');
        $builder->select('*');
        $where = "cliente.NIT='$NIT' ";
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();


    }

    function get_existe_cliente_dependencia($NIT, $SUCURSAL, $CIUDAD)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('dependecias');
        $builder->select('*');
        $builder->join('cliente', 'cliente.ID_CLIENTE = dependecias.ID_CLIENTE');
        $where = "cliente.NIT='$NIT' AND dependecias.SUCURSAL='$SUCURSAL' AND dependecias.CIUDAD = '$CIUDAD' ";
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();


    }
    function insertar_item($data)
    {
        $db = \Config\Database::connect();
        $db->table('item_carga')->insert($data);
        return $db->insertID();
    }


    function insertar_carga($data)
    {
        $db = \Config\Database::connect();
        $db->table('carga')->insert($data);
        return $db->insertID();
    }
    function editar_carga($id_carga, $datos)
    {
        $db = \Config\Database::connect();
        $db->table('carga')->update($datos, ['ID ' => $id_carga]);
    }

    function consultarTodosCargaClientes()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('carga');
        $builder->select('carga.ID AS ID_CARGA,carga.FECHA AS FECHA_CARGA, carga.INSERTADOS , carga.EDITADOS, carga.ERRORES, (carga.INSERTADOS + carga.EDITADOS + carga.ERRORES) AS TOTAL, usuario.NOMBRES AS NOMBRE_USUARIO, usuario.ID AS ID_USUARIO');
        $builder->join('usuario', 'usuario.ID  = carga.ID_USUARIO ');
        $where = "carga.TIPO = 'CLIENTES'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();


    }



    function obtener_detalle_insertados_carga($id_carga)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('item_carga');
        $builder->select('DATOS');
        $where = " ID_CARGA = '$id_carga'  AND TIPO = 'INSERCION' ";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function obtener_detalle_editados_carga($id_carga)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('item_carga');
        $builder->select('DATOS');
        $where = " ID_CARGA = '$id_carga'  AND TIPO = 'EDICION' ";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function obtener_detalle_errores_carga($id_carga)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('item_carga');
        $builder->select('DATOS');
        $where = " ID_CARGA = '$id_carga'  AND TIPO = 'ERROR' ";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

    /*-------------------------------SERVICIOS------------------------------------------- */
    function listar_equipos_dependencia($ID_DEPENDECIA)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipo');
        $builder->select('*');
        $where = "equipo.ID_DEPENDENCIA   ='$ID_DEPENDECIA'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_equipo_dependencia($data)
    {
        $db = \Config\Database::connect();
        $db->table('equipo')->insert($data);
    }
    function get_equipo_dependencia($ID_EQUIPO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipo');
        $builder->select('*');
        $where = "equipo.ID_EQUIPO    ='$ID_EQUIPO '";
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
    function get_programacion_ingeniero_hora($ID_INGENIERO, $FECHA_INICIO, $FECHA_FIN )
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('odt.*, cliente.RAZON_SOCIAL');
        $builder->join('cliente', 'cliente.NIT  = odt.CLIENTE');
        $where = "odt.ID_INGENIERO='$ID_INGENIERO ' 
        AND odt.FECHA_PROGRAMACION <= '$FECHA_INICIO' 
        AND odt.FECHA_FIN_PROGRAMACION >= '$FECHA_INICIO' 
        OR odt.ID_INGENIERO='$ID_INGENIERO ' 
        AND odt.FECHA_PROGRAMACION <= '$FECHA_FIN' 
        AND odt.FECHA_FIN_PROGRAMACION >= '$FECHA_FIN'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

    function get_programacion_ingeniero_hora_update($ID_INGENIERO, $FECHA_INICIO, $FECHA_FIN ,$ID_ODT)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('odt.*, cliente.RAZON_SOCIAL');
        $builder->join('cliente', 'cliente.NIT  = odt.CLIENTE');
        $where = "odt.ID_INGENIERO='$ID_INGENIERO ' 
        AND odt.FECHA_PROGRAMACION <= '$FECHA_INICIO' 
        AND odt.FECHA_FIN_PROGRAMACION >= '$FECHA_INICIO' 
        AND odt.ID_ODT != '$ID_ODT'
        OR odt.ID_INGENIERO='$ID_INGENIERO ' 
        AND odt.FECHA_PROGRAMACION <= '$FECHA_FIN' 
        AND odt.FECHA_FIN_PROGRAMACION >= '$FECHA_FIN'
        AND odt.ID_ODT != '$ID_ODT'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function update_equipo_dependencia($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('equipo')->update($data, ['ID_EQUIPO ' => $id]);
    }
    /*-------------------------------SERVICIOS------------------------------------------- */
    function listar_equipos_cliente($ID_CLIENTE)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipo');
        $builder->select('equipo.*');
        $builder->join('dependecias', 'dependecias.ID_DEPENDENCIA   = equipo.ID_DEPENDENCIA ');
        $builder->join('cliente', 'cliente.ID_CLIENTE    = dependecias.ID_CLIENTE ');
        $where = "cliente.ID_CLIENTE    ='$ID_CLIENTE'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    
    function listar_equipos_cliente_nit($NIT)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('equipo');
        $builder->select('equipo.*');
        $builder->join('dependecias', 'dependecias.ID_DEPENDENCIA   = equipo.ID_DEPENDENCIA ');
        $builder->join('cliente', 'cliente.ID_CLIENTE    = dependecias.ID_CLIENTE ');
        $where = "cliente.NIT    ='$NIT'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

}
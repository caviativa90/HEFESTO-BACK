<?php

namespace App\Models;

use CodeIgniter\Model;



class PedidoModel extends Model
{
    function insertar_pedidos($data)
    {
        $db = \Config\Database::connect();
        $db->table('pedidos')->insert($data);
        return $db->insertID();
    }
    function insertar_contratos($data)
    {
        $db = \Config\Database::connect();
        $db->table('contratos')->insert($data);
        return $db->insertID();
    }
    function insertar_formulario_odt($data)
    {
        $db = \Config\Database::connect();
        $db->table('formularios_odt')->insert($data);
        return $db->insertID();
    }
    function updateODT($data, $id)
    {
        $db = \Config\Database::connect();
        $db->table('odt')->update($data, ['ID_ODT' => $id]);
    }
    function insertar_carga($data)
    {
        $db = \Config\Database::connect();
        $db->table('carga')->insert($data);
        return $db->insertID();
    }
    function insertar_item($data)
    {
        $db = \Config\Database::connect();
        $db->table('item_carga')->insert($data);
        return $db->insertID();
    }
    function editar_carga($id_carga, $datos)
    {
        $db = \Config\Database::connect();
        $db->table('carga')->update($datos, ['ID ' => $id_carga]);
    }
    function consultarTodosCargaPedidos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('carga');
        $builder->select('carga.ID AS ID_CARGA,carga.FECHA AS FECHA_CARGA, carga.INSERTADOS ,  carga.ERRORES, (carga.INSERTADOS + carga.ERRORES) AS TOTAL, usuario.NOMBRES AS NOMBRE_USUARIO, usuario.ID AS ID_USUARIO');
        $builder->join('usuario', 'usuario.ID  = carga.ID_USUARIO ');
        $where = "carga.TIPO = 'PEDIDO' AND (carga.INSERTADOS + carga.EDITADOS + carga.ERRORES) != 0";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();


    }

    function consultarTodosCargaContratos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('carga');
        $builder->select('carga.ID AS ID_CARGA,carga.FECHA AS FECHA_CARGA, carga.INSERTADOS ,carga.EDITADOS,  carga.ERRORES, (carga.INSERTADOS + carga.ERRORES + carga.EDITADOS) AS TOTAL, usuario.NOMBRES AS NOMBRE_USUARIO, usuario.ID AS ID_USUARIO');
        $builder->join('usuario', 'usuario.ID  = carga.ID_USUARIO ');
        $where = "carga.TIPO = 'CONTRATO' AND (carga.INSERTADOS + carga.EDITADOS + carga.ERRORES) != 0";
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
    function listar_pedidos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos');
        $builder->select('pedidos.*, cliente.RAZON_SOCIAL,servicios.DESCRIPCION AS DESCRIPCION_SERVICIO');
        $builder->join('cliente', ' pedidos.CLIENTE = cliente.NIT ', 'left');
        $builder->join('servicios', ' pedidos.REFERENCIA = servicios.CODIGO ', 'left');
        $where = "pedidos.ESTADO  = 0";
        $builder->where($where);
        $builder->orderBy('pedidos.ID_PEDIDO ', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }

    function listar_contratos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('contratos');
        $builder->select('contratos.*, cliente.RAZON_SOCIAL,servicios.DESCRIPCION AS DESCRIPCION_SERVICIO');
        $builder->join('cliente', ' contratos.CLIENTE = cliente.NIT ', 'left');
        $builder->join('servicios', ' contratos.REFERENCIA = servicios.CODIGO ', 'left');
        $where = "contratos.ESTADO  = 0";
        $builder->where($where);
        $builder->orderBy('contratos.ID_CONTRATO ', 'ASC');
        $query = $builder->get();
        return $query->getResult();
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
    function get_ingenieros_nivel($nivel)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ingeniero');
        $builder->select('ingeniero.PRIORIDAD,ingeniero.ALIAS,ingeniero.ID,ingeniero.NIVEL,ingeniero.COSTO_MANO, usuario.ID AS ID_USUARIO,usuario.USUARIO ,usuario.NOMBRES,usuario.ID_PERFIL,usuario.ACTIVO,usuario.IDENTIFICACION');
        $builder->join('usuario', 'usuario.ID = ingeniero.ID_USUARIO')->groupBy('usuario.ID');
        $where = "ingeniero.NIVEL='$nivel'";
        $builder->where($where);
        $builder->orderBy('ingeniero.PRIORIDAD', 'ASC');
        $query = $builder->get();
        return $query->getResult();
    }
    function get_programacion_ingeniero_hora($ID_INGENIERO, $FECHA_INICIO, $FECHA_FIN)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('odt.*');
        $where = "odt.ID_INGENIERO='$ID_INGENIERO ' AND odt.FECHA_PROGRAMACION <= '$FECHA_INICIO' AND odt.FECHA_FIN_PROGRAMACION >= '$FECHA_INICIO' OR odt.ID_INGENIERO='$ID_INGENIERO ' AND odt.FECHA_PROGRAMACION <= '$FECHA_FIN' AND odt.FECHA_FIN_PROGRAMACION >= '$FECHA_FIN'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_ultima_ingeniero_odt($ID_INGENIERO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('odt.*');
        $where = "odt.ID_INGENIERO='$ID_INGENIERO '";
        $builder->where($where);
        $builder->orderBy('FECHA_FIN_PROGRAMACION', 'DESC')->limit(1);
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
        $where = "equipo.CODIGO_EQUIPO   ='$CODIGO_EQUIPO ' AND cliente.NIT = '$NIT_CLIENTE' ";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function listar_odt()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.EQUIPO as NOMBRE_EQUIPO, odt.*,ingeniero.COLOR ,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE, cliente.RAZON_SOCIAL,usuario.NOMBRES as ID_INGENIERO,servicios.ID_SERVICIO , servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('usuario', 'usuario.ID   = ingeniero.ID_USUARIO ');
        $builder->join('equipo', 'equipo.CODIGO_EQUIPO   = odt.CODIGO_EQUIPO ');
        $where = "odt.SUBCONTRATADO   ='0' AND odt.CONTRATO = 0 AND odt.ESTADO_ODT IN (0, 1)";
        $builder->where($where);
        $builder->orderBy('odt.ID_ODT', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    function listar_odt_nueva()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.EQUIPO as NOMBRE_EQUIPO, equipo.CODIGO_EQUIPO as CODIGO_EQUIPO_T ,odt.*,ingeniero.COLOR ,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE, cliente.RAZON_SOCIAL,usuario.NOMBRES as ID_INGENIERO,servicios.ID_SERVICIO , servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('usuario', 'usuario.ID   = ingeniero.ID_USUARIO ');
        $builder->join('equipo', 'equipo.ID_EQUIPO    = odt.CODIGO_EQUIPO ');
        $where = "odt.SUBCONTRATADO   ='0' AND odt.CONTRATO = 0  AND odt.ESTADO_ODT IN (0, 1)";
        $builder->where($where);
        $builder->orderBy('odt.ID_ODT', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function listar_odt_terceros()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.EQUIPO as NOMBRE_EQUIPO, equipo.CODIGO_EQUIPO as CODIGO_EQUIPO_T ,odt.*,ingeniero.COLOR ,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE, cliente.RAZON_SOCIAL,usuario.NOMBRES as ID_INGENIERO,servicios.ID_SERVICIO , servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('usuario', 'usuario.ID   = ingeniero.ID_USUARIO ');
        $builder->join('equipo', 'equipo.ID_EQUIPO = odt.CODIGO_EQUIPO ');
        $where = "odt.SUBCONTRATADO ='1' AND odt.ESTADO_ODT IN (0, 1)";
        $builder->where($where);
        $builder->orderBy('odt.ID_ODT', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    function listar_odt_contratos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.EQUIPO as NOMBRE_EQUIPO,equipo.CODIGO_EQUIPO as CODIGO_EQUIPO_T , odt.*,ingeniero.COLOR ,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE, cliente.RAZON_SOCIAL,usuario.NOMBRES as ID_INGENIERO,servicios.ID_SERVICIO , servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('usuario', 'usuario.ID   = ingeniero.ID_USUARIO ');
        $builder->join('equipo', 'equipo.ID_EQUIPO = odt.CODIGO_EQUIPO');
        $where = "odt.CONTRATO = 1 AND odt.ESTADO_ODT IN (0, 1) ";
        $builder->where($where);
        $builder->orderBy('odt.ID_ODT', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    function listar_odt_all()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.EQUIPO as NOMBRE_EQUIPO,equipo.CODIGO_EQUIPO as CODIGO_EQUIPO_T , odt.*,ingeniero.COLOR ,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE, cliente.RAZON_SOCIAL,usuario.NOMBRES as ID_INGENIERO,servicios.ID_SERVICIO , servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('usuario', 'usuario.ID   = ingeniero.ID_USUARIO ');
        $builder->join('equipo', 'equipo.ID_EQUIPO    = odt.CODIGO_EQUIPO ');
        $builder->orderBy('odt.ID_ODT', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    function listar_odt_all_fechas($fecha_inicio, $fecha_fin)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('fm-01-06.FECHA_INICIO as FECHA_INICIO_ODT,
        fm-01-06.FECHA_FIN as FECHA_FIN_ODT, 
        fm-01-06.TIEMPO_SERVICIO, 
        fm-01-06.PROBLEAMA_PRESENTADO, 
        servicios.TIPO_SERVICIO,
        equipo.EQUIPO as NOMBRE_EQUIPO,
        equipo.CODIGO_EQUIPO as CODIGO_EQUIPO_T , 
        odt.*,
        ingeniero.COLOR ,
        ingeniero.alias AS ALIAS_INGENIERO,
        cliente.alias AS ALIAS_CLIENTE,
        cliente.RAZON_SOCIAL,usuario.NOMBRES as ID_INGENIERO,servicios.ID_SERVICIO ,
        servicios.CODIGO AS CODIGO_SERVICIO , 
        servicios.DESCRIPCION AS DESCRIPCION_SERVICIO,
        servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('usuario', 'usuario.ID   = ingeniero.ID_USUARIO ');
        $builder->join('equipo', 'equipo.ID_EQUIPO    = odt.CODIGO_EQUIPO ');
        $builder->join('fm-01-06', 'fm-01-06.ID_ODT    = odt.ID_ODT  ');
        $where = "odt.FECHA_CREATE >= '$fecha_inicio' and odt.FECHA_CREATE <= '$fecha_fin'";
        $builder->where($where);
        $builder->orderBy('odt.ID_ODT', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function listar_odt_ingenieros($ID_INGENIERO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.EQUIPO as NOMBRE_EQUIPO, odt.*,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE,servicios.ID_SERVICIO , servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('equipo', 'equipo.CODIGO_EQUIPO   = odt.CODIGO_EQUIPO ');
        $where = " ID_INGENIERO  = '$ID_INGENIERO' AND odt.ESTADO_ODT = 1";
        $builder->where($where);
        $builder->orderBy('odt.ID_ODT', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    function listar_odt_ingenieros_nueva($ID_INGENIERO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.EQUIPO as NOMBRE_EQUIPO, equipo.CODIGO_EQUIPO as CODIGO_EQUIPO_T ,odt.*,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE,servicios.ID_SERVICIO , servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('equipo', 'equipo.ID_EQUIPO    = odt.CODIGO_EQUIPO ');
        $where = " ID_INGENIERO  = '$ID_INGENIERO' AND odt.ESTADO_ODT = 1";
        $builder->where($where);
        $builder->orderBy('odt.ID_ODT', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }
    function insertar_odt($data)
    {
        $db = \Config\Database::connect();
        $db->table('odt')->insert($data);
        return $db->insertID();
    }
    function eliminar_odt($ID_ODT)
    {
        $db = \Config\Database::connect();
        // Seleccionar la tabla 'odt'
        $builder = $db->table('odt');
        // Eliminar el registro con el ID especificado
        $builder->where('ID_ODT', $ID_ODT)->delete();
        // Verificar si se eliminó el registro
        if ($db->affectedRows() > 0) {
            return true; // El registro se eliminó correctamente
        } else {
            return false; // No se eliminó ningún registro
        }
    }
    function insertar_formulario_01_06($data)
    {
        $db = \Config\Database::connect();
        $db->table('fm-01-06')->insert($data);
        return $db->insertID();
    }
    function get_pedido_existe($PEDIDO, $REFERENCIA)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos');
        $builder->select('*');
        $where = "DOCUMENTO ='$PEDIDO' AND REFERENCIA ='$REFERENCIA'";
        $builder->where($where);
        $query = $builder->get();
        if (count($query->getResult()) > 0) {
            return true;
        } else {
            return false;
        }

    }
    function get_contrato_existe($PEDIDO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('contratos');
        $builder->select('*');
        $builder->where('DOCUMENTO_EXTERNO', $PEDIDO); // Construcción segura de la cláusula WHERE
        $query = $builder->get();
        $bandera = false;

        if ($query->getNumRows() > 0) { // Cambiado a getNumRows() para contar las filas
            $bandera = true;
        }
        return $bandera;

    }
    function get_pedido($ID_PEDIDO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('pedidos');
        $builder->select('*');
        $where = "pedidos.ID_PEDIDO ='$ID_PEDIDO ' ";
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();


    }
    function get_contrato($ID_CONTRATO)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('contratos');
        $builder->select('*');
        $where = "contratos.ID_CONTRATO ='$ID_CONTRATO ' ";
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();


    }

    function update_odt($ID_ODT, $datos)
    {
        $db = \Config\Database::connect();
        $db->table('odt')->update($datos, ['ID_ODT' => $ID_ODT]);
    }
    function get_odt_id($ID_ODT)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.ID_EQUIPO , odt.*,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE,servicios.ID_SERVICIO ,cliente.RAZON_SOCIAL, servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA,servicios.TIPO_SERVICIO');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('equipo', ' odt.CODIGO_EQUIPO = equipo.ID_EQUIPO');
        $where = "odt.ID_ODT  ='$ID_ODT '";
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();


    }

    function get_odt_id_all($ID_ODT)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.ID_EQUIPO , odt.*,usuario.NOMBRES AS NOMBRES_INGENIERO,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE,servicios.ID_SERVICIO ,cliente.RAZON_SOCIAL, servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA,servicios.TIPO_SERVICIO');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('usuario', 'usuario.ID  = ingeniero.ID_USUARIO ');
        $builder->join('equipo', ' odt.CODIGO_EQUIPO = equipo.ID_EQUIPO');
        $where = "odt.ID_ODT  ='$ID_ODT '";
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();


    }
    function get_odt_id_USUARIO($ID_ODT)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('usuario.NOMBRES AS NOMBRES_INGENIERO, usuario.USUARIO as CORREO, odt.*,ingeniero.ID AS ID_INGNIERO, ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE,servicios.ID_SERVICIO ,cliente.RAZON_SOCIAL, servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA,servicios.TIPO_SERVICIO');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('usuario', 'usuario.ID  = ingeniero.ID_USUARIO ');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $where = "odt.ID_ODT  ='$ID_ODT '";
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();


    }
    function get_odt_equipo_cliente($CODIGO_EQUIPO, $NIT_CLIENTE)//toy
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('equipo.EQUIPO as NOMBRE_EQUIPO, odt.*,ingeniero.COLOR ,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE, cliente.RAZON_SOCIAL,usuario.NOMBRES as ID_INGENIERO,servicios.ID_SERVICIO , servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('usuario', 'usuario.ID   = ingeniero.ID_USUARIO ');
        $builder->join('equipo', 'equipo.ID_EQUIPO   = odt.CODIGO_EQUIPO ');
        $where = "equipo.CODIGO_EQUIPO   ='$CODIGO_EQUIPO ' AND cliente.NIT = '$NIT_CLIENTE' ";
        $builder->where($where);
        $builder->orderBy('odt.ID_ODT', 'DESC');
        $query = $builder->get();
        return $query->getResult();
    }

    function nit_clientebyDependecia($ID_DEPENDECIA)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('cliente');
        $builder->select('cliente.NIT');
        $builder->join('dependecias', 'dependecias.ID_CLIENTE = cliente.ID_CLIENTE ');
        $where = "dependecias.ID_DEPENDENCIA    ='$ID_DEPENDECIA '";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

    function get_parafiscal($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('parafiscales_ingenieros');
        $builder->select('*');
        $where = "parafiscales_ingenieros.ID_INGENIERO ='$id'";

        $builder->where($where);
        $builder->orderBy('ID', 'DESC'); // Ordenar por ID de forma descendente   
        $builder->limit(1); // Limitar el resultado a un solo registro
        $query = $builder->get();
        return $query->getResult();
    }
    function get_odt_equipo($CODIGO_EQUIPO, $NIT_CLIENTE)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('odt');
        $builder->select('odt.*,ingeniero.alias AS ALIAS_INGENIERO,cliente.alias AS ALIAS_CLIENTE,servicios.ID_SERVICIO ,cliente.RAZON_SOCIAL, servicios.CODIGO AS CODIGO_SERVICIO , servicios.DESCRIPCION AS DESCRIPCION_SERVICIO, servicios.NIVEL_INGENIERO,servicios.DURACION_ESTIMADA');
        $builder->join('servicios', 'odt.SERVICO = servicios.CODIGO');
        $builder->join('ingeniero', 'odt.ID_INGENIERO  = ingeniero.ID');
        $builder->join('cliente', ' odt.CLIENTE = cliente.NIT');
        $builder->join('equipo', 'equipo.ID_EQUIPO   = odt.CODIGO_EQUIPO ');
        $where = "equipo.CODIGO_EQUIPO  ='$CODIGO_EQUIPO' AND cliente.NIT = '$NIT_CLIENTE'";
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();


    }
    function update_pedido_estado($data, $ID_PEDIDO)
    {
        $db = \Config\Database::connect();

        $db->table('pedidos')->update($data, ['ID_PEDIDO ' => $ID_PEDIDO]);
    }

    function update_odt_estado($data, $ID_ODT)
    {
        $db = \Config\Database::connect();

        $db->table('odt')->update($data, ['ID_ODT' => $ID_ODT]);
    }
    function listar_repuestos_odt($ID_ODT)
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

}
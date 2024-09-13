<?php

namespace App\Models;

use CodeIgniter\Model;



class UserModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'ID';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'USUARIO',
        'NOMBRE',
        'ID_PERFIL',
        'CONTRASENA',
        'ACTIVO',
        'PRIMER_INGRESO',
        'PORCENTAJE_CARGA',
        'IDENTIFICACION'
    ];


    function insertar_usuario($data)
    {
        $db = \Config\Database::connect();
        $db->table('usuario')->insert($data);
    }
    function update_usuario($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('usuario')->update($data, ['ID' => $id]);
    }


    function insertar_tipo_estudio($data)
    {
        $db = \Config\Database::connect();
        $db->table('lista_estudios')->insert($data);
    }
    function update_tipo_estudio($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('lista_estudios')->update($data, ['ID' => $id]);
    }


    function insertar_ingeniero($data)
    {
        $db = \Config\Database::connect();
        $db->table('ingeniero')->insert($data);
    }
    function update_ingeniero($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('ingeniero')->update($data, ['ID' => $id]);
    }

    function insertar_estudios_ingeniero($data)
    {
        $db = \Config\Database::connect();
        $db->table('estudios_ingenieros')->insert($data);
    }
    function update_estudios_ingeniero($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('estudios_ingenieros')->update($data, ['ID' => $id]);
    }
    function insertar_parafiscales_ingeniero($data)
    {
        $db = \Config\Database::connect();
        $db->table('parafiscales_ingenieros')->insert($data);
    }
    function update_parafiscales_ingeniero($data, $id)
    {
        $db = \Config\Database::connect();

        $db->table('parafiscales_ingenieros')->update($data, ['ID' => $id]);
    }


    function get_usuario($usuario, $contrasena)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');
        $builder->select('usuario.ID , usuario.USUARIO ,usuario.NOMBRES,usuario.ID_PERFIL,usuario.ACTIVO,usuario.IDENTIFICACION');
        $where = "usuario.USUARIO='$usuario' AND usuario.CONTRASENA='$contrasena'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_usuario_id($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');
        $builder->select('usuario.ID , usuario.USUARIO ,usuario.NOMBRES,usuario.ID_PERFIL,usuario.ACTIVO,usuario.IDENTIFICACION');
        $where = "usuario.ID='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }

    function get_lista_usuario()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('usuario');
        $builder->select('usuario.ID , usuario.USUARIO ,usuario.NOMBRES,usuario.ID_PERFIL,usuario.ACTIVO,usuario.IDENTIFICACION ,perfil.NOMBRE AS NOMBRE_PERFIL');
        $builder->join('perfil', 'perfil.ID = usuario.ID_PERFIL');
        $query = $builder->get();
        return $query->getResult();
    }

    function get_usuario_ingeniero()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ingeniero');
        $builder->select('ingeniero.CELULAR,ingeniero.SUBCONTRATADO,ingeniero.COLOR,ingeniero.PRIORIDAD,ingeniero.ALIAS,ingeniero.ID,ingeniero.NIVEL,ingeniero.COSTO_MANO, usuario.USUARIO ,usuario.NOMBRES,usuario.ID_PERFIL,usuario.ACTIVO,usuario.IDENTIFICACION,  perfil.NOMBRE AS NOMBRE_PERFIL');
        $builder->join('usuario', 'usuario.ID = ingeniero.ID_USUARIO')->groupBy('usuario.ID');
        $builder->join('perfil', 'perfil.ID = usuario.ID_PERFIL');

        $query = $builder->get();
        return $query->getResult();
    }
    function get_ingeniero($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ingeniero');
        $builder->select('ingeniero.CELULAR,ingeniero.SUBCONTRATADO,ingeniero.COLOR,ingeniero.PRIORIDAD,ingeniero.ALIAS,ingeniero.ID,ingeniero.NIVEL,ingeniero.COSTO_MANO, usuario.ID AS ID_USUARIO,usuario.USUARIO ,usuario.NOMBRES,usuario.ID_PERFIL,usuario.ACTIVO,usuario.IDENTIFICACION');
        $builder->join('usuario', 'usuario.ID = ingeniero.ID_USUARIO')->groupBy('usuario.ID');
        $where = "ingeniero.ID='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_ingeniero_usuario($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('ingeniero');
        $builder->select('ingeniero.*');
        $where = "ingeniero.ID_USUARIO='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_estuduio_ingeniero($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('estudios_ingenieros');
        $builder->select('*');
        $where = "estudios_ingenieros.ID ='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_parafiscal($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('parafiscales_ingenieros');
        $builder->select('*');
        $where = "parafiscales_ingenieros.ID='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_tipo_estudio($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('lista_estudios');
        $builder->select('*');
        $where = "lista_estudios.ID='$id'";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }



    function get_estudios_ingeniero($id_usuario)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('estudios_ingenieros');
        $builder->select('estudios_ingenieros.* ,lista_estudios.DESCRIPCION as TIPO_NOMBRE');
        $where = "estudios_ingenieros.ID_INGENIERO='$id_usuario' ";
        $builder->join('lista_estudios', 'lista_estudios.ID = estudios_ingenieros.TIPO ');
        $builder->where($where);

        $query = $builder->get();
        return $query->getResult();
    }

    function get_parafiscales_ingeniero($id_usuario)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('parafiscales_ingenieros');
        $builder->select('*');
        $where = "parafiscales_ingenieros.ID_INGENIERO='$id_usuario' ";
        $builder->where($where);
        $query = $builder->get();
        return $query->getResult();
    }
    function get_lista_estudios()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('lista_estudios');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResult();
    }


    function get_lista_perfiles()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('perfil');
        $builder->select('*');
        $query = $builder->get();
        return $query->getResult();
    }






}
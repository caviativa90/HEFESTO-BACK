<?php

namespace App\Models;

use CodeIgniter\Model;



class CargaModel extends Model
{

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


}
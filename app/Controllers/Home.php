<?php

namespace App\Controllers;

class Home extends BaseController
{


    

    public function index()
    {
    echo "efesto back - servidor";

    }


    public function usuarios()
    
    {
        $data = array(
            'ID' => "1",
            'USUARIO' => "prueba@gmail.com",
            'NOMBRE' => "Rafael Lleras",
            'ID_PERFIL' => 2,
            'CONTRASENA' => "prueba",
            'ACTIVO' => 1,
            'PRIMER_INGRESO' => 1,
            'PORCENTAJE_CARGA' => 0
        );
        $UsuarioModel = model("UserModel");
        //$user = $UsuarioModel->find(1);
        //$user = $UsuarioModel->where("NOMBRE","Daniel Caviativa2")->findall();
        //$UsuarioModel->insertar($data);
        //$UsuarioModel->update(1, $data);
        //$UsuarioModel->save($data);           
        $user = $UsuarioModel->where('ID_PERFIL', '2')->orderBy('ID', 'asc')->findAll();

        // $user = $UsuarioModel->get_usuario();
        echo json_encode($user);

    }

}
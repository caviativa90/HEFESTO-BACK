<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Usuario extends ResourceController
{
    protected $request;
    protected $modelName = 'App\Models\UserModel';
    protected $format = "json";



    public function autenticar()
    {
        $data = json_decode(file_get_contents("php://input"));
        $usuario = $data->usuario;
        $contrasena = $data->contrasena;
        return $this->respond($this->model->get_usuario($usuario, $contrasena));

    }
    public function ingeniero_usuario()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_USUARIO = $data->ID_USUARIO;
        return $this->respond($this->model->get_ingeniero_usuario($ID_USUARIO));

    }
    public function listar_usuarios()
    {
        $users = $this->model->get_lista_usuario();
        return $this->respond($users);
    }
    function get_usuario()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $USER = $this->model->get_usuario_id($ID);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "usuario" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function insertar_usuario()
    {

        $data = json_decode(file_get_contents("php://input"));
        $usuario = $data->USUARIO;
        $nombre = $data->NOMBRES;
        $perfil = $data->PERFIL;
        $identificacion = $data->IDENTIFICACION;
        $contrasena = $this->generarContrasena();
        $activo = 1;
        $datos_insertar = array(
            "USUARIO" => $usuario,
            "NOMBRES" => $nombre,
            "ID_PERFIL" => $perfil,
            "CONTRASENA" => $contrasena,
            "ACTIVO" => $activo,
            "IDENTIFICACION" => $identificacion
        );
        $this->model->insertar_usuario($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }

    public function update_usuario()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $usuario = $data->USUARIO;
        $nombre = $data->NOMBRES;
        $perfil = $data->PERFIL;
        $identificacion = $data->IDENTIFICACION;
        $activo = $data->ACTIVO;
        $datos_insertar = array(
            "USUARIO" => $usuario,
            "NOMBRES" => $nombre,
            "ID_PERFIL" => $perfil,
            "ACTIVO" => $activo,
            "IDENTIFICACION" => $identificacion
        );
        $this->model->update_usuario($datos_insertar, $ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));


    }
    public function update_usuario_pass()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $CONTRASENA = $data->CONTRASENA;

        $datos_insertar = array(
            "CONTRASENA" => $CONTRASENA,
        );
        $this->model->update_usuario($datos_insertar, $ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));


    }
    public function update_passwords()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;

        $contrasena = $this->generarContrasena();
        $datos_insertar = array(
            "CONTRASENA" => $contrasena,

        );
        $this->model->update_usuario($datos_insertar, $ID);
        $USER = $this->model->get_usuario_id($ID);
        //var_dump($USER );
        $this->envio_correo($USER[0]->NOMBRES, $USER[0]->USUARIO, $contrasena);
        return $this->respond(array("code" => 200, "msg" => "OK"));


    }
    public function envio_correo($nombres, $CORREO, $PASS)
    {



        $mensaje = '<div class="rps_451c">
        <div id="x_outlook"
            style="padding: 0px; margin: 0px; background-color: rgb(255, 255, 255); font: 15px / 22px Arial, Helvetica, sans-serif, serif, EmojiFont;">
            <table cellpadding="0" cellspacing="0" bgcolor="#f7f7f7" border="0" width="100%" align="center">
                <tbody>
                    <tr>
                        <td align="center">
                            <table cellpadding="0" cellspacing="0" bgcolor="#f7f7f7" border="0" width="626" align="center">
                                <tbody>
                                    <tr>
                                        <td height="31" valign="middle" width="300"
                                            style="font:bold 11px Arial; line-height:11px; color:#9c9c9c">Bienvenido a
                                            HEFESTO!</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="100%">
                <tbody>
                    <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center">
                                <tbody>
                                    <tr>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" border="0" width="640" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" height="13" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="140" height="62"><a href="https://quimitronica.com"
                                                                target="_blank" rel="noopener noreferrer"
                                                                data-auth="NotApplicable" class="x_links"
                                                                data-safelink="true" data-linkindex="0"><img
                                                                    data-imagetype="External"
                                                                    src="https://www.quimitronica.com/wp-content/uploads/2021/02/cropped-Quimitro%CC%81nica-Favicon-180x180.png"
                                                                    width="64" height="64" alt="HEFESTO"
                                                                    style="display:block; border:none"></a></td>
                                                        <td width="500">
                                                            <table cellpadding="0" cellspacing="0" border="0" width="100%"
                                                                align="center">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="right"
                                                                            style="color:#6b6b6b; color:#1b365d; font:bold 26px/35px arial; padding:10px 5px 10px 0">
                                                                            Notificación Hefesto </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" height="20" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="640"
                                                align="center" style="border-top:2px solid #1b365d">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2" height="16" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="320" align="left"
                                                            style="font:16px/18px Arial; color:#383838; text-decoration:none">
                                                            <span
                                                                style="font: 16px / 18px Arial, serif, EmojiFont; color: rgb(56, 56, 56); text-decoration: none;">Estimado:
                                                                ' . $nombres . ' </span>
                                                        </td>
                                                        <td width="320" align="right" style="font:16px/18px Arial"><a
                                                                href="https://hefesto.quimitronica.com/" target="_blank"
                                                                rel="noopener noreferrer" data-auth="NotApplicable"
                                                                class="x_links"
                                                                style="color:#4b79f4; text-decoration:underline"
                                                                data-safelink="true" data-linkindex="1">Ingresar a
                                                                Hefesto</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" height="16" style="font-size:0; line-height:0">
                                                            &nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="100%" align="center">
                                <tbody>
                                    <tr>
                                        <td width="10">&nbsp;</td>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" bgcolor="#ffffff" border="0" width="626"
                                                align="center">
                                                <tbody>
                                                    <tr>
                                                        <td align="left"
                                                            style="font:16px/24px Arial; color:#2b2b2b; padding:45px 0 0">


                                                            
                                                            <h2>Confirmación de Restablecimiento de Contraseña</h2>
                                                            <p>Hola ' . $nombres . ',</p>
                                                            <p>Te escribimos para informarte que tu contraseña ha sido restablecida con éxito en nuestra aplicación. Ahora puedes acceder a tu cuenta utilizando tu nueva contraseña.</p>
                                                            <BR> El usuario es  : ' . $CORREO . '

                                                            <BR> La contraseña es  : ' . $PASS . '<br>
                                                            <p>Si tú no solicitaste este cambio o tienes alguna pregunta, por favor contáctanos de inmediato. Estamos aquí para ayudarte en cualquier problema que puedas tener.</p>
                                                            <p>¡Gracias por confiar en nosotros!</p>
                                                            <p>Saludos cordiales,</p>
                                     
                                                          
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="10">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                        <td align="center">
                                            <table cellpadding="0" cellspacing="0" border="0" width="646" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td height="0"
                                                            style="font-size:0; line-height:0; padding-bottom:24px; border-bottom:1px solid #dddddd">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font:11px/16px Arial; color:#999999; padding:23px 0 0 10px">
                                                            <p><strong>This es un mensaje automatico – por favor no
                                                                    responder.</strong><br aria-hidden="true">Si desea
                                                                responder a este correo electrónico, por favor <a href="#"
                                                                    target="_blank" rel="noopener noreferrer"
                                                                    style="color:#999999; font:11px/15px Arial; text-decoration:underline"
                                                                    data-safelink="true" data-linkindex="5">Contactar a
                                                                    Soporte</a>. </p>
                                                            <p><strong>Hefesto</strong> es un software de
                                                                <strong>QUIMITRONICA SAS.</strong> © 2023<strong>
                                                                    QUIMITRONICA SAS</strong>. Derechos Reservados. </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="0"
                                                            style="font-size:0; line-height:0; padding-bottom:24px; border-bottom:1px solid #dddddd">
                                                            &nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center"
                                                            style="font:11px/24px Arial; color:#999999; padding-top:7px">
                                                            Cra. 49b # 93-93, Bogotá - Colombia </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="0"
                                                            style="font-size:0; line-height:0; padding-bottom:15px">&nbsp;
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>';
        $email = \Config\Services::email();
        $email->setFrom('notificaciones@quimitronica.com', 'HEFESTO');
        $email->setTo($CORREO);
        $email->setSubject('CAMBIO CONTRASEÑA HEFESTO ');
        $email->setMessage($mensaje);
        $email->send();



    }

    public function listar_ingenieros_usuario()
    {

        $user = $this->model->get_usuario_ingeniero();
        return $this->respond($user);
    }
    function get_ingeniero()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $USER = $this->model->get_ingeniero($ID);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "usuario" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function insertar_ingeniero()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_USUARIO = $data->ID_USUARIO;
        $NIVEL = $data->NIVEL;
        $COSTO_MANO = $data->COSTO_MANO;
        $ALIAS = $data->ALIAS;
        $PRIORIDAD = $data->PRIORIDAD;
        $COLOR = $data->COLOR;
        $CELULAR = $data->CELULAR;
        $SUBCONTRATADO = $data->SUBCONTRATADO;

        $datos_insertar = array(
            "ID_USUARIO" => $ID_USUARIO,
            "NIVEL" => $NIVEL,
            "COSTO_MANO" => $COSTO_MANO,
            "ALIAS" => $ALIAS,
            "PRIORIDAD" => $PRIORIDAD,
            "COLOR" => $COLOR,
            "CELULAR" => $CELULAR,
            "SUBCONTRATADO" => $SUBCONTRATADO

        );
        $this->model->insertar_ingeniero($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));

    }

    public function update_ingeniero()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $ID_USUARIO = $data->ID_USUARIO;
        $NIVEL = $data->NIVEL;
        $COSTO_MANO = $data->COSTO_MANO;
        $ALIAS = $data->ALIAS;
        $PRIORIDAD = $data->PRIORIDAD;
        $COLOR = $data->COLOR;
        $CELULAR = $data->CELULAR;
        $SUBCONTRATADO = $data->SUBCONTRATADO;
        $datos_insertar = array(
            "ID_USUARIO" => $ID_USUARIO,
            "NIVEL" => $NIVEL,
            "COSTO_MANO" => $COSTO_MANO,
            "ALIAS" => $ALIAS,
            "PRIORIDAD" => $PRIORIDAD,
            "COLOR" => $COLOR,
            "CELULAR" => $CELULAR,
            "SUBCONTRATADO" => $SUBCONTRATADO

        );
        $this->model->update_ingeniero($datos_insertar, $ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));

    }

    public function listar_estudios_ingenieros_usuario()
    {
        $data = json_decode(file_get_contents("php://input"));
        $id_ingeniero = $data->ID_INGENIERO;
        $lista_estudios = $this->model->get_estudios_ingeniero($id_ingeniero);
        return $this->respond($lista_estudios);
    }



    public function insertar_estudios_ingeniero()
    {

        $ID_INGENIERO = $this->request->getPost('ID_INGENIERO');
        $DESCRIPCION = $this->request->getPost('DESCRIPCION');
        $INSTITUCION = $this->request->getPost('INSTITUCION');
        $DURACION = $this->request->getPost('DURACION');
        $FECHA_FIN = $this->request->getPost('FECHA_FIN');
        $TIPO = $this->request->getPost('TIPO');
        $carpeta = "estudios";
        $ADJUNTO = $this->archivo_subir($ID_INGENIERO, $carpeta);


        $datos_insertar = array(
            "ID_INGENIERO" => $ID_INGENIERO,
            "DESCRIPCION" => $DESCRIPCION,
            "INSTITUCION" => $INSTITUCION,
            "DURACION" => $DURACION,
            "FECHA_FIN" => $FECHA_FIN,
            "ADJUNTO" => $ADJUNTO,
            "TIPO" => $TIPO
        );
        $this->model->insertar_estudios_ingeniero($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function archivo_subir($id, $carpeta)
    {

        if ($ADJUNTO = $this->request->getfile('ADJUNTO')) {

            if ($ADJUNTO->isvalid() && !$ADJUNTO->hasMoved()) {

                $newName = $ADJUNTO->getRandomName();
                $ADJUNTO->move(WRITEPATH . 'uploads/ingenieros/' . $carpeta . '/' . $id, $newName);
                return $newName;

            }

        }


    }
    function archivo_ingeniero($ID_INGENIERO = null, $ADJUNTO = null)
    {
        // abre el archivo en modo binario
        if (!$ID_INGENIERO) { // $movieId== null
            $ID_INGENIERO = $this->request->getGet('ID_INGENIERO');
        }
        if (!$ADJUNTO) { // $image== null
            $ADJUNTO = $this->request->getGet('ADJUNTO');
        }

        if ($ID_INGENIERO == '' || $ADJUNTO == '') {

        }
        $name = WRITEPATH . 'uploads/ingenieros/estudios/' . $ID_INGENIERO . '/' . $ADJUNTO;
        if (!file_exists($name)) {

        }
        $fp = fopen($name, 'rb');
        // envía las cabeceras correctas
        header("Content-type:application/pdf");
        header("Content-Length: " . filesize($name));
        // vuelca la imagen y detiene el script
        fpassthru($fp);
        exit;
    }
    function archivo_ingeniero_parafiscales($ID_INGENIERO = null, $ADJUNTO = null)
    {
        // abre el archivo en modo binario
        if (!$ID_INGENIERO) { // $movieId== null
            $ID_INGENIERO = $this->request->getGet('ID_INGENIERO');
        }
        if (!$ADJUNTO) { // $image== null
            $ADJUNTO = $this->request->getGet('ADJUNTO');
        }

        if ($ID_INGENIERO == '' || $ADJUNTO == '') {

        }
        $name = WRITEPATH . 'uploads/ingenieros/parafiscales/' . $ID_INGENIERO . '/' . $ADJUNTO;
        if (!file_exists($name)) {

        }
        $fp = fopen($name, 'rb');
        // envía las cabeceras correctas
        header("Content-type:application/pdf");
        header("Content-Length: " . filesize($name));
        // vuelca la imagen y detiene el script
        fpassthru($fp);
        exit;
    }
    public function update_estudios_ingeniero()
    {


        $ID = $this->request->getPost('ID');
        $ID_INGENIERO = $this->request->getPost('ID_INGENIERO');
        $DESCRIPCION = $this->request->getPost('DESCRIPCION');
        $INSTITUCION = $this->request->getPost('INSTITUCION');
        $DURACION = $this->request->getPost('DURACION');
        $FECHA_FIN = $this->request->getPost('FECHA_FIN');
        $TIPO = $this->request->getPost('TIPO');
        $carpeta = "estudios";
        $ADJUNTO = $this->archivo_subir($ID_INGENIERO, $carpeta);


        $datos_insertar = array(
            "ID_INGENIERO" => $ID_INGENIERO,
            "DESCRIPCION" => $DESCRIPCION,
            "INSTITUCION" => $INSTITUCION,
            "DURACION" => $DURACION,
            "FECHA_FIN" => $FECHA_FIN,
            "ADJUNTO" => $ADJUNTO,
            "TIPO" => $TIPO
        );
        $this->model->update_estudios_ingeniero($datos_insertar, $ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));

    }
    function get_estuduio_ingeniero()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $USER = $this->model->get_estuduio_ingeniero($ID);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "usuario" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }

    public function listar_parafiscales_ingeniero()
    {

        $data = json_decode(file_get_contents("php://input"));
        $id_ingeniero = $data->ID_INGENIERO;
        $user = $this->model->get_parafiscales_ingeniero($id_ingeniero);
        return $this->respond($user);
    }

    public function insertar_parafiscales_ingeniero()
    {



        $ID_INGENIERO = $this->request->getPost('ID_INGENIERO');
        $MES = $this->request->getPost('MES');
        $AÑO = $this->request->getPost('AÑO');
        $carpeta = "parafiscales";
        $ADJUNTO = $this->archivo_subir($ID_INGENIERO, $carpeta);
        $datos_insertar = array(
            "ID_INGENIERO" => $ID_INGENIERO,
            "MES" => $MES,
            "AÑO" => $AÑO,
            "ADJUNTO" => $ADJUNTO,
        );
        $this->model->insertar_parafiscales_ingeniero($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }

    public function update_parafiscales_ingeniero()
    {

        $ID_INGENIERO = $this->request->getPost('ID_INGENIERO');
        $ID = $this->request->getPost('ID');
        $MES = $this->request->getPost('MES');
        $AÑO = $this->request->getPost('AÑO');
        $carpeta = "parafiscales";
        $ADJUNTO = $this->archivo_subir($ID_INGENIERO, $carpeta);



        $datos_insertar = array(
            "MES" => $MES,
            "AÑO" => $AÑO,
            "ADJUNTO" => $ADJUNTO

        );
        $this->model->update_parafiscales_ingeniero($datos_insertar, $ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));

    }
    function get_parafiscal_ingeniero()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $USER = $this->model->get_parafiscal($ID);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "usuario" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    public function listar_tipo_estudio()
    {
        $lista = $this->model->get_lista_estudios();
        return $this->respond($lista);
    }

    public function insertar_tipo_estudio()
    {

        $data = json_decode(file_get_contents("php://input"));
        $DESCRIPCION = $data->DESCRIPCION;

        $datos_insertar = array(
            "DESCRIPCION" => $DESCRIPCION,

        );
        $this->model->insertar_tipo_estudio($datos_insertar);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }

    public function update_tipo_estudio()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $DESCRIPCION = $data->DESCRIPCION;

        $datos_insertar = array(
            "DESCRIPCION" => $DESCRIPCION,

        );
        $this->model->update_tipo_estudio($datos_insertar, $ID);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }

    function get_tipo_estudio()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID = $data->ID;
        $USER = $this->model->get_tipo_estudio($ID);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "usuario" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }
    function generarContrasena()
    {
        $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $combLen = strlen($comb) - 1;
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $combLen);
            $pass[] = $comb[$n];
        }
        return implode($pass);
    }
    function listar_perfiles()
    {
        $arr_perfiles = $this->model->get_lista_perfiles();
        if (count($arr_perfiles) > 0) {
            return $this->respond(array("code" => 200, "perfiles" => $arr_perfiles));
        } else {
            return $this->respond(array("code" => 400));
        }
    }


}
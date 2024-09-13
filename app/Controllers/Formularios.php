<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

use App\Libraries\TempletePdf;

class Formularios extends ResourceController
{
    protected $request;
    protected $modelName = 'App\Models\FormularioModel';
    protected $format = "json";


    public function update_01_06()
    {
        $VALOR = $this->request->getPost('VALOR');
        $NOMBRE = $this->request->getPost('NOMBRE');
        $ID_ODT = $this->request->getPost('ID_ODT');

        if ($NOMBRE == "FOTOGRAFIA_INICIAL_UNO") {
            $VALOR = $this->archivo_subir_formulario_01_06($ID_ODT, "formulario_01_06");
        } else {
            if ($NOMBRE == "FOTOGRAFIA_INICIAL_DOS") {
                $VALOR = $this->archivo_subir_formulario_01_06($ID_ODT, "formulario_01_06");
            } else {
                if ($NOMBRE == "FOTO_FINAL") {
                    $VALOR = $this->archivo_subir_formulario_01_06($ID_ODT, "formulario_01_06");
                } else {
                    if ($NOMBRE == "FOTO_FINAL_DOS") {
                        $VALOR = $this->archivo_subir_formulario_01_06($ID_ODT, "formulario_01_06");
                    } else {


                    }


                }
            }

        }
        $datos_insertar = array(
            "$NOMBRE" => $VALOR
        );

        $data_g = $this->model->get_01_06($ID_ODT);

        if (empty($data_g)) {
            return $this->respond(array("code" => 400, "msg" => "ODT NO EXISTE"));

        } else {
            $this->model->update_FM_DP_ST_01_06($datos_insertar, $ID_ODT);
            return $this->respond(array("code" => 200, "msg" => "OK"));
        }

    }
    public function update_01_12()
    {
        $VALOR = $this->request->getPost('VALOR');
        $NOMBRE = $this->request->getPost('NOMBRE');
        $ID_ODT = $this->request->getPost('ID_ODT');

        if ($NOMBRE == "FOTO_UNO") {
            $VALOR = $this->archivo_subir_formulario_01_12($ID_ODT, "formulario_01_12");
        } else {
            if ($NOMBRE == "FOTO_DOS") {
                $VALOR = $this->archivo_subir_formulario_01_06($ID_ODT, "formulario_01_12");
            }


        }
        $datos_insertar = array(
            "$NOMBRE" => $VALOR
        );


        $this->model->update_FM_DP_ST_01_12($datos_insertar, $ID_ODT);
        return $this->respond(array("code" => 200, "msg" => "OK"));


    }
    public function get_01_06()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $ODT = $this->model->get_01_06($ID_ODT);
        return $this->respond($ODT);

    }
    public function get_01_12()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $ODT = $this->model->get_01_12($ID_ODT);
        if (empty($ODT)) {
            $datos_formulario = array(
                "ID_ODT" => $ID_ODT
            );
            $this->model->insertar_formulario_01_12($datos_formulario);
        }
        return $this->respond($ODT);

    }
    public function get_04_01()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $ODT = $this->model->get_04_01($ID_ODT);
        if (empty($ODT)) {
            $datos_formulario = array(
                "ID_ODT" => $ID_ODT
            );
            $this->model->insertar_formulario_04_01($datos_formulario);
        }
        return $this->respond($ODT);

    }
    public function insert_01_12()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $datos_formulario = array(
            "ID_ODT" => $ID_ODT
        );
        $this->model->insertar_formulario_01_12($datos_formulario);
        return $this->respond(array("code" => 200, "msg" => "OK"));

    }
    public function update_repuestos_odt_formulario()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $ID_REPUESTO = $data->ID_REPUESTO;
        $USADO = $data->USADO;
        $datos_insertar = array(
            "USADO" => $USADO
        );
        $this->model->update_repuestos_odt($datos_insertar, $ID_ODT, $ID_REPUESTO);
        return $this->respond(array("code" => 200, "msg" => "OK"));
    }
    public function update_repuestos_proximos_formulario()
    {

        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $ID_REPUESTO = $data->ID_REPUESTO;
        $USADO = $data->USADO;

        if ($USADO <= 0) {

            if (!empty($this->model->get_repuestos_proximos($ID_ODT, $ID_REPUESTO))) {
                $this->model->delete_repuesto_proximo($ID_ODT, $ID_REPUESTO);
                return $this->respond(array("code" => 200, "delete" => "OK"));

            }


        } else {
            if (empty($this->model->get_repuestos_proximos($ID_ODT, $ID_REPUESTO))) {
                $datos_insertar = array(
                    "ID_ODT" => $ID_ODT,
                    "ID_REPUESTO" => $ID_REPUESTO,
                    "USADO" => $USADO
                );
                $this->model->insertar_repuestos_proximos($datos_insertar);
                return $this->respond(array("code" => 200, "insert" => "OK"));
            } else {
                $datos_editar = array(
                    "USADO" => $USADO
                );
                $this->model->update_repuestos_proximos($datos_editar, $ID_ODT, $ID_REPUESTO);
                return $this->respond(array("code" => 200, "edit" => "OK"));
            }


        }




    }
    public function listar_repuestos_proximos()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $clientes = $this->model->listar_repuestos_proximos($ID_ODT);
        return $this->respond($clientes);
    }

    public function get_01_06_pdf()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $FM = $this->model->get_01_06($ID_ODT);
        $ODT = $this->model->get_odt_id($ID_ODT);
        $EQ = $this->model->get_equipo_cliente_all($ODT[0]->CODIGO_EQUIPO, $ODT[0]->CLIENTE);
        $EQUIPO = $this->model->get_equipo_cliente($ODT[0]->CODIGO_EQUIPO, $ODT[0]->CLIENTE);
        $INGNIERO = $this->model->get_ingeniero($ODT[0]->ID_INGENIERO);
        $REPUESTOS = $this->model->listar_repuestos($ID_ODT);
        $REPUESTOSPROXIMOS = $this->model->listar_repuestos_proximos($ID_ODT);


        if (!empty($FM[0]->FOTOGRAFIA_INICIAL_UNO)) {
            $FOTOGRAFIA_INICIAL_UNO = WRITEPATH . 'uploads\\formularios\\formulario_01_06\\' . $ID_ODT . '\\' . $FM[0]->FOTOGRAFIA_INICIAL_UNO;
        } else {
            $FOTOGRAFIA_INICIAL_UNO = 0;
        }
        if (!empty($FM[0]->FOTOGRAFIA_INICIAL_DOS)) {
            $FOTOGRAFIA_INICIAL_DOS = WRITEPATH . 'uploads\\formularios\\formulario_01_06\\' . $ID_ODT . '\\' . $FM[0]->FOTOGRAFIA_INICIAL_DOS;
        } else {
            $FOTOGRAFIA_INICIAL_DOS = 0;
        }
        if (!empty($FM[0]->FOTO_FINAL)) {
            $FOTO_FINAL = WRITEPATH . 'uploads\\formularios\\formulario_01_06\\' . $ID_ODT . '\\' . $FM[0]->FOTO_FINAL;
        } else {
            $FOTO_FINAL = 0;
        }
        if (!empty($FM[0]->FOTO_FINAL_DOS)) {
            $FOTO_FINAL_DOS = WRITEPATH . 'uploads\\formularios\\formulario_01_06\\' . $ID_ODT . '\\' . $FM[0]->FOTO_FINAL_DOS;

        } else {
            $FOTO_FINAL_DOS = 0;
        }

        if (!empty($FM[0]->FIRMA_QUIEN_REALIZA)) {
            $base64_image = $FM[0]->FIRMA_QUIEN_REALIZA;
            $data = explode(',', $base64_image);
            $base64_data = $data[1];
            $decoded_image = base64_decode($base64_data);

            // Guardar la imagen en un archivo
            $filename = "FIRMA_QUIEN_REALIZA.png";
            file_put_contents($filename, $decoded_image);
        }
        if (!empty($FM[0]->FIRMA_CLIENTE)) {
            $base64_image2 = $FM[0]->FIRMA_CLIENTE;
            $data = explode(',', $base64_image2);
            $base64_data = $data[1];
            $decoded_image = base64_decode($base64_data);

            // Guardar la imagen en un archivo
            $filename2 = "FIRMA_CLIENTE.png";
            file_put_contents($filename2, $decoded_image);
        }
        if (!empty($FM[0]->FIRMA_CLIENTE_DOS)) {
            $base64_image3 = $FM[0]->FIRMA_CLIENTE_DOS;
            $data = explode(',', $base64_image3);
            $base64_data = $data[1];
            $decoded_image = base64_decode($base64_data);

            // Guardar la imagen en un archivo
            $filename3 = "FIRMA_CLIENTE_DOS.png";
            file_put_contents($filename3, $decoded_image);
        }

        // Crea una instancia de TCPDF
        $pdf = new TempletePdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetMargins(10, 35, 10);


        // Agrega una página al PDF
        $pdf->AddPage();
        /* 
        fuentes 
        Montserrat-Regular.ttf added as montserrat
        Montserrat-Black.ttf added as montserratblack
        Montserrat-BlackItalic.ttf added as montserratblacki
        Montserrat-Bold.ttf added as montserratb
        Montserrat-BoldItalic.ttf added as montserratbi
        Montserrat-ExtraBold.ttf added as montserratextrab
        Montserrat-ExtraBoldItalic.ttf added as montserratextrabi
        Montserrat-ExtraLight.ttf added as montserratextralight
        Montserrat-ExtraLightItalic.ttf added as montserratextralighti
        Montserrat-Italic.ttf added as montserrati
        Montserrat-Light.ttf added as montserratlight
        Montserrat-LightItalic.ttf added as montserratlighti
        Montserrat-Medium.ttf added as montserratmedium
        Montserrat-MediumItalic.ttf added as montserratmediumi
        Montserrat-SemiBold.ttf added as montserratsemib
        Montserrat-SemiBoldItalic.ttf added as montserratsemibi
        Montserrat-Thin.ttf added as montserratthin
        Montserrat-ThinItalic.ttf added as montserratthini
        codigo para importar php C:/xampp/htdocs/hefesto-back/app/ThirdParty/tcpdf/tools/tcpdf_addfont.php -i C:/xampp/htdocs/hefesto-back/writable/Montserrat/Montserrat-ThinItalic.ttf
        
        */



        $timestamp = strtotime($FM[0]->FECHA_INICIO);
        $fechaInicio = date("Y-m-d H:i:s", $timestamp);
        $timestamp = strtotime($FM[0]->FECHA_FIN);
        $fechaFin = date("Y-m-d H:i:s", $timestamp);

        $html = "
        <!DOCTYPE html>
        <html lang=\"es\">
        <head>
                    <style>
                          body{
                            font-family: montserrat;
                            font-size: 12px;
                          }
                            h1 {
                                font-size: 2em;
                                text-align: center;
                            }

                            table {
                                
                            width: 100%;
                            border-collapse: collapse;
                           
                           
                            }
                            th,
                            td {
                                border-bottom: 0.5px solid #c5c5c5;
                                padding: 5px;
                                width: 50%;
                                /* Establece el ancho al 50% para cada columna */
                            }

                            th {
                                text-align: center;
                            }

                            td img {
                                width: 100px;
                            }
                            hr{
                                margin-top: 0px !important;
                                padding-top: 0px !important;
                                margin-bottom: 0px !important;
                                padding-bottom: 0px !important;
                            }
                            p {
                                margin-top: -50px !important;
                                padding-top: -50px !important;
                            }
                            h4{
                            text-align: center;
                            }
                            h5{
                                font-size: 8px  !important; 
                                color: #808080; /* Gris */
                                text-shadow: 1px 1px 2px #c0c0c0; /* Sobreado */
                            }
                            
                           
                    
                        
                        
                    </style>

        </head>
        <body>    
        <h5 class='texto-izquierda'>Formulario No FM-DP-ST-01-06 V.9</h5>
        <h4><b>INFORME DE SERVICIO TÉCNICO N°: " . $ODT[0]->ID_ODT . " </b></h4>
        <hr>
        <div>
        <b>CLIENTE: </b> " . $ODT[0]->RAZON_SOCIAL . "<br>
        <b>DIRECCIÓN: </b>" . $EQ[0]->DIRECCION . "<br>
        <b>CIUDAD: </b>" . $EQ[0]->CIUDAD . "<br>           
        <b>SUCURSAL: </b>" . $EQ[0]->SUCURSAL . ' ' . $EQ[0]->DEPENDENCIA . "<br>
        <b>DEPENDENCIA: </b>" . $EQ[0]->SUCURSAL . ' ' . $EQ[0]->DEPENDENCIA . "
        </div>
        <br>
        <table>
            <tr>
                <th>Fecha Y Hora De Inicio</th>
                <td>" . $fechaInicio . "</td>
            </tr>
            <tr>
                <th>Identificación Del Equipo</th>
                <td>" . $EQUIPO[0]->CODIGO_EQUIPO . "</td>
            </tr>
            <tr>
                <th>Equipo</th>
                <td>" . $EQUIPO[0]->EQUIPO . "</td>
            </tr>
            <tr>
                <th>Marca</th>
                <td>" . $EQUIPO[0]->MARCA . "</td>
            </tr>
            <tr>
                <th>Modelo</th>
                <td>" . $EQUIPO[0]->MODELO . "</td>
            </tr>
            <tr>
                <th>Serie</th>
                <td>" . $EQUIPO[0]->SERIE . "</td>
            </tr>
            <tr>
                <th>Tipo De Servicio</th>
                <td>" . $ODT[0]->TIPO_SERVICIO . "</td>
            </tr>
            <tr>
                <th>Problema Presentado:</th>
                <td>" . $FM[0]->PROBLEAMA_PRESENTADO . "</td>
            </tr>
           ";

        if (!empty($FM[0]->FOTOGRAFIA_INICIAL_UNO)) {

            $html2 = " 
            <tr>
                <th>¿Desea tomar fotografía?</th>
                <td>Si</td>
            </tr>
            <tr>
                 <th> FOTOGRAFIA ESTADO INICIAL</th>
                 <td>    
                 <img src=\"" . $FOTOGRAFIA_INICIAL_UNO . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
                 </td>
             </tr>";

        } else {
            $html2 = "";

        }
        if (!empty($FM[0]->FOTOGRAFIA_INICIAL_DOS)) {
            $html3 = "
            <tr>
                <th>Desea tomar una segunda fotografía?</th>
                <td>Si</td>
            </tr>
            <tr>
               <th>FOTOGRAFIA 2 ESTADO INICIAL</th>
               <td>
               <img src=\"" . $FOTOGRAFIA_INICIAL_DOS . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
               </td>
           </tr>";

        } else {
            $html3 = "";

        }
        $html5 = " <tr>
                <th>Trabajos Realizados:</th>              
                <td>" . $FM[0]->TRABAJOS_REALIZADOS_TEXT . " , " . $FM[0]->TRABAJOS_REALIZADOS . "</td>
            </tr>
            <tr>
                 <th> <b>Lista De Chequeo Revisión Final</b> <br></th>              
                 <td></td>
             </tr>
             <tr>
                <th>1. Rutina de autodiagnóstico sin errores</th>              
                <td>" . $FM[0]->RUTINA_AUTODIAGNOSTICO . "</td>
             </tr>
             <tr>
                <th>2. Pruebas de funciones del instrumento</th>              
                <td>" . $FM[0]->PRUEBAS_FUNCIONAMIENTO . "</td>
             </tr>
             <tr>
                <th>3. Pruebas de verificación</th>              
                <td>" . $FM[0]->PRUEBAS_VEFIRICACION . "</td>
             </tr>      
             <tr>
                <th>Verificación Realizada:</th>              
                 <td>" . $FM[0]->VERIFICACION_REALIZADA . "</td>
            </tr>                
             <tr>
                 <th>Observaciones:</th>              
                 <td>" . $FM[0]->OBSERVACIONES . "</td>
             </tr>         
             <tr> 
                 <th>Repuestos Reemplazados: </th>              
                 <td>
                  <ul> ";


        $html6 = "";
        if (empty($REPUESTOS)) {
            $html6 = "<li> No aplica </li>";
        } else {
            foreach ($REPUESTOS as $repuesto) {
                $html6 .= "<li>" . $repuesto->CODIGO_REPUESTO . "," . $repuesto->DESCRIPCION_REPUESTO . ", Cantidad : " . $repuesto->USADO . "</li>";
            }

        }



        $html7 = "</ul>
                 </td>
             </tr>
             <tr>

                <th>Repuestos Que Se Deben Reemplazar En El Próximo Mantenimiento:
                </th>  
               
               
                <td>
                <ul> ";

        $html8 = "";
        if (empty($REPUESTOSPROXIMOS)) {
            $html8 = "<li> No aplica </li>";
        } else {
            foreach ($REPUESTOSPROXIMOS as $repuesto) {
                $html8 .= "<li>" . $repuesto->CODIGO_REPUESTO . "," . $repuesto->DESCRIPCION_REPUESTO . ", Cantidad : " . $repuesto->USADO . "</li>";
            }
        }

        $html9 = "
                </ul>
                </td>
            </tr>
             
            
              <tr>
                 <th>Estado En Que Queda El Equipo Después De Este Servicio:</th>              
                 <td>" . $FM[0]->ESTADO_EN_QUE_QUEDA . "</td>
              </tr>
              <tr>
                 <th>Tiempo De Servicio (Horas):</th>              
                 <td>" . $FM[0]->TIEMPO_SERVICIO . "</td>
              </tr>";
        if (!empty($FM[0]->FOTO_FINAL)) {

            $html10 = "
                <tr>
                    <th>Fotografía Estado Final:</th>              
                    <td><img src=\"" . $FOTO_FINAL . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\"></td>
                </tr>";

        } else {
            $html10 = "";
        }

        if (!empty($FM[0]->FOTO_FINAL_DOS)) {
            $html11 = "

              <tr>
                 <th>Fotografía 2 Estado Final:</th>              
                 <td><img src=\"" . $FOTO_FINAL_DOS . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\"></td>
              </tr>";
        } else {
            $html11 = "";
        }
        $html12 = "<tr>
                 <th>Trabajo Realizado Por:</th>              
                 <td>" . $INGNIERO[0]->NOMBRES . "</td>
              </tr>

              <tr>
                 <th>Firma:</th>
                 <td>
                 <img src=\"" . $filename . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
                 </td>
              </tr>
               <tr>
                 <th>Fecha Y Hora De Finalización:</th>              
                 <td>" . $fechaFin . "</td>
              </tr>
              <tr>
                <th><b>Revisión Por El Cliente:</b> El cliente certifica haber recibido los trabajos descritos en este informe a entera satisfacción.

                </th>              
                <td>SI</td>
              </tr>";
        if ($FM[0]->NOMBRE_CLEINTE == 'Otro') {

            $html13 = "
            <tr>
                <th>Nombre Del Cliente: </th>              
                <td>" . $FM[0]->NOMBRE_CLIENTE_UNO_OTRO . "</td>
            </tr>
            <tr>
                <th>FIRMA:</th>              
                <td> 
                    <img src=\"" . $filename2 . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
                </td>
            </tr>";

        } else {
            $html13 = "
            <tr>
                <th>Nombre Del Cliente: </th>              
                <td>" . $FM[0]->NOMBRE_CLEINTE . "</td>
            </tr>
            <tr>
                <th>FIRMA:</th>              
                <td> 
                    <img src=\"" . $filename2 . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
                </td>
            </tr>";

        }
        if ($FM[0]->NOMBRE_CLIENTE_DOS == 'NO') {
            $html14 = "";
        } else {
            if ($FM[0]->NOMBRE_CLIENTE_DOS == 'Otro') {
                $html14 = "<tr>
                <th>Requiere una segunda firma del cliente?</th>              
                    <td>" . $FM[0]->NOMBRE_CLIENTE_DOS_OTRO . "</td>
                </tr>
    
                <tr>
                        <th>FIRMA:</th>              
                        <td> 
                        <img src=\"" . $filename3 . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
                        </td>
                </tr>";

            } else {
                $html14 = "<tr>
                <th>Requiere una segunda firma del cliente?</th>    
                 <td>" . $FM[0]->NOMBRE_CLIENTE_DOS . "</td>          
                 
                </tr>
    
                <tr>
                        <th>FIRMA:</th>              
                        <td> 
                        <img src=\"" . $filename3 . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
                        </td>
                </tr>";

            }

        }





        $html15 = "</table>
        <p> FIN DE DOCUMENTO<P>
        </body>
        </html>
        ";

        $html_final = $html . $html2 . $html3 . $html5 . $html6 . $html7 . $html8 . $html9 . $html10 . $html11 . $html12 . $html13 . $html14 . $html15;

        // Agrega un texto al PDF
        $pdf->writeHTML($html_final, true, false, true, false, '');

        // Obtiene el contenido binario del PDF
        $pdfContent = $pdf->Output('mi_primer_pdf.pdf', 'S');
        $filePath = WRITEPATH . 'uploads/formularios/formulario_01_06/' . $ID_ODT . '/FORMULARIO_' . $ID_ODT . '.PDF';

        file_put_contents($filePath, $pdfContent);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=mi_primer_pdf.pdf');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        $longitud = count($EQ);
        $correos = $ODT[0]->PERSONA_ENCARGADA;
        $datos_insertar = array(
            "NOMBRE" => '/FORMULARIO_' . $ID_ODT,
            "ESTADO_ODT" => 2,

        );
        $this->model->update_odt_nombre_formulario($datos_insertar, $ID_ODT); // EDITA EL NOMBRE DEL ARCHIVO

        $this->envio_correo_INFORME($ID_ODT, $ODT[0]->RAZON_SOCIAL, $correos);
        return $this->respond(array("code" => 200, "msg" => $correos));


    }
    public function get_01_12_pdf()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $FM = $this->model->get_01_12($ID_ODT);
        $ODT = $this->model->get_odt_id($ID_ODT);
        $EQ = $this->model->get_equipo_cliente_all($ODT[0]->CODIGO_EQUIPO, $ODT[0]->CLIENTE);
        $EQUIPO = $this->model->get_equipo_cliente($ODT[0]->CODIGO_EQUIPO, $ODT[0]->CLIENTE);
        $INGNIERO = $this->model->get_ingeniero($ODT[0]->ID_INGENIERO);


        if (!empty($FM[0]->FOTO_UNO)) {
            $FOTOGRAFIA_INICIAL_UNO = WRITEPATH . 'uploads\\formularios\\formulario_01_12\\' . $ID_ODT . '\\' . $FM[0]->FOTO_UNO;
        }

        if (!empty($FM[0]->FOTO_DOS)) {
            $FOTOGRAFIA_INICIAL_DOS = WRITEPATH . 'uploads\\formularios\\formulario_01_12\\' . $ID_ODT . '\\' . $FM[0]->FOTO_DOS;
        }



        if (!empty($FM[0]->FIRMA_QUIEN_REALIZO)) {
            $base64_image = $FM[0]->FIRMA_QUIEN_REALIZO;
            $data = explode(',', $base64_image);
            $base64_data = $data[1];
            $decoded_image = base64_decode($base64_data);

            // Guardar la imagen en un archivo
            $filename = "FIRMA_QUIEN_REALIZA.png";
            file_put_contents($filename, $decoded_image);
        }
        if (!empty($FM[0]->FIRMA_QUIEN_RECIBE)) {
            $base64_image2 = $FM[0]->FIRMA_QUIEN_RECIBE;
            $data = explode(',', $base64_image2);
            $base64_data = $data[1];
            $decoded_image = base64_decode($base64_data);

            // Guardar la imagen en un archivo
            $filename2 = "FIRMA_CLIENTE.png";
            file_put_contents($filename2, $decoded_image);
        }


        // Crea una instancia de TCPDF
        $pdf = new TempletePdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetMargins(10, 35, 10);


        // Agrega una página al PDF
        $pdf->AddPage();
        /* 
        fuentes 
        Montserrat-Regular.ttf added as montserrat
        Montserrat-Black.ttf added as montserratblack
        Montserrat-BlackItalic.ttf added as montserratblacki
        Montserrat-Bold.ttf added as montserratb
        Montserrat-BoldItalic.ttf added as montserratbi
        Montserrat-ExtraBold.ttf added as montserratextrab
        Montserrat-ExtraBoldItalic.ttf added as montserratextrabi
        Montserrat-ExtraLight.ttf added as montserratextralight
        Montserrat-ExtraLightItalic.ttf added as montserratextralighti
        Montserrat-Italic.ttf added as montserrati
        Montserrat-Light.ttf added as montserratlight
        Montserrat-LightItalic.ttf added as montserratlighti
        Montserrat-Medium.ttf added as montserratmedium
        Montserrat-MediumItalic.ttf added as montserratmediumi
        Montserrat-SemiBold.ttf added as montserratsemib
        Montserrat-SemiBoldItalic.ttf added as montserratsemibi
        Montserrat-Thin.ttf added as montserratthin
        Montserrat-ThinItalic.ttf added as montserratthini
        codigo para importar php C:/xampp/htdocs/hefesto-back/app/ThirdParty/tcpdf/tools/tcpdf_addfont.php -i C:/xampp/htdocs/hefesto-back/writable/Montserrat/Montserrat-ThinItalic.ttf
        
        */
        $timestamp = strtotime($FM[0]->FECHA);
        $fechaInicio = date("Y-m-d H:i:s", $timestamp);

        $html = "
        <!DOCTYPE html>
        <html lang=\"es\">
        <head>
                    <style>
                          body{
                            font-family: montserrat;
                            font-size: 12px;
                          }
                            h1 {
                                font-size: 2em;
                                text-align: center;
                            }

                            table {
                                
                            width: 100%;
                            border-collapse: collapse;
                           
                           
                            }
                            th,
                            td {
                                border-bottom: 0.5px solid #c5c5c5;
                                padding: 5px;
                                width: 50%;
                                /* Establece el ancho al 50% para cada columna */
                            }

                            th {
                                text-align: center;
                            }

                            td img {
                                width: 100px;
                            }
                            hr{
                                margin-top: 0px !important;
                                padding-top: 0px !important;
                                margin-bottom: 0px !important;
                                padding-bottom: 0px !important;
                            }
                            p {
                                margin-top: -50px !important;
                                padding-top: -50px !important;
                            }
                            h4{
                            text-align: center;
                            }
                            h5{
                                font-size: 8px  !important; 
                                color: #808080; /* Gris */
                                text-shadow: 1px 1px 2px #c0c0c0; /* Sobreado */
                            }
                            

                        
                        
                    </style>

        </head>
        <body>   
        <h5 class='texto-izquierda'>FM-DP-ST-01-12 REGISTRO REVISION EQUIPOS V.5  </h5> 
        <h4>INFORME DE SERVICIO TÉCNICO N°: " . $ODT[0]->ID_ODT . "</h4>
        <hr>
        <div>
        <b>CLIENTE: </b> " . $ODT[0]->RAZON_SOCIAL . "<br>
        <b>DIRECCIÓN: </b>" . $EQ[0]->DIRECCION . "<br>
        <b>CIUDAD: </b>" . $EQ[0]->CIUDAD . "<br>           
        <b>SUCURSAL: </b>" . $EQ[0]->SUCURSAL . ' ' . $EQ[0]->DEPENDENCIA . "<br>
        <b>DEPENDENCIA: </b>" . $EQ[0]->SUCURSAL . ' ' . $EQ[0]->DEPENDENCIA . "
        </div>
        <br>
        <table>
            <tr>
                <th>Fecha Y Hora De Inicio</th>
                <td>" . $fechaInicio . "</td>
            </tr>
            <tr>
                <th>Identificación Del Equipo</th>
                <td>" . $EQUIPO[0]->CODIGO_EQUIPO . "</td>
            </tr>
            <tr>
                <th>Equipo</th>
                <td>" . $EQUIPO[0]->EQUIPO . "</td>
            </tr>
            <tr>
                <th>Marca</th>
                <td>" . $EQUIPO[0]->MARCA . "</td>
            </tr>
            <tr>
                <th>Modelo</th>
                <td>" . $EQUIPO[0]->MODELO . "</td>
            </tr>
            <tr>
                <th>Serie</th>
                <td>" . $EQUIPO[0]->SERIE . "</td>
            </tr>
            <tr>
                <th>Tipo De Servicio</th>
                <td>" . $ODT[0]->TIPO_SERVICIO . "</td>
            </tr>
            
      
            <tr>
                 <th>Inspección física<br></th>              
                 <td></td>
             </tr>
             <tr>
                <th>1.1 Empaque en buen estado</th>              
                <td>" . $FM[0]->EMPAQUES . "</td>
             </tr>
             <tr>
                <th>1.2 Estado externo del equipo: Libre de golpes, roturas</th>              
                <td>" . $FM[0]->ESTADO_EXTERNO . "</td>
             </tr>
             <tr>
                <th>1.3 Partes y accesorios en buen estado</th>              
                <td>" . $FM[0]->PARTES_ACCESORIOS . "</td>
             </tr>
             <tr>
                 <th>Revisión de partes de instalación<br></th>              
                 <td></td>
              </tr>
            <tr>
               <th>2.1 El equipo trae su manual de operación</th>              
              <td>" . $FM[0]->MANUAL . "</td>
            </tr>
            <tr>
                <th>2.2 Las partes y accesorios corresponde a la lista de empaque, o a lo descrito en el manual como elementos básicos</th>              
               <td>" . $FM[0]->PARTES_ACCESORIOS_OK . "</td>
            </tr>
            <tr>
              <th>2.3 Adaptación eléctrica apropiada para su instalación donde el cliente.(Realizar las adaptaciones eléctricas que se requieran)</th>              
              <td>" . $FM[0]->ADAPTACION_ELECTRICA . "</td>
             </tr>
             <tr>
             <th>Pruebas funcionales<br></th>              
             <td></td>
              </tr>
            <tr>
               <th>3.1 Autodiagnóstico de encendido sin mensajes de error</th>              
              <td>" . $FM[0]->AUTODIAGNOSTICO . "</td>
            </tr>
            <tr>
                <th>3.2 Integridad de display o de indicadores alfanumérico</th>              
               <td>" . $FM[0]->INTEGRIDAD_DISPLAY . "</td>
            </tr>
            <tr>
              <th>3.3 Pruebas de funcionamiento electromecánico</th>              
              <td>" . $FM[0]->PRUEBAS_FUNCIONAMIENTO . "</td>
             </tr>

            
             <tr>
                 <th>Observaciones:</th>              
                 <td>" . $FM[0]->OBSERVACIONES . "</td>
             </tr>";

        if (!empty($FM[0]->FOTO_UNO)) {

            $html2 = " 
            <tr>
                <th>Fotografía #1 </th>
             <td>    
             <img src=\"" . $FOTOGRAFIA_INICIAL_UNO . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
             </td>
         </tr>";

        } else {
            $html2 = "";

        }

        if (!empty($FM[0]->FOTO_DOS)) {

            $html3 = " <tr>
                <th>Fotografía #2 </th>
             <td>    
             <img src=\"" . $FOTOGRAFIA_INICIAL_DOS . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
             </td>
         </tr>";

        } else {
            $html3 = "";

        }


        $html4 = "    
              <tr>
                 <th>TRABAJO REALIZADO POR:</th>              
                 <td>" . $INGNIERO[0]->NOMBRES . "</td>
              </tr>

              <tr>
                 <th>FIRMA:</th>
                 <td>
                 <img src=\"" . $filename . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
                 </td>
              </tr>
           
              <tr>
                <th>REVISIÓN POR : certifica haber recibido los trabajos descritos en este informe a
                entera satisfacción.</th>              
                <td>SI</td>
              </tr>
              <tr>
                  <th>Recibido por:</th>              
                  <td>" . $FM[0]->RECIBIDO . "</td>
             </tr>
             <tr>
             <th>Firma:</th>
             <td>
             <img src=\"" . $filename2 . "\" width=\"200\" height=\"100\" alt=\"Descripción de la imagen\">
             </td>
          </tr>
   
           
          
          
        </table>
        <p> FIN DE DOCUMENTO</p>
        </body>
        </html>
        ";

        $html_final = $html . $html2 . $html3 . $html4;

        // Agrega un texto al PDF
        $pdf->writeHTML($html_final, true, false, true, false, '');


        // Obtiene el contenido binario del PDF
        $pdfContent = $pdf->Output('mi_primer_pdf.pdf', 'S');
        $filePath = WRITEPATH . 'uploads/formularios/formulario_01_12/' . $ID_ODT . '/FORMULARIO_' . $ID_ODT . '.PDF';

        file_put_contents($filePath, $pdfContent);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=mi_primer_pdf.pdf');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        $longitud = count($EQ);
        $correos = $ODT[0]->PERSONA_ENCARGADA;
        $datos_EDITAR = array(
            "ESTADO_ODT" => 2,
        );
        
        $this->model->update_odt_estado($datos_EDITAR, $ID_ODT);
        $this->envio_correo_INFORME($ID_ODT, $ODT[0]->RAZON_SOCIAL, $correos);
        return $this->respond(array("code" => 200, "msg" => $correos));
    }

    function envio_correo_INFORME($ID_ODT, $cliente, $correos)
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
                                                                ' . $cliente . ' </span>
                                                        </td>
                                                        
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
                                                            <p>Cordial Saludo,
                                                                    <br>
 

                                                            Adjunto encontrará el soporte del servicio realizado. informe No ' . $cliente . '
                                                            
                                                            <br>
                                                            
                                                            Para nosotros es muy importante conocer la calidad del servicio prestado. Lo invitamos a responder la siguiente encuesta de satisfacción. que solo le tomará un minuto de su tiempo y nos ayudará en nuestra mejora continua:  
                                                            
                                                            <br>
                                                            
                                                            Para responder dar click en el siguiente enlace:
                                                            <br>
                                                            <a href="https://forms.monday.com/forms/b7f86208f0d02639186faddb43f67f5e?r=use1" target="_blank"
                                                                rel="noopener noreferrer" data-auth="NotApplicable"
                                                                class="x_links"
                                                                style="color:#4b79f4; text-decoration:underline"
                                                                data-safelink="true" data-linkindex="1">ENCUESTA </a>
                                                            
                                                            <br>
                                                            Quedo atenta a cualquier inquietud.
                                                            
                                                            <br> <br>
                                                            
                                                            Muchas gracias.
                                                            </p>
    
                                                           
                                                           
                                                            <p>Hefesto</p>
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
                                                            <p><strong>Este es un mensaje automatico – por favor no
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


        $attachmentPath = WRITEPATH . 'uploads/formularios/formulario_01_06/' . $ID_ODT . '/FORMULARIO_' . $ID_ODT . '.PDF'; //aca fue
        $email = \Config\Services::email();
        $email->setFrom('notificaciones@quimitronica.com', 'QUIMITRONICA');
        $email->setTo($correos);
        $email->setSubject('INFORME DE SERVICIO QUIMITRONICA SAS');
        $email->setMessage($mensaje);
        $email->attach($attachmentPath);
        $email->send();

    }

    function archivo_formulario_06($ID_ODT = null, $NOMBRE = null)
    {
        // abre el archivo en modo binario
        if (!$ID_ODT) { // $movieId== null
            $ID_ODT = $this->request->getGet('ID_ODT');
        }
        if (!$NOMBRE) { // $image== null
            $NOMBRE = $this->request->getGet('NOMBRE');
        }

        if ($ID_ODT == '' || $NOMBRE == '') {

        }
        $name = WRITEPATH . 'uploads/formularios/formulario_01_06/' . $ID_ODT . '/' . $NOMBRE . '.PDF';
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

    function archivo_formulario_12($ID_ODT = null, $NOMBRE = null)
    {
        // abre el archivo en modo binario
        if (!$ID_ODT) { // $movieId== null
            $ID_ODT = $this->request->getGet('ID_ODT');
        }
        if (!$NOMBRE) { // $image== null
            $NOMBRE = $this->request->getGet('NOMBRE');
        }

        if ($ID_ODT == '' || $NOMBRE == '') {

        }
        $name = WRITEPATH . 'uploads/formularios/formulario_01_12/' . $ID_ODT . '/' . $NOMBRE . '.PDF';
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
    function get_odt_id()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_ODT = $data->ID_ODT;
        $USER = $this->model->get_odt_id($ID_ODT);

        return $this->respond($USER);

    }
    function get_equipo_cliente_all()
    {
        $data = json_decode(file_get_contents("php://input"));
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $NIT_CLIENTE = $data->NIT_CLIENTE;
        $equipo = $this->model->get_equipo_cliente_all($CODIGO_EQUIPO, $NIT_CLIENTE);
        return $this->respond($equipo);
    }

    function get_formulario_01_06()
    {
        $data = json_decode(file_get_contents("php://input"));
        $ID_FORMULARIO = $data->ID_FORMULARIO;
        $ID_SERVICIO = $data->ID_SERVICIO;
        $USER = $this->model->get_formulario__01_06($ID_FORMULARIO, $ID_SERVICIO);
        return $this->respond($USER);
    }
    public function archivo_subir_formulario_01_06($id, $carpeta)
    {

        if ($ADJUNTO = $this->request->getfile('VALOR')) {

            if ($ADJUNTO->isvalid() && !$ADJUNTO->hasMoved()) {

                $newName = $ADJUNTO->getRandomName();
                $ADJUNTO->move(WRITEPATH . 'uploads/formularios/' . $carpeta . '/' . $id, $newName);
                return $newName;

            }

        }


    }
    public function archivo_subir_formulario_01_12($id, $carpeta)
    {

        if ($ADJUNTO = $this->request->getfile('VALOR')) {

            if ($ADJUNTO->isvalid() && !$ADJUNTO->hasMoved()) {

                $newName = $ADJUNTO->getRandomName();
                $ADJUNTO->move(WRITEPATH . 'uploads/formularios/' . $carpeta . '/' . $id, $newName);
                return $newName;

            }

        }


    }
    function get_equipo_cliente()
    {
        $data = json_decode(file_get_contents("php://input"));
        $CODIGO_EQUIPO = $data->CODIGO_EQUIPO;
        $NIT_CLIENTE = $data->NIT_CLIENTE;
        $USER = $this->model->get_equipo_cliente($CODIGO_EQUIPO, $NIT_CLIENTE);
        if (count($USER) > 0) {
            return $this->respond(array("code" => 200, "data" => $USER));
        } else {
            return $this->respond(array("code" => 400));
        }
    }

    public function obtenerImagen_formulario_01_06($ID_ODT = null, $NOMBRE = null)
    {
        $ID_ODT = $this->request->getGet('ID_ODT');
        $NOMBRE = $this->request->getGet('NOMBRE');
        // Ruta al directorio de imágenes
        $rutaImagenes = WRITEPATH . 'uploads/formularios/formulario_01_06/' . $ID_ODT . '/';
        $name = $rutaImagenes . $NOMBRE;
        $fp = fopen($name, 'rb');
        // envía las cabeceras correctas
        header("Content-type:image/png");
        header("Content-Length: " . filesize($name));
        // vuelca la imagen y detiene el script
        fpassthru($fp);
        exit;

    }
    public function obtenerImagen_formulario_01_12($ID_ODT = null, $NOMBRE = null)
    {
        $ID_ODT = $this->request->getGet('ID_ODT');
        $NOMBRE = $this->request->getGet('NOMBRE');
        // Ruta al directorio de imágenes
        $rutaImagenes = WRITEPATH . 'uploads/formularios/formulario_01_12/' . $ID_ODT . '/';
        $name = $rutaImagenes . $NOMBRE;
        $fp = fopen($name, 'rb');
        // envía las cabeceras correctas
        header("Content-type:image/png");
        header("Content-Length: " . filesize($name));
        // vuelca la imagen y detiene el script
        fpassthru($fp);
        exit;

    }
    function archivo_formulario_01_06($ID_INGENIERO = null, $ADJUNTO = null)
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



}

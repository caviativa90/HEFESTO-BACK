<?php
namespace App\Libraries;

use TCPDF;

class TempletePdf extends TCPDF
{

    //Page header
    public function Header()
    {
        // Logo
        $image_file = K_PATH_IMAGES . 'tcpdf_logo3.jpg';
        $this->Image($image_file, 0, 0, 200, 30, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    }

    // Page footer
    public function Footer()
    {


        $image_file_2 = K_PATH_IMAGES . 'footer.jpg';
        $this->Image($image_file_2, 0, 280, 200, 20, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetY(-15);
        // Page number
        $this->SetFont('montserratbi', '', 10);

        $this->Cell(205, 10, $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, 0, false, 'M');

    }
}
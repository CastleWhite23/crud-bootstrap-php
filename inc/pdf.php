<?php 
require("fpdf.php");

class PDF extends FPDF
{
    private $titulo;

    // Método para definir o título
    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    //Header
    function Header(){
        $this->SetFont("Arial","B",15);
        $this->Cell(180,10, $this->titulo, 0, 1, "C");
        $this->Ln(20);
    }

    //Footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont("Arial","I",0);
        $this->Cell(0,10,'Pagina ' . $this->PageNo().  'de (nb)',0,0,'C');
    }
}

?>

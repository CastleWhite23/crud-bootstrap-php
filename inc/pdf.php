<?php
require("fpdf.php");
require('../config.php');
 
 
class PDF extends FPDF
{
    private $titulo;
 
    // Método para definir o título
    function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }
 
    // Load data
    function LoadData($file)
    {
        // Read file lines
        $lines = $file;
        $data = array();
 
       
   
        foreach ($lines as $line){
           
            $new_line= array($line['id'], $line['nome'], $line['user'], $line['foto']);
            array_push($data, $new_line);
        }
       
       
        return $data;
    }
 
    // Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach ($header as $col)
            $this->Cell(50, 20, $col, 0);
        $this->Ln();
        
        // Data
        foreach ($data as $row) {
            foreach ($row as $col){
                // Verifica se o valor da célula é um arquivo de imagem jpg
                if (pathinfo(basename($col), PATHINFO_EXTENSION) == 'jpg' || pathinfo(basename($col), PATHINFO_EXTENSION) == 'png'|| pathinfo(basename($col), PATHINFO_EXTENSION) == 'webp' ||  $col == null) {
                    // Altere o caminho da imagem para um caminho absoluto
                    
                    // Adicione a imagem à célula
                    
                    if($col == null){
                        $imagePath =  'http://' . SERVERNAME . BASEURL.  "usuarios/fotos/sem_imagem.jpg";
                    }else{
                        $imagePath = 'http://' . SERVERNAME . BASEURL.  "usuarios/fotos/". $col;
                    }
                    // Mova para a próxima célula
                    $this->Cell(40, 30, $this->Image($imagePath, $this->GetX(), $this->GetY(), 40, 20), 0);
                    
                } else {
                    // Se não for uma imagem jpg, apenas exiba o texto na célula
                    $this->Cell(50, 30, $col, 0);
                }
            }
            $this->Ln(); // Nova linha para a próxima linha de dados
        }
    }
    
    // Better table
    function ImprovedTable($header, $data)
    {
        // Column widths
        $w = array(40, 35, 40, 45);
        // Header
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
        $this->Ln();
        // Data
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR');
            $this->Cell($w[1], 6, $row[1], 'LR');
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
            $this->Ln();
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
 
    // Colored table
    function FancyTable($header, $data)
    {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = false;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Closing line
        $this->Cell(array_sum($w), 0, '', 'T');
    }
    //Header
    function Header()
    {
        $this->SetFont("Arial", "B", 15);
        $this->Cell(180, 10, $this->titulo, 0, 1, "C");
        $this->Ln(20);
    }
 
    //Footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont("Arial", "I", 8);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

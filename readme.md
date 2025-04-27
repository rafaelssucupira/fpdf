# rafaelssucupira/fpdf
API do fpdf incrementada com algumas ferramentas com Diag, Rotate, Sector, Tag encontradas em fpdf.org

> [!IMPORTANT]
> É necessário adiocionar as fontes customizadas dentro de vendor/setasign/font, Ex : Tahoma e etc...

# Traits implementados
- [x] PDF_Rotate
- [x] PDF_Sector
- [x] PDF_Diag
- [x] PDF_Tag
- [x] PDF_Table

# Exemplo
```
<?php
require_once("vendor/autoload.php");

use FPDF;
use ReportApp\PDF_Rotate;
use ReportApp\PDF_Sector;
use ReportApp\PDF_Diag;   
use ReportApp\PDF_Tag;


class PDF extends FPDF {
    use PDF_Rotate, PDF_Sector, PDF_Diag, PDF_Tag;

    function __construct() {

        parent::__construct();
    }   

    function header() {

        $this->SetFont('Arial','',20);
        $this->RotatedText(100,60,'Hello!',45);

        $data = array('Men' => 1510, 'Women' => 1610, 'Children' => 1400);

        //Pie chart
        $this->SetFont('Arial', 'BIU', 12);
        $this->Cell(0, 5, '1 - Pie chart', 0, 1);
        $this->Ln(8);

        $this->SetFont('Arial', '', 10);
        $valX = $this->GetX();
        $valY = $this->GetY();
        $this->Cell(30, 5, 'Number of men:');
        $this->Cell(15, 5, $data['Men'], 0, 0, 'R');
        $this->Ln();
        $this->Cell(30, 5, 'Number of women:');
        $this->Cell(15, 5, $data['Women'], 0, 0, 'R');
        $this->Ln();
        $this->Cell(30, 5, 'Number of children:');
        $this->Cell(15, 5, $data['Children'], 0, 0, 'R');
        $this->Ln();
        $this->Ln(8);
        
        $this->SetXY(90, $valY);
        
        $col1=array(100,100,255);
        $col2=array(255,100,100);
        $col3=array(255,255,100);
        $this->PieChart(100, 35, $data, '%l (%p)', array($col1,$col2,$col3));
        $this->SetXY($valX, $valY + 40);

        //Bar diagram
        $this->SetFont('Arial', 'BIU', 12);
        $this->Cell(0, 5, '2 - Bar diagram', 0, 1);
        $this->Ln(8);
        $valX = $this->GetX();
        $valY = $this->GetY();
        $this->BarDiagram(190, 70, $data, '%l : %v (%p)', array(255,175,100));
        $this->SetXY($valX, $valY + 80);
        
        $this->SetFont('Arial','',12);
        $text  = "Let's show... \n\n";
        $text .= " [This is a cell][and another cell]\n\n";
        $text .= "<This is a bold sentence> and another non bold sentence.";
        $this->WriteText($text);
        
    }

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->Output();

?>
```
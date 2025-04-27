<?php
require_once("vendor/autoload.php");

use FPDF;
use ReportApp\PDF_Table;
use ReportApp\PDF_Rotate;
use ReportApp\PDF_Sector;
use ReportApp\PDF_Diag;
use ReportApp\PDF_Tag;
use ReportApp\PDF_LineGraph;


class PDF extends FPDF {
    use PDF_Rotate, PDF_Sector, PDF_Diag, PDF_Tag, PDF_LineGraph, PDF_Table;
    

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

        $this->SetY(185);

        $this->SetFont('Arial','',10);
        $data = array(
            'Group 1' => array(
                'haha' => 2.7,
                '08-23' => 3.0,
                '09-13' => 3.3928571,
                '10-04' => 3.2903226,
                '10-25' => 3.1
            ),
            'Group 2' => array(
                'haha' => 2.5,
                '08-23' => 2.0,
                '09-13' => 3.1785714,
                '10-04' => 2.9677419,
                '10-25' => 3.33333
            )
        );
        $colors = array(
            'Group 1' => array(114,171,237),
            'Group 2' => array(163,36,153)
        );

   
        $this->LineGraph(190,50,$data,'VHkBvBgBdB',$colors,10,4);

        // $this->addPage();
        $this->SetY(222);
        
        $this->SetWidths(array(30, 50, 30, 40));
        for($i=0;$i<5;$i++){
            $this->Row(array("GenerateSentence()"," GenerateSentence()", "GenerateSentence()", "GenerateSentence()"));
        }

    }

}

$pdf = new PDF();
$pdf->AddPage();

$pdf->Output();

?>
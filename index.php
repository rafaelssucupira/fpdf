<?php
require_once("vendor/autoload.php");

use FPDF;
use ReportApp\PDF_Rotate;
use ReportApp\PDF_Sector;
use ReportApp\PDF_Diag;   
use ReportApp\PDF_Tag;
use ReportApp\PDF_LineGraph;


class PDF extends FPDF {
    use PDF_Rotate, PDF_Sector, PDF_Diag, PDF_Tag, PDF_LineGraph;

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

   
        // Display options: all (horizontal and vertical lines, 4 bounding boxes)
        // Colors: fixed
        // Max ordinate: 6
        // Number of divisions: 3

        // Este script permite criar gráficos baseados em linhas. O método a utilizar é o seguinte:

        // LineGraph(float w, float h, dados do array [, opções de string [, cores do array [, int maxVal [, int nbDiv]]]])

        // w: largura do gráfico
        // h: altura do gráfico
        // dados: array multidimensional contendo séries de dados
        // options: string contendo opções de exibição
        // cores: array multidimensional contendo cores de linha; se for nulo ou não fornecido, algumas cores aleatórias serão usadas
        // maxVal: ordenada máxima; se 0 ou não for fornecido, é calculado automaticamente
        // nbDiv: número de divisões verticais (valor padrão: 4)

        $this->LineGraph(190,50,$data,'VHkBvBgBdB',$colors,10,4);
        
    }

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->Output();

?>
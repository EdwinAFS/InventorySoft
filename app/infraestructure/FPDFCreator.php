<?php

namespace App\Infraestructure;

use App\Domain\PDF;
use FPDF;

require "../public/libraries/fpdf/fpdf.php";

class FPDFCreator implements PDF
{
	public $margin = 10;

	function __construct(){
		$this->FPDF = new FPDF();
		$this->FPDF->AddPage();
		$this->FPDF->SetFont('Arial','',12);
		$this->FPDF->SetMargins($this->margin, 20, $this->margin);
	}

	function Header()
	{
		$this->FPDF->Image( '../resources/logo.png', $this->margin, $this->FPDF->GetY(), 25, 25, 'png');
	}
	function Footer()
	{

	}

	function createTable(array $headers, array $rows = [])
	{

		$this->FPDF->SetLineWidth(1);
		$this->FPDF->SetDrawColor(31, 97, 141);

		$this->FPDF->SetFont('Arial', 'B', 12);

		foreach ($headers as $column) {
			$this->FPDF->Cell(38, 9, $column, 'T', 0, 'C', false);
		}

		$this->FPDF->SetDrawColor(255, 255, 255);
		$this->FPDF->SetTextColor(0, 0, 0);

		$this->FPDF->Ln(8);

		$this->FPDF->SetFont('Arial', '', 12);

		$this->FPDF->SetFillColor(255, 255, 255);

		foreach ($rows as $index => $row) {

			foreach ($row as  $column) {
				$this->FPDF->Cell(38, 9, $column, 1, 0, 'C', true);
			}
			$this->FPDF->Ln();
		}
	}

	/* Crea tarjetas de datos */
	function dataCard($title = '', $data, $key = [], $x = 0, $y = null, $distance = 30)
	{
		$this->FPDF->SetFont('Arial', '', 10);

		if (!isset($y)) {
			$y = $this->FPDF->GetY();
		}

		$this->FPDF->SetY($y);

		if (!empty($title)) {
			$this->FPDF->SetX($x);
			$this->FPDF->SetFont('Arial', 'B');
			$this->FPDF->Write(6, $title);
			$this->FPDF->Ln();
		}


		$keyPositionX = $x;
		$valuePositionX = (!empty($key)) ? $x + $distance : $x;

		foreach ($data as $i => $value) {

			if (!empty($key)) {
				$this->FPDF->SetX($keyPositionX);
				$this->FPDF->SetFont('Arial', 'B');
				$this->FPDF->Cell(30, 6, $key[$i]);
			}

			$this->FPDF->SetX($valuePositionX);
			$this->FPDF->SetFont('Arial', '');
			$this->FPDF->Cell(30, 6, $value);
			$this->FPDF->Ln();
		}
	}

	function print($txt, $width, $height, $size = 12, $style = '', $align = 'L')
	{
		$this->FPDF->SetFont('Arial', $style, $size);
		$this->FPDF->Cell($width, $height, $txt, 0, 0, $align, false);
	}

	function setX( $x ){
		$this->FPDF->setX( $x );
	}
	
	function setY( $y ){
		$this->FPDF->setY( $y );
	}
	
	function Output( $name, $destination ){
		$this->FPDF->Output( $name, $destination );
	}
	function Ln(){
		$this->FPDF->Ln();
	}

	function Line($x1, $x2, $color = [0,0,0]){
		list($r,$g, $b) = $color;
		$this->FPDF->SetDrawColor($r,$g, $b);
		$this->FPDF->Line( $x1, $this->FPDF->getY(), $x2, $this->FPDF->getY());
	}
}

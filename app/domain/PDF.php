<?php

namespace App\Domain;

interface PDF {
	public function Header();
	public function Footer();
	public function createTable(array $headers, array $rows = []);
	public function dataCard($title = '', $data, $key = [], $x = 0, $y = null, $distance = 30);
	public function print($txt, $x, $y, $size = 12, $style = '', $align = 'L');
	public function setX( $x );
	public function setY( $y );
	public function Output(  $name, $destination );
	public function Ln();

}

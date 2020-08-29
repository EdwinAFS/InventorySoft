<?php

require_once "models/Config.php";

class View
{
	function __construct(){
	}

	static public function render($name, $vars = array())
	{
		//Armamos la ruta a la plantilla
		$path = Config::get('viewsFolder') . $name;

		//Si no existe el fichero en cuestion, tiramos un 404
		if (file_exists($path) == false) {
			trigger_error('Template `' . $path . '` does not exist.', E_USER_NOTICE);
			return false;
		}

		//Si hay variables para asignar, las pasamos una a una.
		if (is_array($vars)) {
			foreach ($vars as $key => $value) {
				$$key = $value;
			}
		}

		//Finalmente, incluimos la plantilla.
		include(Config::get('viewsFolder')."html/template.php");
	}

	static public function show($name, $vars = array())
	{
		//Armamos la ruta a la plantilla
		$path = Config::get('viewsFolder') . $name;

		//Si no existe el fichero en cuestion, tiramos un 404
		if (file_exists($path) == false) {
			trigger_error('Template `' . $path . '` does not exist.', E_USER_NOTICE);
			return false;
		}

		//Si hay variables para asignar, las pasamos una a una.
		if (is_array($vars)) {
			foreach ($vars as $key => $value) {
				$$key = $value;
			}
		}

		//Finalmente, incluimos la plantilla.
		include($path);
	}

}
/*
 El uso es bastante sencillo:
 $vista = new View();
 $vista->show('listado.php', array("nombre" => "Juan"));
*/

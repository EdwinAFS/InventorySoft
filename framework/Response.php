<?php

namespace framework;

use Framework\Config;

class Response
{

	static public function render($name, $vars = array())
	{
		//Armamos la ruta a la plantilla
		$path = Config::get('views') . $name;

		//Si no existe el fichero en cuestion, tiramos un 404
		if (file_exists($path) == false) {
			trigger_error('Template `' . $path . '` does not exist.', E_USER_NOTICE);
			return false;
		}

		$screenComplete = false;

		//Si hay variables para asignar, las pasamos una a una.
		if (is_array($vars)) {
			foreach ($vars as $key => $value) {
				$$key = $value;
			}
		}

		//Finalmente, incluimos la plantilla.
		include(Config::get('templates') . "template.php");
	}

	static public function show($name, $vars = array())
	{
		//Armamos la ruta a la plantilla
		$path = Config::get('views') . $name;

		//Si no existe el fichero en cuestion, tiramos un 404
		if (file_exists($path) == false) {
			trigger_error('Template `' . $path . '` does not exist.', E_USER_NOTICE);
			return false;
		}

		$screenComplete = true;

		//Si hay variables para asignar, las pasamos una a una.
		if (is_array($vars)) {
			foreach ($vars as $key => $value) {
				$$key = $value;
			}
		}

		include(Config::get('templates') . "template.php");
	}

	static public function json($json, $httpStatus = 200)
	{
		header_remove();

		header("Content-Type: application/json");

		http_response_code($httpStatus);

		echo json_encode($json);
	}

	static public function redirect($url)
	{
		header("Location: $url");
		die();
	}
}

?>
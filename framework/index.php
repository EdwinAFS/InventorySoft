<?php

class FrontController
{
	static function run()
	{
		require 'Config.php';
		require 'Response.php';

		$controllerName = self::getNameController();
		$methodName = self::getNameMethod();

		$controllerPath = Config::get('controllers') . $controllerName . '.php';

		//Incluimos el fichero que contiene nuestra clase controladora solicitada
		if (is_file($controllerPath))
			require $controllerPath;
		else
			return Response::render("errors/404.php");

		//Si no existe la clase que buscamos y su acción, tiramos un error 404
		if (method_exists($controllerName, $methodName) == false) {

			return Response::render("errors/404.php");

			//trigger_error($controllerName . ' => ' . $methodName . ' no existe', E_USER_NOTICE);
			return false;
		}

		//Si todo esta bien, creamos una instancia del controlador y llamamos a la accion
		$controller = new $controllerName();
		$controller->$methodName();
	}

	static public function getNameController()
	{
		$controllerName = "HomeController";

		if (!empty($_GET['controller'])) {
			$controllerName = $_GET['controller'] . 'Controller';
		}

		return $controllerName;
	}

	static public function getNameMethod()
	{
		$methodName = "index";

		if (!empty($_GET['method'])) {
			$methodName = $_GET['method'];
		}

		return $methodName;
	}
}

FrontController::run();
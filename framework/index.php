<?php
if (session_id() == '') {
	session_start();
}
require 'Config.php';
require 'Response.php';
require 'Error.php';

class FrontController
{
	static function run()
	{
		// verificamos que este logueado



		$controllerName = self::getNameController();
		$methodName = self::getNameMethod();

		if (
			strtoupper($controllerName) !== strtoupper("LoginController") &&
			(!isset($_SESSION["isAuth"]) ||
				(isset($_SESSION["isAuth"]) &&
					$_SESSION["isAuth"] == false))
		) {
			return Response::show("login/login.php");
		}

		$controllerPath = Config::get('controllers') . $controllerName . '.php';

		//Incluimos el fichero que contiene nuestra clase controladora solicitada
		if (is_file($controllerPath))
			require $controllerPath;
		else
			return Response::show("errors/404.php");

		//Si no existe la clase que buscamos y su acción, tiramos un error 404
		if (method_exists($controllerName, $methodName) == false) {

			return Response::show("errors/404.php");

			trigger_error($controllerName . ' => ' . $methodName . ' no existe', E_USER_NOTICE);
			return false;
		}

		$params = [];
		$body = [];
		$method = $_SERVER['REQUEST_METHOD'];

		switch ($method) {
			case 'PUT':
				$body = json_decode(file_get_contents("php://input"), true);
				break;
			case 'POST':
				$body = $_POST;
				break;
			case 'GET':
			case 'DELETE':
				break;
			default:
				return Response::json([
					'error' => true,
					'message' => "El metodo HTTP $method es incorrecto."
				], 400);
				break;
		}

		foreach ($_GET as $key => $value) {
			if (in_array($key, ['controller', 'method'])) {
				continue;
			}
			$params[$key] = $value;
		}

		$request = (object)[
			'params' => (object) $params,
			'body' => (object) $body,
			'method' => $method
		];

		//Si todo esta bien, creamos una instancia del controlador y llamamos a la accion
		$controller = new $controllerName();
		$controller->$methodName($request);
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

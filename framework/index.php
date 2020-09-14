<?php

namespace framework;

require_once "../vendor/autoload.php";

use Framework\Config;
use Framework\Response;
use Framework\Error;

require_once "../config/config.php";

class FrontController
{
	static function run()
	{
		if (session_id() == '') {
			session_start();
		}

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

		$controllerPath = "App\\Entry_point\\controllers\\" . $controllerName;

		//Incluimos el fichero que contiene nuestra clase controladora solicitada
		if (!class_exists($controllerPath))
			return Response::show("errors/404.php");

		//Si no existe la clase que buscamos y su acción, lanzamos un error 404
		if (method_exists($controllerPath, $methodName) == false) {

			return Response::show("errors/404.php");

			trigger_error($controllerName . ' => ' . $methodName . ' no existe', E_USER_NOTICE);
			return false;
		}

		$params = [];
		$body = [];
		$method = $_SERVER['REQUEST_METHOD'];

		switch ($method) {
			case 'PUT':
				_parsePut();
				$body = $GLOBALS['_PUT'];
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
		$controller = new $controllerPath();
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


function _parsePut()
{
	global $_PUT;

	/* PUT data comes in on the stdin stream */
	$putdata = fopen("php://input", "r");

	/* Open a file for writing */
	// $fp = fopen("myputfile.ext", "w");

	$raw_data = '';

	/* Read the data 1 KB at a time
       and write to the file */
	while ($chunk = fread($putdata, 1024))
		$raw_data .= $chunk;

	/* Close the streams */
	fclose($putdata);

	// Fetch content and determine boundary
	$boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

	if (empty($boundary)) {
		parse_str($raw_data, $data);
		$GLOBALS['_PUT'] = $data;
		return;
	}

	// Fetch each part
	$parts = array_slice(explode($boundary, $raw_data), 1);
	$data = array();

	foreach ($parts as $part) {
		// If this is the last part, break
		if ($part == "--\r\n") break;

		// Separate content from headers
		$part = ltrim($part, "\r\n");
		list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

		// Parse the headers list
		$raw_headers = explode("\r\n", $raw_headers);
		$headers = array();
		foreach ($raw_headers as $header) {
			list($name, $value) = explode(':', $header);
			$headers[strtolower($name)] = ltrim($value, ' ');
		}

		// Parse the Content-Disposition to get the field name, etc.
		if (isset($headers['content-disposition'])) {
			$filename = null;
			$tmp_name = null;
			preg_match(
				'/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
				$headers['content-disposition'],
				$matches
			);
			list(, $type, $name) = $matches;

			//Parse File
			if (isset($matches[4])) {
				//if labeled the same as previous, skip
				if (isset($_FILES[$matches[2]])) {
					continue;
				}

				//get filename
				$filename = $matches[4];

				//get tmp name
				$filename_parts = pathinfo($filename);
				$tmp_name = tempnam(ini_get('upload_tmp_dir'), $filename_parts['filename']);

				//populate $_FILES with information, size may be off in multibyte situation
				$_FILES[$matches[2]] = array(
					'error' => 0,
					'name' => $filename,
					'tmp_name' => $tmp_name,
					'size' => strlen($body),
					'type' => $value
				);

				//place in temporary directory
				file_put_contents($tmp_name, $body);
			}
			//Parse Field
			else {
				$data[$name] = substr($body, 0, strlen($body) - 2);
			}
		}
	}
	$GLOBALS['_PUT'] = $data;
	return;
}

<?php

require_once "Response.php";

function customError(
	$error_level,
	$error_message,
	$error_file,
	$error_line
) {

	Response::json([
		'error' => true,
		'level' => $error_level,
		'message' => 'Error del servidor, inténtalo más tarde.',
		'detail' => $error_message,
		'file' => $error_file,
		'line' => $error_line

	], 500);
	die();
}

set_error_handler("customError");
error_reporting(~E_ERROR);
register_shutdown_function("__fatalHandler");

function __fatalHandler()
{
	$error = error_get_last();

	if ($error !== NULL && in_array(
		$error['type'],
		array(
			E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING,
			E_COMPILE_ERROR, E_COMPILE_WARNING, E_RECOVERABLE_ERROR
		)
	)) {

		Response::json([
			'error' => true,
			'message' => 'Error del servidor, inténtalo más tarde.',
			'datail' => $error['message'],
			'file' => $error['file'],
			'line' => $error['line']
	
		], 500);
		die;
	}
}


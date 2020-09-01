<?php

require_once "Response.php";

function customError(
	$error_level,
	$error_message,
	$error_file,
	$error_line
){

	Response::json([
		'error' => true,
		'level' => $error_level,
		'message' => $error_message,
		'file' => $error_file,
		'line' => $error_line

	], 500);
	die();
}

set_error_handler("customError");







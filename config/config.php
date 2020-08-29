<?php
	require_once "../framework/Config.php";
	
	Config::set('controllers', 'app/infraestructure/controllers/');
	Config::set('models', 'app/domain/models');
	Config::set('views', '../public/views/');
	Config::set('templates', '../templates/');
	Config::set('storage', 'storage/');
	
	Config::set('dbhost', 'localhost');
	Config::set('dbname', 'pos');
	Config::set('dbusername', 'root');
	Config::set('dbpassword', '');

<?php
	require_once "models/Config.php";

	Config::singleton();
	
	Config::set('controllersFolder', 'controllers/');
	Config::set('modelsFolder', 'models/');
	Config::set('viewsFolder', 'views/');
	Config::set('dbhost', 'localhost');
	Config::set('dbname', 'pos');
	Config::set('dbusername', 'root');
	Config::set('dbpassword', '');

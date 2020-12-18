<?php
	namespace Config\config;

	use Framework\Config;
		
	Config::set('controllers', '../app/entry_point/controllers/');
	Config::set('models', '../app/domain/models/');
	Config::set('views', '../public/views/');
	Config::set('templates', '../templates/');
	Config::set('storage', '../storage/');
	Config::set('libs', '../vendor/');

	Config::set('dbhost', 'localhost');
	Config::set('dbname', 'pos');
	Config::set('dbusername', 'root');
	Config::set('dbpassword', '');

	define("BASE", "http://localhost/Inventorysoft/");


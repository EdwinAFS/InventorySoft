<?php
	namespace Config\config;

	use Framework\Config;
		
	Config::set('controllers', '../app/entry_point/controllers/');
	Config::set('models', '../app/domain/models/');
	Config::set('views', '../public/views/');
	Config::set('templates', '../templates/');
	Config::set('storage', '../storage/');
	Config::set('libs', '../vendor/');

	Config::set('dbhost', 'HOST');
	Config::set('dbname', 'DATABASE_NAME');
	Config::set('dbusername', 'USERNAME');
	Config::set('dbpassword', 'PASSWORD');

	define("BASE", "http://localhost/Inventorysoft/");


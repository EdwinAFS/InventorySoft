<?php
class Config {

	static private $vars;
	private static $instance;

	private function __construct()
	{
		self::$vars = array();
	}

	static public function set($name, $value)
	{
		if (!isset(self::$vars[$name])) {
			self::$vars[$name] = $value;
		}
	}

	static public function get($name)
	{
		if (isset(self::$vars[$name])) {
			return self::$vars[$name];
		}
	}

	public static function singleton()
	{
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}

		return self::$instance;
	}
}

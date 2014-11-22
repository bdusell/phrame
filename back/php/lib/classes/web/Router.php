<?php

abstract class Router {

	private $path;
	private $routes = array();

	public function __construct($path) {
		$this->path = $path;
		$this->method = Request::method();
	}

	public abstract function routes();

	protected function not_found($path) {
		call_user_func(array(config::helper(), 'error'), 404, array('path' => $path));
	}

	public function route() {
		while($this->routes) {
			list($path, $callback) = array_pop($this->routes);
			if($this->try_route($path, $callback)) return;
		}
		$this->not_found($this->path);
	}

	public function map($method, $pat, $callback) {
		if(strcasecmp($method, $this->method) == 0) {
			$this->routes[] = array($pat, $callback);
		}
	}

	private function try_route($pat, $func) {
		$regex = self::pattern_to_regex($pat);
		if(preg_match($regex, $this->path, $matches)) {
			array_shift($matches);
			call_user_func_array($func, $matches);
			return true;
		}
		return false;
	}

	public static function pattern_to_regex($pat) {
		$regex = preg_replace_callback('/(:[A-Za-z_]+)|([^:]+)/', function($matches) {
			if($matches[1] !== '') {
				return '([^/]*)';
			} else {
				return preg_quote($matches[2], '|');
			}
		}, $pat);
		return "|^$regex$|";
	}
}

?>
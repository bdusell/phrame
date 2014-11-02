<?php

class Response {

	public static function code($code = null) {
		if(is_null($code)) return http_response_code();
		else return http_response_code($code);
	}

	public static function header($name, $value) {
		header("$name: $value");
	}

	public static function cookie($name, $value, $lifespan = null, $path = null) {
		setcookie(
			$name,
			$value,
			is_null($lifespan) ? 0 : time() + $lifespan,
			is_null($path) ? '' : $path
		);
	}

	public static function delete_cookie($name, $path = null) {
		self::cookie($name, '', -3600, $path);
	}

	public static function json($obj, $pretty = true) {
		self::header('Content-Type', 'application/json');
		?><?= Serialize::json($obj, $pretty) ?><?php
	}
}

?>
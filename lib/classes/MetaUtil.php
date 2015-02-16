<?php

namespace phrame;

/* Utilities for introspection. */
class MetaUtil {

	public static function constant_exists($name) {
		return defined($name);
	}

	public static function function_exists($name) {
		return function_exists($name);
	}

	public static function class_exists($name) {
		return class_exists($name);
	}

	public static function method_exists($obj, $name) {
		return method_exists($obj, $name);
	}

	public static function static_method_exists($class_name, $name) {
		return method_exists($class_name, $name);
	}

	public static function call_function($name /* , $arg1, ... */) {
		$args = array_slice(func_get_args(), 1);
		return call_user_func_array($name, $args);
	}

	public static function call_method($obj, $name /* , $arg1, ... */) {
		$args = array_slice(func_get_args(), 2);
		return call_user_func_array(array($obj, $name), $args);
	}

	public static function call_static_method($class_name, $name /* , $arg1, ... */) {
		$args = array_slice(func_get_args(), 2);
		return call_user_func_array(array($class_name, $name), $args);
	}

	public static function call_constructor($class_name /* , $arg1, ... */) {
		$args = array_slice(func_get_args(), 1);
		return self::apply_constructor($class_name, $args);
	}

	public static function apply_function($name, $args) {
		return call_user_func_array($name, $args);
	}

	public static function apply_method($obj, $name, $args) {
		return call_user_func_array(array($obj, $name), $args);
	}

	public static function apply_static_method($class_name, $name, $args) {
		return call_user_func_array(array($class_name, $name), $args);
	}

	public static function apply_constructor($class_name, $args) {
		(new \ReflectionClass($class_name))->newInstanceArgs($args);
	}

	/* Get the class or type of a value as a string. */
	public static function type_name($value) {
		return is_object($value) ? get_class($value) : gettype($value);
	}

	public static function public_methods($obj) {
		$r = new \ReflectionObject($obj);
		return $r->getMethods(\ReflectionMethod::IS_PUBLIC);
	}

	public static function register_autoloader($callback) {
		spl_autoload_register($callback);
	}
}

?>

<?php

/* An object-oriented wrapper around the built-in PHP string type which offers
 * a richer API. */
class XString {

	public $value;

	public function __construct($value) {
		$this->value = $value;
	}

	public function __call($name, $args) {
		self::_unbox($args);
		$func = array('StringUtil', $name);
		array_unshift($args, $this->value);
		if(array_key_exists($name, self::$normal)) {
			return call_user_func_array($func, $args);
		} elseif(array_key_exists($name, self::$array)) {
			return new XArray(
				call_user_func_array($func, $args)
			);
		} elseif(array_key_exists($name, self::$string)) {
			return new XString(
				call_user_func_array($func, $args)
			);
		}
		throw new BadMethodCallException(
			get_class() . '->' . $name . ' does not exist'
		);
	}

	public static function __callStatic($name, $args) {
		self::_unbox($args);
		$func = array('StringUtil', $name);
		if(array_key_exists($name, self::$ctors)) {
			return new XString(
				call_user_func_array(
					$func,
					$args
				)
			);
		} elseif(array_key_exists($name, self::$static_array)) {
			return new XArray(
				call_user_func_array(
					$func,
					$args
				)
			);
		}
		throw new BadMethodCallException(
			get_class() . '::' . $name . ' does not exist'
		);
	}

	public function replace($old, $new, &$count = null) {
		return $this->_replace('replace', $old, $new, $count);
	}

	public function ireplace($old, $new, &$count = null) {
		return $this->_replace('ireplace', $old, $new, $count);
	}

	private static $normal = array(
		'length' => true,
		'size' => true,
		'equal' => true,
		'iequal' => true,
		'word_count' => true,
		'cmp' => true,
		'icmp' => true,
		'ncmp' => true,
		'incmp' => true,
		'locale_cmp' => true,
		'human_cmp' => true,
		'human_icmp' => true,
		'substring_cmp' => true,
		'substring_icmp' => true,
		'contains' => true,
		'icontains' => true,
		'contains_chars' => true,
		'contains_char' => true,
		'begins_with' => true,
		'ibegins_with' => true,
		'ends_with' => true,
		'iends_with' => true,
		'find' => true,
		'ifind' => true,
		'rfind' => true,
		'is_lower' => true,
		'is_upper' => true,
		'is_alphanumeric' => true,
		'is_alphabetic' => true,
		'is_control' => true,
		'is_decimal' => true,
		'is_hex' => true,
		'is_visible' => true,
		'is_printable' => true,
		'is_punctuation' => true,
		'is_whitespace' => true,
		'count' => true,
		'span' => true,
		'parse_int' => true,
		'parse_real' => true,
		'to_ascii' => true,
		'ord' => true,
		'levenshtein' => true,
	);

	private static $string = array(
		'join' => true,
		'trim' => true,
		'rtrim' => true,
		'ltrim' => true,
		'lower' => true,
		'upper' => true,
		'lcfirst' => true,
		'lower_first' => true,
		'ucfirst' => true,
		'upper_first' => true,
		'ucwords' => true,
		'upper_words' => true,
		'replace' => true,
		'ireplace' => true,
		'translate' => true,
		'substring' => true,
		'replace_substring' => true,
		'slice' => true,
		'replace_slice' => true,
		'insert' => true,
		'pad' => true,
		'lpad' => true,
		'rpad' => true,
		'wrap' => true,
		'repeat' => true,
		'reverse' => true,
		'starting_with' => true,
		'istarting_with' => true,
		'rstarting_with' => true,
		'starting_with_chars' => true,
		'before' => true,
		'ibefore' => true,
		'word_wrap' => true,
		'escape_c_string' => true,
		'unescape_c_string' => true,
		'escape_php_string' => true,
		'unescape_backslashes' => true,
		'encode_hex' => true,
		'decode_hex' => true,
		'encode_base64' => true,
		'decode_base64' => true,
		'unique' => true,
		'unused_bytes' => true,
		'encode_html' => true,
		'escape_html' => true,
		'unencode_html' => true,
		'encode_html_entities' => true,
		'strip_tags' => true,
		'encode_standard_url' => true,
		'decode_standard_url' => true,
		'encode_url' => true,
		'decode_url' => true,
		'md5' => true,
		'md5_hex' => true,
		'sha1' => true,
		'sha1_hex' => true,
		'rot13' => true,
		'shuffle' => true,
		'naive_pluralize' => true,
	);

	private static $array = array(
		'chars' => true,
		'chunks' => true,
		'split' => true,
		'tokenize' => true,
		'words' => true,
		'word_indexes' => true,
		'count_bytes' => true,
		'parse_raw_query_string' => true,
		'parse_csv' => true,
		'split_camel_case' => true,
	);

	private static $ctors = array(
		'from_ascii' => true,
		'chr' => true,
		'encode_standard_query_string' => true,
		'encode_query_string' => true,
		'format_money' => true,
		'format_number' => true,
	);

	private static $static_array = array(
		'encode_html_dict' => true,
		'encode_html_entities_dict' => true,
	);

	private static function _unbox(&$args) {
		$tmp = $args;
		$args = array();
		foreach($tmp as $arg) {
			if($arg instanceof self || $arg instanceof XArray) {
				$arg = $arg->value;
			}
			$args[] = $arg;
		}
	}

	private function _replace($name, $old, $new, &$count) {
		return new XString(call_user_func_array(
			array('StringUtil', $name),
			array($this->value, $old, $new, &$count)
		));
	}
}

?>
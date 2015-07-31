<?php

namespace jitsu\sql;

class Ast {

	public static function select(/* $column, ... */) {
		return new ast\SimpleSelectStatementCore(array(
			'distinct' => false,
			'columns' => func_get_args()
		));
	}

	public static function select_distinct(/* $column, ... */) {
		return new ast\SimpleSelectStatementCore(array(
			'distinct' => true,
			'columns' => func_get_args()
		));
	}

	public static function insert($table) {
		return new ast\InsertStatement(array(
			'type' => ast\InsertStatement::INSERT,
			'table' => $table
		));
	}

	public static function insert_or_ignore($table) {
		return new ast\InsertStatement(array(
			'type' => ast\InsertStatement::INSERT_OR_IGNORE,
			'table' => $table
		));
	}

	public static function delete($table) {
		return new ast\DeleteStatement(array(
			'table' => $table
		));
	}

	public static function values(/* $value_array, ... */) {
		return new ast\ValuesStatementCore(func_get_args());
	}

	public static function row(/* $expr, ... */) {
		return new ast\ValuesStatementCore(array(func_get_args()));
	}

	public static function star() {
		return new ast\WildcardColumnExpression(array());
	}

	public static function table($name) {
		return new ast\TableReference(array(
			'table' => self::name($name)
		));
	}

	public static function col($name) {
		return new ast\ColumnReference(array(
			'column' => self::name($name)
		));
	}

	public static function name($name) {
		return new ast\Identifier(array(
			'value' => $name
		));
	}

	public static function value($value = null) {
		if(func_num_args() === 0) {
			return new ast\AnonymousPlaceholder(array());
		} elseif(is_string($value)) {
			return new ast\StringLiteral(array('value' => $value));
		} elseif(is_int($value)) {
			return new ast\IntegerLiteral(array('value' => $value));
		} elseif(is_real($value)) {
			return new ast\RealLiteral(array('value' => $value));
		} elseif($value === null) {
			return new ast\NullLiteral(array());
		}
	}

	public static function create_table(
		$name,
		$column_defs,
		$constraints = array(),
		$modifiers = array()
	) {
		return new ast\CreateTableStatement(array(
			'temporary' => false,
			'if_not_exists' => false,
			'name' => $name,
			'columns' => $column_defs,
			'constraints' => $constraints,
			'modifiers' => $modifiers
		));
	}

	public static function col_def($type, $name, $clauses) {
		$attrs = array(
			'name' => self::name($name),
			'type' => $type
		);
		foreach($clauses as $c) {
			$attrs[self::get_col_def_key($c)] = $c;
		}
		return new ast\ColumnDefinition($attrs);
	}

	private static function get_col_def_key($c) {
		if($c instanceof ast\NotNullClause) {
			return 'not_null';
		} elseif($c instanceof ast\DefaultValueClause) {
			return 'default';
		} elseif($c instanceof ast\AutoincrementClause) {
			return 'autoincrement';
		} elseif($c instanceof ast\KeyClause) {
			return 'key';
		} elseif($c instanceof ast\ForeignKeyClause) {
			return 'foreign_key';
		} else {
			throw new \InvalidArgumentException(
				'invalid column definition clause');
		}
	}

	public static function primary_key() {
		return new ast\PrimaryKeyClause(array());
	}

	public static function autoincrement() {
		return new ast\AutoincrementClause(array());
	}

	public static function int_type($bytes = 4, $signed = true) {
		return new ast\IntegerType(array(
			'bytes' => $bytes,
			'signed' => $signed
		));
	}
}

?>

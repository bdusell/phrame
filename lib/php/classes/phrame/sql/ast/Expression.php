<?php

namespace phrame\sql\ast;

/* An arbitrary expression.
 *
 * <expression> ->
 *   <atomic-expression> |
 *   <collate-expression> |
 *   <unary-operator-expression> |
 *   <binary-operator-expression> |
 *   <in-expression> |
 *   <like-expression> |
 *   <between-expression> |
 *   <case-expression>
 */
abstract class Expression extends Node {

	public function as_self() {
		return new SimpleColumnExpression(array(
			'expr' => $this
		));
	}

	public function as_name($name) {
		return new SimpleColumnExpression(array(
			'expr' => $this,
			'as' => new Identifier($name)
		));
	}

	public function asc($collation = null) {
		return new OrderedExpression(array(
			'expr' => $this,
			'order' => OrderedExpression::ASC
		));
	}

	public function desc($collation = null) {
		return new OrderedExpression(array(
			'expr' => $this,
			'order' => OrderedExpression::DESC
		));
	}

	public function eq($expr) {
		return new BinaryOperation(array(
			'left' => $this,
			'operator' => BinaryOperation::EQUAL,
			'right' => $expr
		));
	}
}

?>

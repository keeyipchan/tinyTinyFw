<?php

interface Model {
}

class Property {
	function must() {
		return $this;
	}

	function will() {
		return $this;
	}

	function inherit() {
		return $this;
	}

	function take() {
		return $this;
	}
}
function property($label) {
	$property = new Property();
	$property->label = $label;
	return $property;
}
class Value {
	var $property;
}

class Controller {
	var $fields = array();

	function prompt($field) {
		$this->fields = array_merge($this->fields, array($field));
		return $this;
	}

	function layout() {
		return $this;
	}

	function whenIdle($callback) {
		$this->idleCallback = $callback;
		return $this;
	}

	function whenOk() {
		return $this;
	}
}
function controller () {
	return new Controller();
}
function run($controller) {
	if (empty($_POST)):
		$callback = $controller->idleCallback;
		$callback($controller);
	endif;
}
class Field {
}
function field($key, $property, $config) {
	$field = new Field();
	$field->config = array_merge(
		array(
			'key' => $key,
			'model' => $property
		),
		$config
	);

	return $field;
}

function layout2columns($controller) {
	echo dom('table',
		array_map(function($field) {
			$domLabel = $field->config['display:title'];
			if (is_string($domLabel))
				$domLabel = dom('label', $domLabel);

			return
				dom('tr',
					dom('th', $domLabel),
					dom('td',
						dom('input')));
		}, $controller->fields)
	);
}

class Dom {
	var $children = array();

	function __toString() {
		$tag = $this->tag;

		$str = "<$tag>";

		foreach ($this->children as $child):
			$str .= $child;
		endforeach;

		$str .= "</$tag>";

		return $str;
	}
}
function dom() {
	$config = func_get_args();

	$dom = new Dom();
	$dom->tag = array_shift($config);

	foreach ($config as $child):

		if (is_array($child))
			foreach ($child as $C)
				$dom->children[] = $C;
		else
			$dom->children[] = $child;

	endforeach;

	return $dom;
}

?>

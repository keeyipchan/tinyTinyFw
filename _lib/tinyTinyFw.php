<?php
require_once dirname(__FILE__) . '/tinyTinyFw.sugar.php';
require_once dirname(__FILE__) . '/tinyTinyFw.layouts.php';
require_once dirname(__FILE__) . '/tinyTinyFw.dom.php';
require_once dirname(__FILE__) . '/tinyTinyFw.properties.php';

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

class Field {
}

function field($key, $property, $config) {
	$field = new Field();
	$field->config = array_merge(
		array(
			'key' => $key,
			'property' => $property
		),
		$config
	);

	return $field;
}

class Module {
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

function module () {
	return new Module();
}

function run($module) {
	if (empty($_POST)):
		$callback = $module->idleCallback;
		$callback($module);
	endif;
}

?>

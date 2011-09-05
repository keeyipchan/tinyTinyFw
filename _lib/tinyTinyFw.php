<?php

class kv {
    protected $data;
    protected $valueCache;
    var $self;
    var $expectedData;

    function __construct($self, $data = null) {
    	$this->reset();
        $this->self = $self;
        if (!empty($data))
            $this->data = $data;
    }
    function let($k, $v) {
        $this->data[$k] = $v;
        unset($this->valueCache[$k]);
        return $this;
    }
    function get($k) {
        if (array_key_exists($k, $this->valueCache))
            return $this->valueCache[$k];
        if (!array_key_exists($k, $this->data))
            return null;
        $v = $this->data[$k];
        $value = is_callable($v) ? call_user_func($v, $this->self) : $v;
        return $this->valueCache[$k] = $value;
    }
    function all() {
        return $this->data;
    }
    function expect($k) {
    	$this->expectedData[] = $k;
        return $this;
    }
    function expected() {
    	return $this->expectedData;
    }
    function reset() {
    	$this->data = array();
    	$this->expectedData = array();
    	$this->clearCache();
    	return $this;
    }
    function clearCache() {
    	$this->valueCache = array();
        return $this;
    }
}

class pluggable {
    var $methodMap = array();
    function __call($alias, $args) {
        if (!array_key_exists($alias, $this->methodMap))
            throw new Exception("Method alias not mapped: {$alias}()");
        $methodMap = $this->methodMap[$alias];
        $x = call_user_func_array(array($methodMap['obj'], $methodMap['method']), $args);
        return ($x === $methodMap['obj']) ? $this : $x;
    }
    function plug() {
        switch (func_num_args()) {
            case 0:
                return $this;
            case 1:
                list($obj) = func_get_args();
                $methods = get_class_methods($obj);
                break;
            default:
                list($arg1, $obj) = func_get_args();
                $methods = is_array($arg1) ? $arg1 : array($arg1);
                break;
        }
        foreach ($methods as $k => $method) {
            $alias = is_string($k) ? $k : $method;
            $this->methodMap[$alias] = array(
                'obj' => $obj,
                'method' => $method
            );
        }
        return $this;
    }
}



class num {
	var $value = 0;

	function nudge( $value ) {
		$this->value += $value;
		
		return $this;
	}

	function cast( $type ) {
		switch ($type) {
			case 'int':
				return intval($this->value);
			
			default:
				return null;
		}
	}

	function scale( $A ) {
		$scalar = ( $A instanceof num )
			? $A ->cast( 'int' )
			: $A;

		$this->value *= $scalar;

		return $this;
	}

    static function repeat( $A, $B ) {
        return number( $A ) -> scale( $B );
    }

    static function largest( $array ) {
        return number( max( $array ) );
    }
}

class str {
    static function equals( $A, $B ) {
    	return $A === $B;
    }
}


function num( $A ) {
	if( $A instanceof num )
		return $A;
	
	$number = new num();
	$number->value = $A;
	return $number;
}

class arr {
    static function map( $array, $function ) {
    	return array_map( $function, $array );
    }
}

require_once dirname(__FILE__) . '/tinyTinyFw.ui.php';
require_once dirname(__FILE__) . '/tinyTinyFw.widgets.php';
require_once dirname(__FILE__) . '/tinyTinyFw.layouts.php';
require_once dirname(__FILE__) . '/tinyTinyFw.properties.php';


class Field {
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
function field($key, $config) {
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

$modules = new pluggable();
$modules->plug(new kv($modules));
class module extends pluggable {
	var $fields = array();
	function prompt($field) {
		$this->fields = array_merge($this->fields, array($field));
		return $this;
	}
	function __construct() {
		$this->plug(new kv($this));
	}
	function run() {
		if (empty($_POST))
			return $this->get('whenIdle');
	}
}
function module ($name) {
	global $modules;
	return $modules->get($name);
}
?>
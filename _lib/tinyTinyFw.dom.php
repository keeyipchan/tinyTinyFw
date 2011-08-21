<?php

class Dom {
	var $children = array();
	var $css = array();
	var $data = array();

	static $singulars = array();
	static $widgets = array();

	function __toString() {
		$tag = $this->tag;

		if (!empty(Dom::$widgets[$tag])):
			$function = Dom::$widgets[$tag];
			return '' . $function($this);
		endif;

		$attrs = array();

		if (!empty($this->css)):
			$attrs['style'] = implode('', array_map(function($key, $value) {
				return sprintf('%s:%s;', $key, $value);
			}, array_keys($this->css), array_values($this->css)));
		endif;

		if (!empty($attrs)):
			$strAttrs = ' '
				. implode(' ', array_map(function($key, $value) {
					return sprintf('%s="%s"', $key, $value);
				}, array_keys($attrs), array_values($attrs)));
		else:
			$strAttrs = '';
		endif;

		if (is_null($this->children)):
			return "<{$tag}{$strAttrs}/>";
		endif;

		$str = "<{$tag}{$strAttrs}>";

		foreach ($this->children as $child):
			if (is_string($child))
				$str .= htmlentities($child, ENT_QUOTES, 'UTF-8');
			else
				$str .= $child;
		endforeach;

		$str .= "</$tag>";

		return $str;
	}

	function css($css) {
		$this->css = array_merge($this->css, $css);
		return $this;
	}

	function set($key, $value) {
		$this->data[$key] = $value;
		return $this;
	}

	function get($key) {
		return $this->data[$key];
	}
}

function dom() {
	$args = func_get_args();

	$dom = new Dom();
	$dom->tag = array_shift($args);

	if (in_array($dom->tag, Dom::$singulars)):
		$dom->children = null;
		return $dom;
	endif;

	foreach ($args as $child):

		if (is_array($child))
			foreach ($child as $C)
				$dom->children[] = $C;
		else
			$dom->children[] = $child;

	endforeach;

	return $dom;
}

Dom::$singulars[] = 'input';

?>

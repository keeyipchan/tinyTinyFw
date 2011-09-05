<?php
$widgets = new pluggable();
$widgets->plug(new kv($widgets));
function widget($name) {
	global $widgets;
	$template = $widgets->get($name);
	$widget = new widget($template->all());
	return $widget;
}
class widget extends pluggable {
	function __construct($data = null) {
		$this->plug(new kv($this, $data));
	}
	function __toString() {
		return $this->get('dom')->__toString();
	}
}
class dom {
	var $children = array();
	var $css = array();
	var $attrs = array();
	var $jsCalls = array();
	var $singular = false;
	static $singulars = array();
	static $jsFiles = array(
		'toggler' => 'http://localhost/~keeyipchan/tinyTinyFw/_lib/tinyTinyFw.controls.js'
	);
	static $nextId = 0;
	function __construct($tag) {
		$this->tag = $tag;
	}
	static function render($dom) {
		if ($dom instanceof widget)
			$dom = $dom->get('dom');
		$str = "<!doctype html>\n";
		$scripts = array();
		foreach ($dom->requiredJsFiles() as $C):
			$scripts[] = dom('script')->attr('src', Dom::$jsFiles[$C]);
		endforeach;
		$str .=
			dom( 'html',
				dom( 'head',
					dom( 'title', 'tinyTinyFw' ),
					$scripts
				),
				dom( 'body' )
					->css( array(
						'color' => 'hsl(0,0%,40%)',
						'overflow-y' => 'scroll',
						'background' => 'hsl(180,10%,90%)',
						'font-family' => 'tahoma'
					) )
					->append( $dom )
			);
		return $str;
	}
	function __toString() {
		$tag = $this->tag;

		if( !empty($this->css)):
			$this->attrs['style'] = implode('', array_map(function($key, $value) {
				return sprintf('%s:%s;', $key, $value);
			}, array_keys($this->css), array_values($this->css)));
		endif;

		if( !empty($this->jsCalls)):
			$this->attrs['id'] = 'ttfw-' . Dom::$nextId;
			Dom::$nextId++;
		endif;

		if( !empty($this->attrs)):
			$strAttrs = ' '
				. implode(' ', array_map(function($key, $value) {
					return sprintf('%s="%s"', $key, $value);
				}, array_keys($this->attrs), array_values($this->attrs)));
		else:
			$strAttrs = '';
		endif;

		if( $this->singular ):
			return "<{$tag}{$strAttrs}/>";
		endif;

		$str = "<{$tag}{$strAttrs}>";

		foreach ($this->children as $child):
			if( is_string($child))
				$str .= htmlentities($child, ENT_QUOTES, 'UTF-8');
			else
				$str .= $child;
		endforeach;

		$str .= "</$tag>";

		foreach ($this->jsCalls as $C => $config) {
			$str .= sprintf("<script>(function(){%s(document.getElementById('%s'), %s).init()})();</script>",
				$C,
				$this->attrs['id'],
				json_encode($config));
		}

		return $str;
	}
	function requiredJsFiles() {
		$requiredJsFiles = array_keys($this->jsCalls);
		foreach ($this->children as $child):
			if($child instanceof widget)
				$requiredJsFiles = array_merge($requiredJsFiles, $child->get('dom')->requiredJsFiles());
			else if( is_object($child))
				$requiredJsFiles = array_merge($requiredJsFiles, $child->requiredJsFiles());
		endforeach;

		return $requiredJsFiles;
	}
	function attr($key, $value) {
		$this->attrs[$key] = $value;
		return $this;
	}
	function css($css) {
		$this->css = array_merge($this->css, $css);
		return $this;
	}
	function jsCall( $key, $config ) {
		$this->jsCalls[$key] = $config;
		
		return $this;
	}
	function append() {
		$args = func_get_args();
		foreach ($args as $child):
			if( is_array( $child ) ):
				foreach( $child as $C ):
					if( is_array( $C ) ):
						$this->children = array_merge($this->children, $C);
					else:
						$this->children[] = $C;
					endif;
				endforeach;
			else:
				$this->children[] = $child;
			endif;
		endforeach;
		return $this;
	}
}
function dom() {
	$args = func_get_args();

	$dom = new dom(array_shift($args));

	if( in_array($dom->tag, dom::$singulars)):
		$dom->singular = true;
		return $dom;
	endif;

	return $dom->append($args);
}
dom::$singulars[] = 'input';
?>

<?php
ini_set('display_errors',1);
error_reporting(E_ALL|E_WARNING);

require_once dirname(__FILE__) . '/../../_lib/tinyTinyFw.php';

Dom::$widgets['widget:window'] = function($dom) {
	return
	dom('div',
		dom('div',
			dom('a', 'Larger'),
			dom('a', 'Close'))
		->css(array('float' => 'right')),

		dom('div', $dom->get('content'))
		->css(array('padding' => '1em')))

	->css(array('border' => 'solid 1px gray'));
};

echo dom('widget:window')->set('content', '12345');

?>

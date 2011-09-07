<?php
require_once dirname(__FILE__) . '/../_lib/tinyTinyFw.php';
require_once dirname(__FILE__) . '/properties.php';

$modules->let('user:join', function() {
	$module = new module();
	
	$module->let('fields', fields('username', 'email'));
	
	// Called when there is no form submission.
	$module->let('whenIdle', function($self) {
		return widget('window')->let('content',
			dom('div',
				layout2columns($self->get('fields')),
				dom('pre')->css(array(
					'border' => 'solid 1px gray',
					'padding' => '0.5em'
				))->append('$_REQUEST = ' . var_export($_REQUEST, true))
			)
		);
	});
	
	$module->let('whenError', function($self) {
		return widget('message:error', "Sorry, there has been an error.");
	});
	
	// Called after form submission and input validation is ok.
	$module->let('whenOk', function($self, $values) {
		// $values['username']->property;
		// Each $value has already gone through
		// validators defined by the value's underlying property -- see properties.php.
		$user = user::Create($values);
		
		// Can return either a layout function or dom.
		return dom('div')->append(
			dom('message:ok', "Thank you."),
			dom('message:info', "Don't forget to join a club.")
		);
	});
	return $module;
});
?>
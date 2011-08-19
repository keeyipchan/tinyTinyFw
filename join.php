<?php
require_once 'framework.php';
require_once 'models.php';

// Can put this in controllers/user.php
$controllers['user:join'] = controller()
	->prompt(field('username', $Username, array(
		'display:title' => 'Choose a username')))

	->prompt(field('password', $Password, array(
		'display:title' => 'Enter a password')))

	->prompt(field('passwordConfirm', $Password, array(
		'display:title' => 'Type again')))

	// Called when there is no form submission.
	->whenIdle(layout2columns)

	// Called after form submission and input validation is ok.
	->whenOk(function($values) {
		// $values['username']->property;
		// Each $value has already gone through
		// validators defined by the value's underlying property -- see models.php.

		$user = User::create($values);

		// Can return either a layout function or dom.
		return dom('div',
			dom('message:ok', "Thank you."),
			dom('message:info', "Don't forget to join a club."));
	});

run(
	$controllers['user:join']
);

?>

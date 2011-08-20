<?php
require_once dirname(__FILE__) . '/_app/module.user.php';

run(
	$modules['user:join']
);


echo
dom('pre', '$_REQUEST = ' . var_export($_REQUEST,true))
->css(array('border' => 'solid 1px gray', 'padding' => '0.5em'));

?>

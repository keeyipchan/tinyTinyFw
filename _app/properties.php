<?php
require_once dirname(__FILE__) . '/../_lib/tinyTinyFw.php';

$User = property('User')
->take(
	$UserId = property('User ID')
	->inherit($Id))
->take(
	$Username = property('Username')
	->must('maxLength', 255)
	->must('slug'))
->take(
	$UserPassword = property('Password')
	->inherit($Password));

?>

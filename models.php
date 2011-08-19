<?php
require_once 'framework.php';

$Id = property('ID')
->must('lessThanOrEqual', 50)
->will('castInteger');

$Password = property('Password')
->must('maxLength', 255)
->must('slug');

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

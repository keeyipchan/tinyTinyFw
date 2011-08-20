<?php

$Id = property('ID')
->must('lessThanOrEqual', 50)
->will('castInteger');

$Password = property('Password')
->must('maxLength', 255)
->must('slug');

?>

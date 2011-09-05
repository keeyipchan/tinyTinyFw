<?php
require_once(dirname(__FILE__) . '/_app/module.user.php');
echo dom::render(module('user:join')->run());
?>
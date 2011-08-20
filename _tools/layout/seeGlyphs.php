<?php

require_once dirname(__FILE__) . '/../../_lib/tinyTinyFw.php';

echo
dom('table',
	array_map(function($i) {

		$begin = 33;
		$perRow = 20;

		$x = $begin + ($i * $perRow);

		return
		dom('tr',
			dom('th', $x),
			array_map(function($j) {

				// TODO: Find out how to get unicode characters to show up.
				return
				dom('td', chr($j));

			}, range($x, $x + $perRow)));

	}, range(0, 10)))
->css(array('font-family' => 'Verdana'));

?>

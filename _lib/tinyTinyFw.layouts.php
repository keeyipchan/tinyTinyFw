<?php

function layout2columns($module) {
	echo dom('table',
		array_map(function($field) {
			$domLabel = $field->config['display:title'];
			if (is_string($domLabel))
				$domLabel = dom('label', $domLabel);

			return
				dom('tr',
					dom('th', $domLabel),
					dom('td',
						dom('input')));
		}, $module->fields)
	);
}

?>

<?php

// TODO: May want to abstract into a Layout class, and not assume that we are rendering form elements.
function layout2columns($module) {
	return dom('table')->append(array_map(function($field) {
		$domLabel = $field->config['display:title'];
		if (is_string($domLabel))
			$domLabel = dom('label', $domLabel);
		return dom('tr', dom('th', $domLabel), dom('td', dom('input')));
	}, $module->fields));
}

?>

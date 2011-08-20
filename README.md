A tiny tiny php framework (php 5.3+).

OVERVIEW
===

Browser &rarr; 'index.php?go=user:join' &rarr; Server (index.php) &rarr; run($modules[$_REQUEST['go']])


API
===

*	<b>Property</b> - 
*	<b>Value</b> - 
*	<b>Field</b> -
*	<b>Module</b> -
*	<b>Dom</b> -
*	<b>Layout</b> -


GOALS
===

*	Encourage code reuse/sensible abstractions, favor composition instead of rabid inheritance
*	Strict treatment of user input:
	*	<b>Property</b> represents a domain-specific data type, use this instead of raw data types
		*	Declarative: $Username = property()->must('maxChars', 255)->will('truncate');
			*	Validation and other metadata is baked into the definition
			*	Renderers are able to discern how to render a property based on metadata
*	Flexible in-memory dom representation:
	*	Not limited to standard html tags
	*	Support custom tags and transformations
	*	Selectively sanitizes content -- no need to waste cycles sanitizing safe content.
		*	Able to specify what needs sanitization.



EXAMPLE, render a table
===

```php
<?php

$userDetails = array(
	'id' => 123,
	'username' => 'keeyipchan',
	'email' => 'hello@example.com'
);

echo
dom('table',
	array_map(function($label, $str) {
		return
		dom('tr',
			dom('th', $label),
			dom('td', $str));
	}, array_keys($userDetails), array_values($userDetails)))
->css(array('font-family' => 'tahoma', 'border-collapse' => 'collapse'));

?>
```

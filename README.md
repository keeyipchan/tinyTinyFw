A tiny tiny php framework (php 5.3+).

OVERVIEW
===

Browser &rarr; <code>'index.php?go=user:join'</code> &rarr; Server (index.php) &rarr; <code>run($modules[$_REQUEST['go']])</code>


API
===

*	<b>Property</b> - 
*	<b>Value</b> - 
*	<b>Field</b> -
*	<b>Module</b> -
*	<b>Dom</b> -
*	<b>Layout</b> -
*	<b>Sugar</b> -


GOALS
===

*	Encourage code reuse/sensible abstractions, favor composition instead of rabid inheritance
	*	Use <b>sugar</b> to improve readability and enforce standards (some php functions are horribly named).
*	Strict treatment of user input:
	*	<b>Property</b> represents a domain-specific data type, use this instead of raw data types
		*	Declarative: <code>$Username = property()->must('maxChars', 255)->will('truncate');</code>
			*	Validation and other metadata is baked into the definition
			*	Renderers are able to discern how to render a property based on metadata
*	Flexible in-memory dom representation:
	*	Not limited to standard html tags
	*	Support custom tags and transformations
	*	Selectively sanitizes content -- no need to waste cycles sanitizing safe content.
		*	Able to specify what needs sanitization.

ROADMAP
===

*	Experiment with pattern matching sugar to replace regex.
	*	Large regex strings are ridiculous to maintain, it's better to have a declarative style like the <code>dom()</code> api.
		* Such as <code>$linkPattern = pattern() -> startsWith('</a') -> subPattern('any', pattern() -> whitespace('atLeast', 1) -> string('href="') -> alphaNumeric('any') -> string('"'));</code>
			* Advanges: does not need to parse a regex string (faster); no escaping hell; transformable; readable, maintable.
*	Experiment with form building (validation, data-binding, rendering).
*	Experiment with system administration tasks, defined in a declarative way (sequence, parallel, delayed, partitioned).
*	Experiemnt with core ui controls (overlay, dialog, lists, trees, buttons, tooltips).
	*	Also need some api for general browser features (history, ajax).
*	Think of ways to manage js, css, resources.

EXAMPLE, render a table
===

```php
<?php

$userDetails = array(
	'id' => 123,
	'username' => 'keeyipchan',
	'email' => 'hello@example.com'
);

echo(
	dom( 'table' )
		-> append( array_map(
						function( $key, $value ) {
							return( dom( 'tr',
										dom( 'th', $key ),
										dom( 'td', $value )
								) );
						},
						array_keys( $userDetails ),
						array_values( $userDetails )
			) )
		-> css( array(
					'font-family' => 'tahoma',
					'border-collapse' => 'collapse'
			) )
);

?>
```

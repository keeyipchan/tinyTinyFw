A tiny tiny php framework (php 5.3+).

USAGE: "http://localhost/~keeyipchan/index.php?go=user:join"

OVERVIEW:
browser -> index.php?go=user:join -> server(index.php) -> run($controllers[$_REQUEST['go']])

GOALS:
* Encourage code reuse/sensible abstractions, favor compositing components instead of rabid inheritance
* Strict treatment of user input:
	* '''Property''' represents a domain-specific datatype, use this instead of raw data types
		* Declarative: $Username = property()->must('maxChars', 255)->will('truncate');
			* Validation and other metadata is baked into the definition
			* Renderers are able to discern how to render a property based on metadata
* Flexible in-memory dom representation:
	* Not limited to standard html tags
	* Support custom tags and transformations
	* Selectively sanitizes content -- no need to waste cycles sanitizing safe content.
		* Able to specify what needs sanitization.

EXAMPLE, render a table:
```php
$userDetails = array(
	'id' => 123,
	'username' => 'keeyipchan',
	'email' => 'keeyipchan@yahoo.com'
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
```

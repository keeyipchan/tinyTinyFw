function toggler(dom, config) {
	var toggler = {};

	toggler.init = function() {
		dom.onclick = function() {
			toggler.next();
		};

		toggler.refresh();
	};

	toggler.next = function() {
		config.currentIndex = increment( config.currentIndex, {
			max: config.states.length - 1,
			min: 0 } );

		toggler.refresh();
	};

	toggler.refresh = function() {
		dom.innerHTML = config.states[config.currentIndex];
	};

	return toggler;
}

function increment(i, config) {
	var j = i + 1;

	if (!config.hasOwnProperty('max'))
		return j;

	if (j <= config.max)
		return j;

	if (config.hasOwnProperty('min'))
		return config.min;
	else
		return config.max;
}

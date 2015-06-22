/* Avoid `console` errors in browsers that lack a console */
(function() {
	var method;
	var noop = function () {};
	var methods = [
		'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
		'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
		'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
		'timeStamp', 'trace', 'warn'
	];
	var length = methods.length;
	var console = ( window.console = window.console || {} );

	while ( length-- ) {
		method = methods[length];

		// Only stub undefined methods.
		if (!console[method]) {
			console[method] = noop;
		}
	}
}());

//@prepros-append vendor/enquire.min.js
//@prepros-append vendor/slick.min.js
//@prepros-append vendor/jquery.flexslider.min.js
//@prepros-append vendor/jquery.magnific-popup.min.js
//@prepros-append vendor/jquery.hoverIntent.min.js
//@prepros-append vendor/jquery.superfish.min.js
//@prepros-append vendor/jquery.appear.min.js
//@prepros-append vendor/jquery.counto.min.js
//@prepros-append vendor/jquery.spectragram.min.js
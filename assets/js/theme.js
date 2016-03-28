$(document).ready(function() {
	
	'use strict';
	
	var $postReading = $('#post-reading-wrap');
	
	if ( $postReading.length > 0 ) {
		var getMax = function() {
			return $(document).height() - $(window).height();
		}
		
		var getValue = function() {
			return $(window).scrollTop();
		}
		
		if ( 'max' in document.createElement('progress') ) {
			
			// Browser supports progress element
			var progressBar = $('progress#post-reading-indicator');
			
			// Set the Max attr for the first time
			progressBar.attr({ max: getMax() });

			// On scroll only Value attr needs to be calculated
			$(document).on('scroll', function() {
				progressBar.attr({ value: getValue() });
			});
		  
			$(window).resize(function() {
				// On resize, both Max/Value attr needs to be calculated
				progressBar.attr({ max: getMax(), value: getValue() });
			});   
		
		} else {
			
			var progressBar = $('.post-reading-indicator-bar'), max = getMax(), value, width;
			
			// Calculate width in percentage
			var getWidth = function() {
				var value = getValue();            
				var width = ( value / max ) * 100;
				width = width + '%';
				return width;
			}
			
			var setWidth = function() {
				progressBar.css({ width: getWidth() });
			}
			
			$(document).on('scroll', setWidth);
			$(window).on('resize', function(){
				// Need to reset the Max attr
				var max = getMax();
				setWidth();
			});
		}
	}
});

$(document).on('scroll', function() {
	var $postReading = $('#post-reading-wrap');
	if ( $postReading.length > 0 ) {
		var maxAttr = $('#post-reading-indicator').attr('max');
		var valueAttr = $('#post-reading-indicator').attr('value');
		var percentage = ( valueAttr / maxAttr ) * 100;
		
		// Show post reading bar
		if ( percentage > 10 ) {
			$postReading.addClass('visible')
		} else {
			$postReading.removeClass('visible')
		}
	}
});
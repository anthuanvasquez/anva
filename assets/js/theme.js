(function( $ ) {

	'use strict';

	var $postReading = $('#post-reading-wrap');

	if ( $postReading.length > 0 ) {
		var getMax = function() {
			return $(document).height() - $(window).height();
		};

		var getValue = function() {
			return $(window).scrollTop();
		};

		var $indicator = $('.post-reading-indicator-bar'), max = getMax(), value, width;

		// Calculate width in percentage
		var getWidth = function() {
			value = getValue();
			width = ( value / max ) * 100;
			width = width + '%';
			return width;
		};

		var setWidth = function() {
			max = getMax();
			$indicator.css({ width: getWidth() });
		};

		$(document).on('scroll', setWidth);
		$(window).on('resize', function(){
			// Need to reset the Max attr
			max = getMax();
			setWidth();
		});

		$(document).on('scroll', function() {
			var $width = $('.post-reading-indicator-bar').width();
			var percentage = ( $width / max ) * 100;
			if ( percentage > 10 ) {
				$postReading.addClass('visible');
			} else {
				$postReading.removeClass('visible');
			}
		});
	}

	// if ( $('#ajax_search').val() != '' ) {
		console.log( ANVA_VARS.ajaxUrl );
		$('#s').on( 'input', function() {
			$.ajax({
				url: ANVA_VARS.ajaxUrl,
				type: 'POST',
				data: 'action=anva_ajax_search&s=' + $('#s').val(),
				success: function( results ) {
					$("#autocomplete").html( results );

					if ( results != '' ) {
						$("#autocomplete").addClass('nothidden');
						$("#autocomplete").show();
						$("body.js_nav .mobile_menu_wrapper").css('overflow', 'visible');
					} else {
						$("#autocomplete").hide();
						$("body.js_nav .mobile_menu_wrapper").css('overflow', 'scroll');
					}
				}
			});
		});

		$("#s").keypress( function( e ) {
			if ( e.which == 13 ) {
				e.preventDefault();
				$("form#searchform").submit();
			}
		});

		$('#s').focus( function() {
			if ( $('#autocomplete').html() != '' ) {
				$("#autocomplete").addClass('nothidden');
				$("#autocomplete").fadeIn();
			}
		});

		$('#s').blur( function() {
		  $("#autocomplete").fadeOut();
		});
	// }

})( jQuery );

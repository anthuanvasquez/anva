/**
 * Custom scripts needed for the colorpicker, image button selectors,
 * and navigation tabs.
 */

jQuery(document).ready(function($) {

	/* ---------------------------------------------------------------- */
	/* WP Color Picker
	/* ---------------------------------------------------------------- */
	$('.anva-color').wpColorPicker();

	/* ---------------------------------------------------------------- */
	/* Radio Images
	/* ---------------------------------------------------------------- */
	$('.anva-radio-img-img').click(function(){
		$(this).parent().parent().find('.anva-radio-img-img').removeClass('anva-radio-img-selected');
		$(this).addClass('anva-radio-img-selected');
	});

	$('.anva-radio-img-label').hide();
	$('.anva-radio-img-img').show();
	$('.anva-radio-img-radio').hide();

	/* ---------------------------------------------------------------- */
	/* Logo
	/* ---------------------------------------------------------------- */
	$('.section-logo').each(function(){
		var el = $(this), value = el.find('.select-type select').val();
		el.find('.logo-item').hide();
		el.find('.' + value).show();
	});

	$('.section-logo .anva-select select').live( 'change', function() {
		var el = $(this), parent = el.closest('.section-logo'), value = el.val();
		parent.find('.logo-item').hide();
		parent.find('.' + value).show();
	});

	/* ---------------------------------------------------------------- */
	/* Typography Google
	/* ---------------------------------------------------------------- */
	$('.section-typography .anva-typography-face').each(function() {
		var el = $(this), value = el.val();
		if ( value == 'google' )
			el.closest('.section-typography').find('.google-font').fadeIn('fast');
		else
			el.closest('.section-typography').find('.google-font').hide();
			el.closest('.section-typography').find('.sample-text-font').css('font-family', value );
	});

	$('.section-typography .anva-typography-face').live( 'change', function() {
		var el = $(this), value = el.val();
		if ( value == 'google' )
			el.closest('.section-typography').find('.google-font').fadeIn('fast');
		else
			el.closest('.section-typography').find('.google-font').hide();
			el.closest('.section-typography').find('.sample-text-font').css('font-family', value );
	});

	/* ---------------------------------------------------------------- */
	/* Social Media Buttons
	/* ---------------------------------------------------------------- */
	$('.section-social_media').each(function() {
		var el = $(this);
		el.find('.social_media-input').hide();
		el.find('.checkbox').each(function() {
			var checkbox = $(this);
			if ( checkbox.is(':checked') )
				checkbox.closest('.item').addClass('active').find('.social_media-input').show();
			else
				checkbox.closest('.item').removeClass('active').find('.social_media-input').hide();
		});
	});

	$('.section-social_media .checkbox').live('click', function() {
		var checkbox = $(this);
		if ( checkbox.is(':checked') )
			checkbox.closest('.item').addClass('active').find('.social_media-input').fadeIn('fast');
		else
			checkbox.closest('.item').removeClass('active').find('.social_media-input').hide();
	});

	/* ---------------------------------------------------------------- */
	/* Columns
	/* ---------------------------------------------------------------- */
	$('.section-columns').each(function(){
		var el = $(this), i = 1, num = el.find('.column-num').val();
		el.find('.column-width').hide();
		el.find('.column-width-'+num).show();
	});

	$('.section-columns .column-num').live('change', function(){
		var el = $(this), i = 1, num = el.val(), parent = el.closest('.section-columns');
		parent.find('.column-width').hide();
		parent.find('.column-width-'+num).fadeIn('fast');
	});

	/* ---------------------------------------------------------------- */
	/* Loads tabbed sections if they exist
	/* ---------------------------------------------------------------- */
	if ( $('.nav-tab-wrapper').length > 0 ) {
		options_framework_tabs();
	}

	function options_framework_tabs() {
		var $group = $('.group'),
			$navtabs = $('.nav-tab-wrapper a'),
			active_tab = '';

		// Hides all the .group sections to start
		$group.hide();

		// Find if a selected tab is saved in localStorage
		if ( typeof(localStorage) != 'undefined' ) {
			active_tab = localStorage.getItem('active_tab');
		}

		// If active tab is saved and exists, load it's .group
		if ( active_tab != '' && $(active_tab).length ) {
			$(active_tab).fadeIn();
			$(active_tab + '-tab').addClass('nav-tab-active');
		} else {
			$('.group:first').fadeIn();
			$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
		}

		// Bind tabs clicks
		$navtabs.click(function(e) {
			e.preventDefault();

			// Remove active class from all tabs
			$navtabs.removeClass('nav-tab-active');

			$(this).addClass('nav-tab-active').blur();

			if (typeof(localStorage) != 'undefined' ) {
				localStorage.setItem('active_tab', $(this).attr('href') );
			}

			var selected = $(this).attr('href');

			$group.hide();
			$(selected).fadeIn();
		});
	}
});
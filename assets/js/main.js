jQuery.noConflict();
jQuery(document).ready( function() {

	var windows_width = jQuery(window).width();

	// ---------------------------------------------------------
	// Toogle Sub Menu
	// ---------------------------------------------------------
	if( windows_width < 768 ) {
		var menuTrigger = jQuery('.menu-item-has-children > a');
		menuTrigger.click( function(e) {
			e.preventDefault();
			jQuery(this).toggleClass('is-active').next('ul').toggleClass('is-active');
		});
	}

	// ---------------------------------------------------------
	// Lightbox
	// ---------------------------------------------------------
	jQuery('.gallery > .gallery-item a').attr('data-lightbox', 'gallery-item');

	// ---------------------------------------------------------
	// Toogle for shortcodes
	// ---------------------------------------------------------
	jQuery('div.toggle-info').hide();
	jQuery('h3.toggle-trigger').click(function(e) {
		e.preventDefault();
		jQuery(this).toggleClass("is-active").next().slideToggle("normal");
	});

	// ---------------------------------------------------------
	// Remove empty 'p' tags
	// ---------------------------------------------------------
	jQuery('p:empty').remove();
	jQuery('p').filter( function() {
		return jQuery.trim( jQuery(this).html() ) == '';
	}).remove();

	// ---------------------------------------------------------
	// Scroll go top button
	// ---------------------------------------------------------
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 200) {
			jQuery('#gotop').fadeIn(200);
		} else {
			jQuery('#gotop').fadeOut(200);
		}
	});

	jQuery('#gotop').click(function(e) {
		e.preventDefault();
		jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
	});
	
	// Additional JS

	// ---------------------------------------------------------
	// Fitvids
	// ---------------------------------------------------------
	jQuery("article").fitVids();

});
jQuery.noConflict();
jQuery(document).ready( function() {

	var windows_width = jQuery(window).width();

	// ---------------------------------------------------------
	// Lightbox
	// ---------------------------------------------------------

	jQuery('.gallery > .gallery-item').magnificPopup({
		delegate: 'a',
		removalDelay: 300,
		type: 'image',
		mainClass: 'mfp-with-zoom',
		gallery: {
			enabled: true
		}
	});

	// ---------------------------------------------------------
	// Toogle for shortcodes
	// ---------------------------------------------------------
	jQuery('div.toggle-info').hide();
	jQuery('h3.toggle-trigger').click(function(e) {
		e.preventDefault();
		jQuery(this).toggleClass("is-active").next().slideToggle("normal");
	});

	// ---------------------------------------------------------
	// Remove empty elements
	// ---------------------------------------------------------
	jQuery('div.fl-thumbnail:empty').remove();
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
	
	// ---------------------------------------------------------
	// Fitvids
	// ---------------------------------------------------------
	jQuery("article").fitVids();

	// ---------------------------------------------------------
	// Superfish Menu
	// ---------------------------------------------------------
	jQuery('ul.navigation-menu').superfish({
		delay: 500,
		animation:   {
			opacity: 'show',
			height: 'show'
		},
		speed: 'fast',
		autoArrows: true
	});

	// ---------------------------------------------------------
	// TOC
	// ---------------------------------------------------------
	var ToC = "<nav role='navigation' class='table-of-contents'>" + "<h2 id='toc' class='alt'><i class='fa fa-bars'></i> Menú</h2>" + "<ul class='toc-list group'>";
	var newLine, el, title, link;
		
	jQuery(".fl-menu ul > li > div.fl-menu-section > h2").each( function() {
		el = jQuery(this);
		id = jQuery(this).parent('div.fl-menu-section');
		title = el.text();
		link = "#" + id.attr("id");
		newLine = "<li class='toc-item'>" + "<a href='" + link + "'>" + title + "</a>" + "</li>";
		ToC += newLine;
	});

	ToC += "</ul>" + "</nav>";

	jQuery("#menu-toc").prepend(ToC);

	jQuery('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			var target = jQuery(this.hash);
			target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				jQuery('html,body').animate({
					scrollTop: target.offset().top
				}, 1000);
				return false;
			}
		}
	});
	
});
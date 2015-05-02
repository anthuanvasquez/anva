if ( typeof jQuery === 'undefined' ) {
	throw new Error( 'JavaScript requires jQuery' )
}

var bp = {
	phones: 320,
	phonem: 480,
	tablets: 750,
	tabletm: 768,
	desktops: 992,
	desktopm: 1200,
	desktopl: 1600
}

jQuery.noConflict();
jQuery(document).ready(function($) {
	
	// ---------------------------------------------------------
	// Enquire JS
	// ---------------------------------------------------------
	enquire.register("screen and (max-width: " + bp.phonem + "px)", {
		match : function() {
			
		},
		unmatch : function() {
			
		}
	});

});

var initialize = {

	// ---------------------------------------------------------
	// Lightbox
	// ---------------------------------------------------------
	Popup: function(target) {
		jQuery(target).magnificPopup({
			delegate: 'a',
			removalDelay: 300,
			type: 'image',
			mainClass: 'mfp-with-zoom',
			titleSrc: 'title',
			gallery: {
				enabled: true
			}
		});
	},

	// ---------------------------------------------------------
	// Scroll go top button
	// ---------------------------------------------------------
	Scroll: function(target) {
		jQuery(window).scroll(function() {
			if (jQuery(this).scrollTop() > 200) {
				jQuery(target).fadeIn(200);
			} else {
				jQuery(target).fadeOut(200);
			}
		});

		jQuery(target).click(function(e) {
			e.preventDefault();
			jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
		});
	},

	// ---------------------------------------------------------
	// Superfish Menu
	// ---------------------------------------------------------
	Menu: function(target, rows) {
		jQuery(target).superfish({
			delay: 500,
			animation:   {
				opacity: 'show',
				height: 'show'
			},
			speed: 'fast',
			cssArrows: false
		});
	},

	// ---------------------------------------------------------
	// Remove empty elements
	// ---------------------------------------------------------
	RemoveEmpty: function(target) {
		jQuery(target + ':empty').remove();
		jQuery(target).filter( function() {
			return jQuery.trim( jQuery(this).html() ) == '';
		}).remove();
	},

	// ---------------------------------------------------------
	// Toogle for shortcodes
	// ---------------------------------------------------------
	Toggle: function() {
		jQuery('div.toggle-info').hide();
		jQuery('h3.toggle-trigger').click(function(e) {
			e.preventDefault();
			jQuery(this).toggleClass("is-active").next().slideToggle("normal");
		});
		jQuery('#mobile-toggle').tooltip();

	},

	// ---------------------------------------------------------
	// TOC
	// ---------------------------------------------------------
	TOC: function() {
		var menu = jQuery("#menu-toc");
		var target = jQuery(".fl-menu ul > li > div.fl-menu-section > h2");
		var html = "<nav role='navigation' class='table-of-contents'>" + "<h2 id='toc' class='alt'><i class='fa fa-bars'></i> Menú</h2>" + "<ul class='toc-list group'>";
		var list, el, title, link;
		
		target.each( function() {
			el = jQuery(this);
			id = jQuery(this).parent('div.fl-menu-section');
			title = el.text();
			link = "#" + id.attr("id");
			list = "<li class='toc-item'>" + "<a href='" + link + "'>" + title + "</a>" + "</li>";
			html += list;
		});

		html += "</ul>" + "</nav>";

		menu.prepend(html);

		jQuery('.fl-menu a[href*=#]:not([href=#])').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				var target = jQuery(this.hash);
				target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
				if (target.length) {
					jQuery('html, body').animate({
						scrollTop: target.offset().top
					}, 1000);
					return false;
				}
			}
		});
	},

	// ---------------------------------------------------------
	// Init Function
	// ---------------------------------------------------------
	Init: function() {

		initialize.Popup('.gallery > .gallery-item, .single .featured-image .thumbnail');
		initialize.Menu('ul.navigation-menu, ul.off-canvas-menu');
		initialize.RemoveEmpty('div.fl-thumbnail');
		initialize.RemoveEmpty('p');
		initialize.Toggle();
		
		if ( 1 == ANVAJS.plugin_foodlist ) {
			initialize.TOC();
		}

		initialize.Scroll('#gotop');

	}

};

jQuery(document).ready(function($) {
	initialize.Init();
});
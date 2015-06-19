if ( typeof jQuery === 'undefined' ) {
	throw new Error( 'JavaScript requires jQuery' )
}

jQuery.noConflict();

var ANVA = ANVA || {};

(function($){

	"use strict";

	// Initial
	ANVA.initialize = {

		init: function() {

			ANVA.initialize.responsiveClasses();
			ANVA.initialize.masonryLayout();
			ANVA.initialize.lightbox();
			ANVA.initialize.menuNavigation();
			ANVA.initialize.menuTrigger();
			ANVA.initialize.removeEmptyEl('div.fl-thumbnail');
			ANVA.initialize.removeEmptyEl('p');
			ANVA.initialize.goToTop();
			ANVA.initialize.paginationButtons();
			
			if ( 1 == ANVAJS.pluginFoodlist ) {
				ANVA.initialize.menuTable();
			}
		},

		responsiveClasses: function() {

			function handlerClass(className) {
				return {
					match : function() {
						_body.addClass(className);
					},
					unmatch : function() {
						_body.removeClass(className);
					}
				};
			}

			enquire.register("screen and (max-width: 10000px) and (min-width: " + ANVAJS.desktop + "px)", handlerClass('device-lg'));
			enquire.register("screen and (max-width: 1199px) and (min-width: " + ANVAJS.laptop + "px)", handlerClass('device-md'));
			enquire.register("screen and (max-width: 991px) and (min-width: " + ANVAJS.tablet + "px)", handlerClass('device-sm'));	
			enquire.register("screen and (max-width: 767px) and (min-width: " + ANVAJS.handheld + "px)", handlerClass('device-sx'));
			enquire.register("screen and (max-width: 479px) and (min-width: 0px)", handlerClass('device-xxs'));

		},

		lightbox: function() {
			var _lightboxImageEl 	= jQuery('[data-lightbox="image"]'),
				_lightboxGalleryEl 	= jQuery('[data-lightbox="gallery"]'),
				_lightboxIframeEl 	= jQuery('[data-lightbox="iframe"]');

			// Image
			if ( _lightboxImageEl.length > 0 ) {
				_lightboxImageEl.magnificPopup({
					type: 'image',
					closeOnContentClick: true,
					closeBtnInside: false,
					fixedContentPos: true,
					mainClass: 'mfp-no-margins mfp-fade', // class to remove default margin from left and right side
					image: {
						verticalFit: true
					}
				});
			}

			// Gallery
			if ( _lightboxGalleryEl.length > 0 ) {
				_lightboxGalleryEl.each(function() {
					var element = jQuery(this);

					element.magnificPopup({
						delegate: 'a[data-lightbox="gallery-item"]',
						type: 'image',
						closeOnContentClick: true,
						closeBtnInside: false,
						fixedContentPos: true,
						mainClass: 'mfp-no-margins mfp-fade', // class to remove default margin from left and right side
						image: {
							verticalFit: true
						},
						gallery: {
							enabled: true,
							navigateByImgClick: true,
							preload: [0,1] // Will preload 0 - before current, and 1 after the current image
						},
						tLoading: 'Loading image #%curr%...',
						image: {
							tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
							titleSrc: function(item) {
								return '<div class="gallery-caption"><h4>' + item.el.attr('title') + '</h4>' + '<p>' + item.el.attr('data-desc') + '</p></div>';
							}
						}
					});
				});
			}

			if ( _lightboxIframeEl.length > 0 ) {
				_lightboxIframeEl.magnificPopup({
					disableOn: 600,
					type: 'iframe',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			}
		},

		masonryLayout: function() {
			var _masonryContainer = jQuery('.gallery-masonry .gallery-content'),
				_masonryItem 				= jQuery('.gallery-item');
			_masonryContainer.isotope();
		},

		goToTop: function() {
			_goTop.click(function(e) {
				e.preventDefault();
				_root.animate({ scrollTop: 0 }, 400 );
			});
		},

		goToTopScroll: function()	{
			_window.scroll(function() {
				if ( _body.hasClass('device-lg') || _body.hasClass('device-md') || _body.hasClass('device-sm') ) {
					if ( jQuery(this).scrollTop() > 450 ) {
						_goTop.fadeIn(200);
					} else {
						_goTop.fadeOut(200);
					}
				}
			});
		},

		menuNavigation: function() {
			_menuNavigation.superfish({
				delay: 500,
				animation:   {
					opacity: 'show',
					height: 'show'
				},
				speed: 'fast',
				cssArrows: true
			});
		},

		menuTrigger: function() {
			var _offCanvasTrigger = jQuery('#off-canvas-trigger'),
				_offCanvas = jQuery('#off-canvas'),
				_primaryMenu = jQuery('#primary-menu'),
				_primaryTrigger = jQuery('#primary-menu-trigger');

			if ( _offCanvas.length > 0 ) {
				_body.addClass('js-ready');
				_offCanvasTrigger.click( function() {
					_offCanvas.toggleClass('is-active');
					_contain.toggleClass('is-active');
					return false;
				});

				_window.on( 'resize', function() {
					if ( _offCanvas.css('display') === 'block' ) {
						_offCanvas.removeClass('is-active');
						_contain.removeClass('is-active');
					}
				});

			} else if ( _primaryMenu.length > 0 ) {
				_primaryTrigger.click( function() {
					_primaryMenu.slideToggle();
					return false;
				});

				_window.on( 'resize', function() {
					if ( _primaryMenu.css('display') === 'none' ) {
						_primaryMenu.css('display', 'block');
					}
				});
			}
		},

		removeEmptyEl: function(selector) {
			jQuery(selector + ':empty').remove();
			jQuery(selector).filter( function() {
				return jQuery.trim( jQuery(this).html() ) == '';
			}).remove();
		},

		paginationButtons: function() {
			if ( _buttonNav.length > 0 ) {
				_buttonNav.addClass('button');
			}
		},

		menuTable: function() {
			var _menuContent 	= jQuery("#menu-toc");
			if ( _menuContent.length > 0 ) {
				var	_menuTitle 		= jQuery(".fl-menu ul > li > div.fl-menu-section > h2"),
					html = "<nav role='navigation' class='table-of-content'><h2 id='toc' class='alt'><i class='fa fa-bars'></i> Menú</h2><ul class='toc-list clearfix'>",
					id,
					list,
					element,
					title,
					link;
				_menuTitle.each( function() {
					element = jQuery(this);
					id 			= jQuery(this).parent('div.fl-menu-section');
					title 	= element.text();
					link 		= "#" + id.attr("id");
					list 		= "<li class='toc-item'><a href='" + link + "'>" + title + "</a></li>";
					html 	 += list;
				});
				html += "</ul></nav>";
				_menuContent.prepend( html );

				var _menuScrollTop 	= jQuery('#menu-toc a, .fl-menu-section h2 a');
				if ( _menuScrollTop.length > 0 ) {
					_menuScrollTop.click(function() {
						_root.animate({
							scrollTop: jQuery( jQuery.attr(this, 'href') ).offset().top
						}, 'slow');
						return false;
					});
				}
			}
		}
	};

	ANVA.widget = {
		
		init: function() {
			ANVA.widget.animations();
			ANVA.widget.counter();
			ANVA.widget.wpCalendar();
			// ANVA.widget.instagramPhotos( ANVA.config.instagramID, ANVA.config.instagramSecret );
			ANVA.widget.toggles();
			ANVA.widget.extras();
		},

		animations: function() {
			var _dataAnimateEl = jQuery('[data-animate]');
			if ( _dataAnimateEl.length > 0 ){
				if ( _body.hasClass('device-lg') || _body.hasClass('device-md') || _body.hasClass('device-sm') ) {
					_dataAnimateEl.each( function(){
						var element = jQuery(this),
							animationDelay = element.attr('data-delay'),
							animationDelayTime = 0;

						if ( animationDelay ) { animationDelayTime = Number( animationDelay ) + 500; } else { animationDelayTime = 500; }

						if ( ! element.hasClass('animated') ) {
							element.addClass('not-animated');
							var elementAnimation = element.attr('data-animate');
							element.appear(function () {
								setTimeout(function() {
									element.removeClass('not-animated').addClass( elementAnimation + ' animated');
								}, animationDelayTime);
							},{ accX: 0, accY: -120 },'easeInCubic');
						}
					});
				}
			}
		},
		
		counter: function() {
			var _counterEl = jQuery('.counter:not(.counter-instant)');
			if ( _counterEl.length > 0 ){
				_counterEl.each(function(){
					var element = jQuery(this);
					var counterElementComma = jQuery(this).find('span').attr('data-comma');
					if ( !counterElementComma ) {
						counterElementComma = false;
					} else {
						counterElementComma = true;
					}
					if ( _body.hasClass('device-lg') || _body.hasClass('device-md' ) ) {
						element.appear( function() {
							ANVA.widget.runCounter( element, counterElementComma );
						}, { accX: 0, accY: -120 },'easeInCubic');
					} else {
						ANVA.widget.runCounter( element, counterElementComma );
					}
				});
			}
		},

		runCounter: function( counterElement, counterElementComma ){
			if ( counterElementComma == true ) {
				counterElement.find('span').countTo({
					formatter: function (value, options) {
						value = value.toFixed(options.decimals);
						value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
						return value;
					}
				});
			} else {
				counterElement.find('span').countTo();
			}
		},

		wpCalendar: function() {
			if ( _wpCalendar.length > 0 ) {
				_wpCalendar.addClass('table table-bordered table-condensed table-responsive').find('tfoot a').addClass('btn btn-default')
			}
		},

		instagramPhotos: function( c_accessToken, c_clientID ) {
			var _instagramPhotosEl = jQuery('.instagram-photos');
			if ( _instagramPhotosEl.length > 0 ) {
				jQuery.fn.spectragram.accessData = {
					accessToken: c_accessToken,
					clientID: c_clientID
				};

				_instagramPhotosEl.each(function() {
					var element = jQuery(this),
						instaGramUsername = element.attr('data-user'),
						instaGramTag 			= element.attr('data-tag'),
						instaGramCount 		= element.attr('data-count'),
						instaGramType 		= element.attr('data-type');

					if ( !instaGramCount ) {
						instaGramCount = 9;
					}

					if ( instaGramType == 'tag' ) {
						element.spectragram('getRecentTagged',{
							query: instaGramTag,
							max: Number( instaGramCount ),
							size: 'medium',
							wrapEachWith: ' '
						});
					} else if ( instaGramType == 'user' ) {
						element.spectragram('getUserFeed',{
							query: instaGramUsername,
							max: Number( instaGramCount ),
							size: 'medium',
							wrapEachWith: ' '
						});
					} else {
						element.spectragram('getPopular',{
							max: Number( instaGramCount ),
							size: 'medium',
							wrapEachWith: ' '
						});
					}
				});
			}
		},

		toggles: function(){
			var _toggle = jQuery('.toggle');
			if ( _toggle.length > 0 ) {
				_toggle.each( function(){
					var element = jQuery(this),
						elementState = element.attr('data-state');

					if ( elementState != 'open' ){
						element.find('.toggle-content').hide();
					} else {
						element.find('.toggle-ttitle').addClass("toggle-title-a");
					}

					element.find('.toggle-title').click(function(){
						jQuery(this).toggleClass('toggle-title-a').next('.toggle-content').slideToggle(300);
						return true;
					});
				});
			}
		},

		linkScroll: function(){
			jQuery("a[data-scrollto]").click(function(){
				var element = jQuery(this),
					divScrollToAnchor = element.attr('data-scrollto'),
					divScrollSpeed = element.attr('data-speed'),
					divScrollOffset = element.attr('data-offset'),
					divScrollEasing = element.attr('data-easing');

					if ( !divScrollSpeed ) { divScrollSpeed = 750; }
					if ( !divScrollOffset ) { divScrollOffset = SEMICOLON.initialize.topScrollOffset(); }
					if ( !divScrollEasing ) { divScrollEasing = 'easeOutQuad'; }

				_root.stop(true).animate({
					'scrollTop': jQuery( divScrollToAnchor ).offset().top - Number(divScrollOffset)
				}, Number(divScrollSpeed), divScrollEasing);

				return false;
			});
		},

		extras: function() {
			jQuery('[data-toggle="tooltip"]').tooltip({
				container: 'body'
			});

			if ( ANVA.isMobile.any() ) {
				_body.addClass('device-touch');
			}
		}
	};

	ANVA.isBrowser = {
		any: function() {
			
		}
	};

	ANVA.isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (ANVA.isMobile.Android() || ANVA.isMobile.BlackBerry() || ANVA.isMobile.iOS() || ANVA.isMobile.Opera() || ANVA.isMobile.Windows());
		}
	};

	ANVA.documentOnReady = {
		
		init: function() {
			ANVA.initialize.init();
			ANVA.widget.init();
			ANVA.isBrowser.any();
			ANVA.documentOnReady.windowScroll();	
		},

		windowScroll: function() {
			_window.on( 'scroll', function() {
				ANVA.initialize.goToTopScroll();
			});
		}
	};

	ANVA.documentOnLoad = {
		
		init: function() {
			// Init document load functions
		}

	};

	ANVA.documentOnResize = {
		
		init: function() {
			
		}

	};

	ANVA.config = {
		instagramID: 			'43dd505ce2c04bd1aa2230726e9300e1',
		instagramSecret: 	'7eceb8870d854d8b999262f0496906ea',
		flickrID: "",
		flickrSecret: ""
	};

	var _window 				= jQuery(window),
		_root 						= jQuery('html, body'),
		_body 						= jQuery('body'),
		_wrapper 					= jQuery('#wrapper'),
		_header 					= jQuery('#header'),
		_contain 					= jQuery('#container'),
		_footer 					= jQuery('#footer'),
		_goTop						= jQuery('#gotop'),
		_menuNavigation 	= jQuery('ul.navigation-menu, ul.off-canvas-menu'),
		_wpCalendar				= jQuery('#wp-calendar'),
		_buttonNav				= jQuery('.next a[rel="next"], .previous a[rel="prev"]');

	jQuery(document).ready( ANVA.documentOnReady.init );
	jQuery(window).load( ANVA.documentOnLoad.init );
	jQuery(window).on( 'resize', ANVA.documentOnResize.init );

})(jQuery);
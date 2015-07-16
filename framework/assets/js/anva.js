if ( typeof jQuery === 'undefined' ) {
	throw new Error( 'JavaScript requires $' )
}

$ = jQuery.noConflict();

var ANVA = ANVA || {};

(function($){

	"use strict";

	// Initial
	ANVA.initialize = {

		init: function() {

			ANVA.initialize.responsiveLogo();
			ANVA.initialize.responsiveClasses();
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

		responsiveLogo: function() {

		},

		responsiveClasses: function() {

			function handlerClass(className) {
				return {
					match : function() {
						$body.addClass(className);
					},
					unmatch : function() {
						$body.removeClass(className);
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
			var $lightboxImageEl 	= $('[data-lightbox="image"]'),
				$lightboxGalleryEl 	= $('[data-lightbox="gallery"]'),
				$lightboxIframeEl 	= $('[data-lightbox="iframe"]');

			// Image
			if ( $lightboxImageEl.length > 0 ) {
				$lightboxImageEl.magnificPopup({
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
			if ( $lightboxGalleryEl.length > 0 ) {
				$lightboxGalleryEl.each(function() {
					var element = $(this);

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
			// Frame
			if ( $lightboxIframeEl.length > 0 ) {
				$lightboxIframeEl.magnificPopup({
					disableOn: 600,
					type: 'iframe',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
			}
		},

		topScrollOffset: function() {
			var topOffsetScroll = 0;

			if ( ( $body.hasClass('device-lg') || $body.hasClass('device-md') ) && !ANVA.isMobile.any() ) {
				if ( $header.hasClass('sticky-header') ) {
					if ( $pagemenu.hasClass('dots-menu') ) { topOffsetScroll = 100; } else { topOffsetScroll = 144; }
				} else {
					if ( $pagemenu.hasClass('dots-menu') ) { topOffsetScroll = 140; } else { topOffsetScroll = 184; }
				}

				if ( !$pagemenu.length ) {
					if ( $header.hasClass('sticky-header') ) { topOffsetScroll = 100; } else { topOffsetScroll = 140; }
				}
			} else {
				topOffsetScroll = 40;
			}

			return topOffsetScroll;
		},

		defineColumns: function( element ){
			var column = 4;

			if( element.hasClass('portfolio-full') ) {
				if( element.hasClass('portfolio-3') ) column = 3;
				else if( element.hasClass('portfolio-5') ) column = 5;
				else if( element.hasClass('portfolio-6') ) column = 6;
				else column = 4;

				if( $body.hasClass('device-sm') && ( column == 4 || column == 5 || column == 6 ) ) {
					column = 3;
				} else if( $body.hasClass('device-xs') && ( column == 3 || column == 4 || column == 5 || column == 6 ) ) {
					column = 2;
				} else if( $body.hasClass('device-xxs') ) {
					column = 1;
				}
			} else if( element.hasClass('masonry-thumbs') ) {

				var lgCol = element.attr('data-lg-col'),
					mdCol = element.attr('data-md-col'),
					smCol = element.attr('data-sm-col'),
					xsCol = element.attr('data-xs-col'),
					xxsCol = element.attr('data-xxs-col');

				if( element.hasClass('col-2') ) column = 2;
				else if( element.hasClass('col-3') ) column = 3;
				else if( element.hasClass('col-5') ) column = 5;
				else if( element.hasClass('col-6') ) column = 6;
				else column = 4;

				if( $body.hasClass('device-lg') ) {
					if( lgCol ) { column = Number(lgCol); }
				} else if( $body.hasClass('device-md') ) {
					if( mdCol ) { column = Number(mdCol); }
				} else if( $body.hasClass('device-sm') ) {
					if( smCol ) { column = Number(smCol); }
				} else if( $body.hasClass('device-xs') ) {
					if( xsCol ) { column = Number(xsCol); }
				} else if( $body.hasClass('device-xxs') ) {
					if( xxsCol ) { column = Number(xxsCol); }
				}

			}

			return column;
		},

		setFullColumnWidth: function( element ){

			if( element.hasClass('portfolio-full') ) {
				var columns = ANVA.initialize.defineColumns( element );
				var containerWidth = element.width();
				if( containerWidth == ( Math.floor(containerWidth/columns) * columns ) ) { containerWidth = containerWidth - 1; }
				var postWidth = Math.floor(containerWidth/columns);
				if( $body.hasClass('device-xxs') ) { var deviceSmallest = 1; } else { var deviceSmallest = 0; }
				element.find(".portfolio-item").each(function(index){
					if( deviceSmallest == 0 && $(this).hasClass('wide') ) { var elementSize = ( postWidth*2 ); } else { var elementSize = postWidth; }
					$(this).css({"width":elementSize+"px"});
				});
			} else if( element.hasClass('masonry-thumbs') ) {
				var columns = ANVA.initialize.defineColumns( element ),
					containerWidth = element.innerWidth(),
					windowWidth = $window.width();
				if( containerWidth == windowWidth ){
					containerWidth = windowWidth*1.004;
					element.css({ 'width': containerWidth+'px' });
				}
				var postWidth = (containerWidth/columns);

				postWidth = Math.floor(postWidth);

				if( ( postWidth * columns ) >= containerWidth ) { element.css({ 'margin-right': '-1px' }); }

				element.children('a').css({"width":postWidth+"px"});

				var firstElementWidth = element.find('a:eq(0)').outerWidth();

				element.isotope({
					masonry: {
						columnWidth: firstElementWidth
					}
				});

				var bigImageNumbers = element.attr('data-big');
				if( bigImageNumbers ) {
					bigImageNumbers = bigImageNumbers.split(",");
					var bigImageNumber = '',
						bigi = '';
					for( bigi = 0; bigi < bigImageNumbers.length; bigi++ ){
						bigImageNumber = Number(bigImageNumbers[bigi]) - 1;
						element.find('a:eq('+bigImageNumber+')').css({ width: firstElementWidth*2 + 'px' });
					}
					var t = setTimeout( function(){
						element.isotope('layout');
					}, 1000 );
				}
			}

		},

		goToTop: function() {
			$goTop.click(function(e) {
				e.preventDefault();
				$root.animate({ scrollTop: 0 }, 400 );
			});
		},

		goToTopScroll: function()	{
			$window.scroll(function() {
				if ( $body.hasClass('device-lg') || $body.hasClass('device-md') || $body.hasClass('device-sm') ) {
					if ( $(this).scrollTop() > 450 ) {
						$goTop.fadeIn(200);
					} else {
						$goTop.fadeOut(200);
					}
				}
			});
		},

		menuNavigation: function() {
			$menuNavigation.superfish({
				popUpSelector: 'ul,.mega-menu-content',
				delay: 250,
				speed: 350,
				animation: {opacity:'show'},
				animationOut:  {opacity:'hide'},
				cssArrows: false
			});
		},

		menuTrigger: function() {
			var $offCanvasTrigger = $('#off-canvas-trigger'),
				$offCanvas = $('#off-canvas'),
				$primaryMenu = $('#primary-menu'),
				$primaryTrigger = $('#primary-menu-trigger');

			if ( $offCanvas.length > 0 ) {
				$body.addClass('js-ready');
				$offCanvasTrigger.click( function() {
					$offCanvas.toggleClass('is-active');
					$contain.toggleClass('is-active');
					return false;
				});

				$window.on( 'resize', function() {
					if ( $offCanvas.css('display') === 'block' ) {
						$offCanvas.removeClass('is-active');
						$contain.removeClass('is-active');
					}
				});

			} else if ( $primaryMenu.length > 0 ) {
				$primaryTrigger.click( function() {
					$primaryMenu.slideToggle();
					return false;
				});

				$window.on( 'resize', function() {
					if ( $primaryMenu.css('display') === 'none' ) {
						$primaryMenu.css('display', 'block');
					}
				});
			}
		},

		removeEmptyEl: function(selector) {
			$(selector + ':empty').remove();
			$(selector).filter( function() {
				return $.trim( $(this).html() ) == '';
			}).remove();
		},

		paginationButtons: function() {
			if ( $buttonNav.length > 0 ) {
				$buttonNav.addClass('button');
			}
		},

		menuTable: function() {
			var $menuContent 	= $("#menu-toc");
			if ( $menuContent.length > 0 ) {
				var	$menuTitle 		= $(".fl-menu ul > li > div.fl-menu-section > h2"),
					html = "<nav role='navigation' class='table-of-content'><h2 id='toc' class='alt'><i class='fa fa-bars'></i> Menú</h2><ul class='toc-list clearfix'>",
					id,
					list,
					element,
					title,
					link;
				$menuTitle.each( function() {
					element = $(this);
					id 			= $(this).parent('div.fl-menu-section');
					title 	= element.text();
					link 		= "#" + id.attr("id");
					list 		= "<li class='toc-item'><a href='" + link + "'>" + title + "</a></li>";
					html 	 += list;
				});
				html += "</ul></nav>";
				$menuContent.prepend( html );

				var $menuScrollTop 	= $('#menu-toc a, .fl-menu-section h2 a');
				if ( $menuScrollTop.length > 0 ) {
					$menuScrollTop.click(function() {
						$root.animate({
							scrollTop: $( $.attr(this, 'href') ).offset().top
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
			var $dataAnimateEl = $('[data-animate]');
			if ( $dataAnimateEl.length > 0 ){
				if ( $body.hasClass('device-lg') || $body.hasClass('device-md') || $body.hasClass('device-sm') ) {
					$dataAnimateEl.each( function(){
						var element = $(this),
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

		loadFlexSlider: function() {
			var $flexSliderEl = $('.flexslider');
			if ( $flexSliderEl.length > 0 ) {
				$flexSliderEl.each(function() {
					var $flexsSlider 	= $(this),
						flexsAnimation 	= $flexsSlider.parent('.fslider').attr('data-animation'),
						flexsEasing 		= $flexsSlider.parent('.fslider').attr('data-easing'),
						flexsDirection 	= $flexsSlider.parent('.fslider').attr('data-direction'),
						flexsSlideshow 	= $flexsSlider.parent('.fslider').attr('data-slideshow'),
						flexsPause 			= $flexsSlider.parent('.fslider').attr('data-pause'),
						flexsSpeed 			= $flexsSlider.parent('.fslider').attr('data-speed'),
						flexsVideo 			= $flexsSlider.parent('.fslider').attr('data-video'),
						flexsPagi 			= $flexsSlider.parent('.fslider').attr('data-pagi'),
						flexsArrows 		= $flexsSlider.parent('.fslider').attr('data-arrows'),
						flexsThumbs 		= $flexsSlider.parent('.fslider').attr('data-thumbs'),
						flexsHover 			= $flexsSlider.parent('.fslider').attr('data-hover'),
						flexsSheight 		= true,
						flexsUseCSS 		= false;

					if ( !flexsAnimation ) {
						flexsAnimation = 'slide';
					}
					if ( !flexsEasing || flexsEasing == 'swing' ) {
						flexsEasing = 'swing';
						flexsUseCSS = true;
					}
					if ( !flexsDirection ) { flexsDirection = 'horizontal'; }
					if ( !flexsSlideshow ) { flexsSlideshow = true; } else { flexsSlideshow = false; }
					if ( !flexsPause ) { flexsPause = 5000; }
					if ( !flexsSpeed ) { flexsSpeed = 600; }
					if ( !flexsVideo ) { flexsVideo = false; }
					if ( flexsDirection == 'vertical' ) { flexsSheight = false; }
					if ( flexsPagi == 'false' ) { flexsPagi = false; } else { flexsPagi = true; }
					if ( flexsThumbs == 'true' ) { flexsPagi = 'thumbnails'; } else { flexsPagi = flexsPagi; }
					if ( flexsArrows == 'false' ) { flexsArrows = false; } else { flexsArrows = true; }
					if ( flexsHover == 'false' ) { flexsHover = false; } else { flexsHover = true; }

					$flexsSlider.flexslider({
						selector: ".slides > li",
						animation: flexsAnimation,
						easing: flexsEasing,
						direction: flexsDirection,
						slideshow: flexsSlideshow,
						slideshowSpeed: Number(flexsPause),
						animationSpeed: Number(flexsSpeed),
						pauseOnHover: flexsHover,
						video: flexsVideo,
						controlNav: flexsPagi,
						directionNav: flexsArrows,
						smoothHeight: flexsSheight,
						useCSS: flexsUseCSS,
						start: function(slider) {
							ANVA.widget.animations();
							slider.parent().removeClass('preloader2');
							$('.flex-prev').html('<i class="fa fa-angle-left"></i>');
							$('.flex-next').html('<i class="fa fa-angle-right"></i>');
						},
					});
				});
			}
		},
		
		counter: function() {
			var $counterEl = $('.counter:not(.counter-instant)');
			if ( $counterEl.length > 0 ){
				$counterEl.each(function(){
					var element = $(this);
					var counterElementComma = $(this).find('span').attr('data-comma');
					if ( !counterElementComma ) {
						counterElementComma = false;
					} else {
						counterElementComma = true;
					}
					if ( $body.hasClass('device-lg') || $body.hasClass('device-md' ) ) {
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

		masonryThumbs: function(){
			var $masonryThumbsEl = $('.masonry-thumbs');
			if( $masonryThumbsEl.length > 0 ){
				$masonryThumbsEl.each( function(){
					var masonryItemContainer = $(this);
					ANVA.widget.masonryThumbsArrange( masonryItemContainer );
				});
			}
		},

		masonryThumbsArrange: function( element ){
			ANVA.initialize.setFullColumnWidth( element );
			element.isotope('layout');
		},

		wpCalendar: function() {
			if ( $wpCalendar.length > 0 ) {
				$wpCalendar.addClass('table table-bordered table-condensed table-responsive').find('tfoot a').addClass('btn btn-default')
			}
		},

		instagramPhotos: function( c$accessToken, c$clientID ) {
			var $instagramPhotosEl = $('.instagram-photos');
			if ( $instagramPhotosEl.length > 0 ) {
				$.fn.spectragram.accessData = {
					accessToken: c$accessToken,
					clientID: c$clientID
				};

				$instagramPhotosEl.each(function() {
					var element = $(this),
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
			var $toggle = $('.toggle');
			if ( $toggle.length > 0 ) {
				$toggle.each( function(){
					var element = $(this),
						elementState = element.attr('data-state');

					if ( elementState != 'open' ){
						element.find('.toggle-content').hide();
					} else {
						element.find('.toggle-ttitle').addClass("toggle-title-a");
					}

					element.find('.toggle-title').click(function(){
						$(this).toggleClass('toggle-title-a').next('.toggle-content').slideToggle(300);
						return true;
					});
				});
			}
		},

		linkScroll: function(){
			$("a[data-scrollto]").click(function(){
				var element = $(this),
					divScrollToAnchor = element.attr('data-scrollto'),
					divScrollSpeed = element.attr('data-speed'),
					divScrollOffset = element.attr('data-offset'),
					divScrollEasing = element.attr('data-easing');

					if ( !divScrollSpeed ) { divScrollSpeed = 750; }
					if ( !divScrollOffset ) { divScrollOffset = ANVA.initialize.topScrollOffset(); }
					if ( !divScrollEasing ) { divScrollEasing = 'easeOutQuad'; }

				$root.stop(true).animate({
					'scrollTop': $( divScrollToAnchor ).offset().top - Number(divScrollOffset)
				}, Number(divScrollSpeed), divScrollEasing);

				return false;
			});
		},

		extras: function() {
			$('[data-toggle="tooltip"]').tooltip({
				container: 'body'
			});

			if ( ANVA.isMobile.any() ) {
				$body.addClass('device-touch');
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
			$window.on( 'scroll', function() {
				ANVA.initialize.goToTopScroll();
			});
		}
	};

	ANVA.documentOnLoad = {
		
		init: function() {
			ANVA.widget.loadFlexSlider();
			ANVA.widget.masonryThumbs();
		}

	};

	ANVA.documentOnResize = {
		
		init: function() {
			ANVA.widget.masonryThumbs();
		}

	};

	ANVA.config = {
		instaID: 			'43dd505ce2c04bd1aa2230726e9300e1',
		instaSecret: 	'7eceb8870d854d8b999262f0496906ea',
		flickrID: "",
		flickrSecret: ""
	};

	var $window 				= $(window),
		$root 						= $('html, body'),
		$body 						= $('body'),
		$wrapper 					= $('#wrapper'),
		$header 					= $('#header'),
		$contain 					= $('#container'),
		$footer 					= $('#footer'),
		$goTop						= $('#gotop'),
		$menuNavigation 	= $('ul.sf-menu'),
		$wpCalendar				= $('#wp-calendar'),
		$buttonNav				= $('.next a[rel="next"], .previous a[rel="prev"]');

	$(document).ready( ANVA.documentOnReady.init );
	$(window).load( ANVA.documentOnLoad.init );
	$(window).on( 'resize', ANVA.documentOnResize.init );

})(jQuery);
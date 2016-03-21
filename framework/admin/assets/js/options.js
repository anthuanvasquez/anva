jQuery(document).ready(function($) {

	"use strict";
	
	// Settings
	var s;

	// Anva Options Object
	var AnvaOptions = {

		// Default Settings
		settings: {
			template: 	$('#page_template'),
			grid: 		$('#meta-grid_column'),
			sidebar: 	$('#meta-sidebar_layout'),
			optionName: $('#option_name').val()
		},

		init: function() {

			// Set Settings
			s = this.settings;

			AnvaOptions.extras();
			AnvaOptions.stickyActions();
			AnvaOptions.sections.init();
		},

		extras: function() {

			// Reset Button
			$(document).on( 'click', '.reset-button', function(e) {
				e.preventDefault();
				var $form = $(this).closest('form');

				swal({
					title: anvaJs.save_button_title,
					text: anvaJs.save_button_text,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#0085ba",
					confirmButtonText: anvaJs.save_button_confirm,
					cancelButtonText: anvaJs.save_button_cancel,
					cancelButtonColor: "#f7f7f7",
					closeOnConfirm: true,
					closeOnCancel: true
				}, function( isConfirm ) {
					
					if ( isConfirm ) {
						$form.append('<input type="hidden" name="reset" value="true" />');
						$form.submit();
					}

				});
			});

			// Load transition
			$('.animsition').animsition({
				inClass: 'fade-in',
				outClass: 'fade-out',
				inDuration: 1500,
				outDuration: 800,
				linkElement: '.animsition-link',
				loading: true,
				loadingParentElement: 'body',
				loadingClass: 'animsition-loading',
				loadingInner: '',
				timeout: false,
				timeoutCountdown: 5000,
				onLoadEvent: true,
				browser: [ 'animation-duration', '-webkit-animation-duration'],
				overlay : false,
				overlayClass : 'animsition-overlay-slide',
				overlayParentElement : 'body',
				transition: function( url ) { window.location.href = url; }
			});

			// Show spinner on submit form
			$('#anva-framework-submit input.button-primary').click( function() {
				$(this).val( anvaJs.save_button );
				$('#anva-framework-submit .spinner').addClass('is-active');
			});

			$('.inner-group > h3').on( 'click', function(e) {
				e.preventDefault();
				var $collapse = $(this).parent().toggleClass('collapse-close');
			});;

			// Hide admin notices
			var $error = $('#anva-framework-wrap .settings-error');
			if ( $error.length > 0 ) {
				setTimeout( function() {
					$error.fadeOut(500);
				}, 3000);
			}

			if ( $('.nav-tab-wrapper').length > 0 ) {
				AnvaOptions.tabs();
			}

		},

		tabs: function() {
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

				// Editor height sometimes needs adjustment when unhidden
				$('.wp-editor-wrap').each(function() {
					var editor_iframe = $(this).find('iframe');
					if ( editor_iframe.height() < 30 ) {
						editor_iframe.css({'height':'auto'});
					}
				});

				$group.hide();
				$(selected).fadeIn();
			});
		},

		stickyActions: function() {
			var $cache = $('#anva-framework .options-settings > .columns-2');
			var $postBox = $('#anva-framework .postbox-wrapper');
			if ( $(window).scrollTop() > 115 ) {
				$cache.css({
					'position': 'absolute',
					'top': 0,
					'right': 0,
					'z-index': 99
				});
				$postBox.css({
					'position': 'fixed',
					'top': '40px'
				});
			} else {
				$cache.css({
					'position': 'static'
				});
				$postBox.css({
					'position': 'static'
				});
			}
		}
	};

	AnvaOptions.sections = {

		init: function() {
			AnvaOptions.sections.colorPicker();
			AnvaOptions.sections.radioImages();
			AnvaOptions.sections.logo();
			AnvaOptions.sections.typography();
			AnvaOptions.sections.socialMedia();
			AnvaOptions.sections.columns();
			AnvaOptions.sections.slider();
			AnvaOptions.sections.rangeSlider();
			AnvaOptions.sections.select();
			AnvaOptions.sections.sidebars();
			AnvaOptions.sections.contactFields();
		},

		colorPicker: function() {
			$('.anva-color').wpColorPicker();
		},

		radioImages: function() {
			$('.anva-radio-img-box').click( function() {
				$(this).closest('.section-images').find('.anva-radio-img-box').removeClass('anva-radio-img-selected');
				$(this).addClass('anva-radio-img-selected');
				$(this).find('.anva-radio-img-radio').prop('checked', true);
			});

			// $('.anva-radio-img-label').hide();
			$('.anva-radio-img-img').show();
			
		},

		logo: function() {
			$('.section-logo').each(function(){
				var el = $(this), value = el.find('.select-type select').val();
				el.find('.logo-item').hide();
				el.find('.' + value).show();
			});

			$('.section-logo .anva-select select').on( 'change', function() {
				var el = $(this), parent = el.closest('.section-logo'), value = el.val();
				parent.find('.logo-item').hide();
				parent.find('.' + value).show();
			});
		},

		typography: function() {
			$('.section-typography .anva-typography-face').each(function() {
				var el = $(this), value = el.val(), text = el.find('option[value="' + value + '"]').text();
				if ( value == 'google' ) {
					el.closest('.section-typography').find('.google-font').fadeIn('fast');
					text = 'Arial';
				} else {
					el.closest('.section-typography').find('.google-font').hide();
				}
				el.closest('.section-typography').find('.sample-text-font').css('font-family', text);
			});

			$('.section-typography .anva-typography-face').on( 'change', function() {
				var el = $(this), value = el.val(), text = el.find('option[value="' + value + '"]').text();
				if ( value == 'google' ) {
					text = 'Arial';
					el.closest('.section-typography').find('.google-font').fadeIn('fast');
				} else {
					el.closest('.section-typography').find('.google-font').hide();
				}
				el.closest('.section-typography').find('.sample-text-font').css('font-family', text);
			});
		},

		socialMedia: function() {
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

			$('.section-social_media .checkbox').on('click', function() {
				var checkbox = $(this);
				if ( checkbox.is(':checked') )
					checkbox.closest('.item').addClass('active').find('.social_media-input').fadeIn('fast');
				else
					checkbox.closest('.item').removeClass('active').find('.social_media-input').hide();
			});
		},

		columns: function() {
			$('.section-columns').each(function(){
				var el = $(this), i = 1, num = el.find('.column-num').val();
				el.find('.column-width').hide();
				el.find('.column-width-'+num).show();
			});

			$('.section-columns .column-num').on('change', function(){
				var el = $(this), i = 1, num = el.val(), parent = el.closest('.section-columns');
				parent.find('.column-width').hide();
				parent.find('.column-width-'+num).fadeIn('fast');
			});
		},

		slider: function() {
			$('.group-slider').each(function() {
				var el = $(this), value = el.find('#slider_id').val();
				el.find('.slider-item').hide();
				el.find('.' + value).show();
			});

			$('.group-slider #slider_id').on( 'change', function() {
				var el = $(this), parent = el.closest('.group-slider'), value = el.val();
				parent.find('.slider-item').hide();
				parent.find('.' + value).show();
			});
		},

		rangeSlider: function() {
			$('.section-range').each(function() {
				var el = $(this),
				value = el.find('.anva-input-range').val(),
				id = el.find('.anva-input-range').attr('id'),
				min = el.find('.anva-input-range').data('min'),
				max = el.find('.anva-input-range').data('max'),
				step = el.find('.anva-input-range').data('step');
				$('#' + id + '_range').slider({
					min: min,
					max: max,
					step: step,
					value: value,
					slide: function( e, ui ) {
						$('#' + id).val( ui.value );
					}
				});
				$('#' + id).val( $('#' + id + '_range').slider( "value" ) );
				$('#' + id + '_range').slider("pips");
				$('#' + id + '_range').slider("float", { pips: true });
			});
		},

		select: function() {
			// Fancy Select
			$('.anva-input-label').each(function(){
				var el = $(this),
					value = el.find('select').val(),
					text = el.find('option[value="' + value + '"]').text();
				el.prepend('<span>' + text + '</span>');
			});

			$('.anva-input-label select').live('change', function(){
				var el = $(this), value = el.val(), text = el.find('option[value="' + value + '"]').text();
				el.closest('.anva-input-label').find('span').text(text);
			});
		},

		sidebars: function() {
			// Remove sidebar
			$('.dynamic-sidebars ul').sortable();
			$('.dynamic-sidebars ul').disableSelection();
			$(document).on( 'click', '.dynamic-sidebars .delete', function(e) {
				e.preventDefault();
				var $ele = $(this).parent();
				swal({
					title: anvaJs.sidebar_button_title,
					text: anvaJs.sidebar_button_text,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#0085ba",
					confirmButtonText: anvaJs.confirm,
					cancelButtonText: anvaJs.cancel,
					cancelButtonColor: "##f7f7f7",
					closeOnConfirm: true,
					closeOnCancel: true
				}, function( isConfirm ) {
					
					if ( isConfirm ) {
						$ele.fadeOut();
						setTimeout( function() {
							$ele.remove();
							if ( $('.dynamic-sidebars ul li').length == 0 ) {
								$('.dynamic-sidebars ul').addClass('empty');
							}
						}, 500 );
					}

				});
			});

			// Add new sidebar
			$('#add-sidebar').click( function() {
				var $new = $('.sidebar').val();
				if ( '' == $new ) {
					swal( anvaJs.sidebar_error_title, anvaJs.sidebar_error_text );
					return false;
				}
				$('.dynamic-sidebars ul').removeClass('empty');
				var $sidebarName = $('#dynamic_sidebar_name').val();
				var $optionName = s.optionName;
				$('.dynamic-sidebars ul').append( '<li>' + $new + ' <a href="#" class="delete">' + anvaJs.delete + '</a> <input type="hidden" name="' + $optionName + '[' + $sidebarName + '][]' + '" value="' + $new + '" /></li>' );
				$('.sidebar').val('');
			});
		},

		contactFields: function() {
			// Contact fields
			$('.dynamic-contact-fields ul.contact-fields').sortable();
			$('.dynamic-contact-fields ul.contact-fields').disableSelection();
			$(document).on( 'click', '.dynamic-contact-fields .delete', function(e) {
				e.preventDefault();
				var $ele = $(this).parent();
				swal({
					title: anvaJs.contact_button_title,
					text: anvaJs.contact_button_text,
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#0085ba",
					confirmButtonText: anvaJs.confirm,
					cancelButtonText: anvaJs.cancel,
					cancelButtonColor: "##f7f7f7",
					closeOnConfirm: true,
					closeOnCancel: true
				}, function( isConfirm ) {
					if ( isConfirm ) {
						$ele.fadeOut();
						setTimeout( function() {
							$ele.remove();
							if ( $('.dynamic-contact-fields ul li').length == 0 ) {
								$('.dynamic-contact-fields ul').addClass('empty');
							}
						}, 500 );
					}
				});
			});
			
			$(document).on( 'click', '#add-contact-field', function() {
				var $new = $('#contact_fields option:selected').text();
				var $value = $('#contact_fields option:selected').val();

				if ( '' == $new ) {
					swal( anvaJs.contact_error_title, anvaJs.contact_error_text );
					return false;
				}
				if ( $('.dynamic-contact-fields ul.contact-fields').children('#field-' + $value ).length > 0 ) {
					swal( anvaJs.contact_exists_title, anvaJs.contact_exists_text + ' "' + $new + '".' );
					return false;
				}
				$('.dynamic-contact-fields ul').removeClass('empty');
				var $contactFieldName = $('#contact_field_name').val();
				var $optionName = s.optionName;
				$('.dynamic-contact-fields ul').append( '<li id="field-' + $value + '">' + $new + ' <a href="#" class="delete">' + anvaJs.delete + '</a> <input type="hidden" name="' + $optionName + '[' + $contactFieldName + '][]' + '" value="' + $value + '" /></li>' );
				$('.sidebar').val('');
			});
		}
	};

	AnvaOptions.init();

	// Window scroll change
	$(window).scroll(function() {
		AnvaOptions.stickyActions();
	});
	
});
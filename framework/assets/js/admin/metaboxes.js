var ANVAMETA = ANVAMETA || {};

(function($) {

	"use strict";

	ANVAMETA.initialize = {
		init: function() {
			ANVAMETA.initialize.change();
			ANVAMETA.initialize.enable();
			ANVAMETA.initialize.tabs();
		},

		change: function() {
			var $template = $("#page_template");
			if ( $template.length > 0 ) {
				ANVAMETA.initialize.validate( $template.val() );
				$template.live( "change", function() {
					ANVAMETA.initialize.validate( $(this).val() );
				});
			}
		},

		enable: function() {
			var $active = $('.enable-builder');
			if ( $active.length > 0 ) {
				ANVAMETA.initialize.enableCheck($active);
				$active.live( 'change', function() {
					ANVAMETA.initialize.enableCheck($active);
				});
			}
		},

		enableCheck: function( target ) {
			if ( target.is(':checked') ) {
				$('.meta-content-builder').fadeIn();
				$('.meta-content-builder-export').fadeIn();
				$('#postdivrich').fadeOut();
			} else {
				$('.meta-content-builder').fadeOut();
				$('.meta-content-builder-export').fadeOut();
				$('#postdivrich').fadeIn();
			}
		},

		validate: function( val ) {
			var $inputGrid = $("#meta-grid_column"),
			 		$inputSidebar = $("#meta-sidebar_layout");

			if ( 'template_grid.php' == val ) {
				$inputGrid.show();
			} else {
				$inputGrid.hide();
			}
			
			if ( 'default' == val || 'template_list.php' == val || 'template_archives.php' == val || 'template_grid.php' == val ) {
				$inputSidebar.show();
			} else {
				$inputSidebar.hide();
			}
		},

		tabs: function() {
			if ( $('.nav-tab-wrapper').length > 0 ) {
				ANVAMETA.initialize.navTabs();
			}
		},

		navTabs: function() {
			var $group = $('.meta-group'),
				$navtabs = $('.nav-tab-wrapper a'),
				active_tab = '';

			// Hides all the .meta-group sections to start
			$group.hide();

			// Find if a selected tab is saved in localStorage
			if ( typeof(localStorage) != 'undefined' ) {
				active_tab = localStorage.getItem('meta_active_tab');
			}

			// If active tab is saved and exists, load it's .meta-group
			if ( active_tab != '' && $(active_tab).length ) {
				$(active_tab).fadeIn();
				$(active_tab + '-tab').addClass('nav-tab-active');
			} else {
				$('.meta-group:first').fadeIn();
				$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
			}

			// Bind tabs clicks
			$navtabs.click(function(e) {
				e.preventDefault();

				// Remove active class from all tabs
				$navtabs.removeClass('nav-tab-active');

				$(this).addClass('nav-tab-active').blur();

				if (typeof(localStorage) != 'undefined' ) {
					localStorage.setItem('meta_active_tab', $(this).attr('href') );
				}

				var selected = $(this).attr('href');

				$group.hide();
				$(selected).fadeIn();
			});
		}
	};

	ANVAMETA.widgets = {

		init: function() {
			ANVAMETA.widgets.picker();
			ANVAMETA.widgets.repeatable();
		},

		picker: function() {
			if ( $(".meta-date-picker").length > 0 ) {
				$(".meta-date-picker").datepicker();
			}
		},

		repeatable: function() {
			if ( $('.field-repeatable').length > 0 ) {
				$('.repeatable-add').click( function() {
					field = $(this).closest('.meta-controls').find('.custom_repeatable li:last').clone(true);
					fieldLocation = $(this).closest('.meta-controls').find('.custom_repeatable li:last');
					$('input', field).val('').attr('name', function(index, name) {
						return name.replace(/(\d+)/, function(fullMatch, n) {
							return Number(n) + 1;
						});
					});
					field.insertAfter(fieldLocation, $(this).closest('.meta-controls'))
					return false;
				});
			 
				$('.repeatable-remove').click( function() {
					var numInput = $(":input[id^=custom_repeatable]").length;
					if (numInput !== 1) {
						$(this).parent().remove();
						return false;
					}
				});
				
				if ( $('.custom_repeatable').length > 0 ) {
					$('.custom_repeatable').sortable({
						opacity: 0.6,
						revert: true,
						cursor: 'move',
						handle: '.sort'
					});
				}
			}
		}
	};

	ANVAMETA.documentOnReady = {
		init: function() {
			ANVAMETA.initialize.init();
			ANVAMETA.widgets.init();
		}
	};

	$(document).ready( ANVAMETA.documentOnReady.init );

})(jQuery);
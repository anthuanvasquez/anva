jQuery(document).ready(function($) {

	"use strict";
	
	// Settings
	var s;
	
	// Anva Meta Object
	var ANVA_META = {

		// Default Settings
		settings: {
			template: 		$('#page_template'),
			layout: 		$('#sidebar_layout'),
			grid: 			$('#section-grid_column'),
			sidebar: 		$('#section-sidebar_layout'),
			locationRight: 	$('.sidebar-layout .item-right'),
			locationLeft: 	$('.sidebar-layout .item-left')
		},

		init: function() {

			// Set Settings
			s = this.settings;

			ANVA_META.pageTemplate();
			ANVA_META.sidebarLayout();
			ANVA_META.datePicker();
			ANVA_META.spinner();
			ANVA_META.select();
		},

		sidebarLayout: function() {
			if ( s.layout.length > 0 ) {
				s.layout.on( 'change', function() {
					ANVA_META.checkLayout( s.layout.val() );
				}).trigger('change');
			}
		},

		checkLayout: function( val ) {
			switch ( val ) {
				case 'double':
				case 'double_right':
				case 'double_left':
					s.locationRight.show();
					s.locationLeft.show();
					break;
				
				case 'right':
					s.locationRight.show();
					s.locationLeft.hide();
					break;

				case 'left':
					s.locationRight.hide();
					s.locationLeft.show();
					break;

				case '':
				case 'fullwidth':
					s.locationRight.hide();
					s.locationLeft.hide();
					break;
			}
		},

		pageTemplate: function() {
			if ( s.template.length > 0 ) {
				s.template.on( 'change', function() {
					ANVA_META.checkTemplate( s.template.val() );
				}).trigger('change');
			}
		},

		checkTemplate: function( val ) {

			var templates = [
				'default', // Default template
				'template_archives.php',
				'template_contact-form.php',
				'template_list.php'
			];

			// Show grid option
			if ( 'template_grid.php' == val ) {
				s.grid.show();
			} else {
				s.grid.hide();
			}

			// Show sidebar layout option
			if ( -1 != $.inArray( val, templates ) ) {
				s.sidebar.show();
			} else {
				s.sidebar.hide();
			}
		},

		spinner: function() {
			if ( $('.anva-spinner').length > 0 ) {
				$('.anva-spinner').spinner();
			}
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

		datePicker: function() {
			if ( $('.anva-datepicker').length > 0 ) {
				$('.anva-datepicker').datepicker({
					showAnim: 'slideDown',
					dateFormat: 'd MM, yy'
				});
			}
		}
	};

	ANVA_META.init();

});
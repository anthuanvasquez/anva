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
			ANVA_META.sidebarLayout();
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
		}
	};

	ANVA_META.init();

});
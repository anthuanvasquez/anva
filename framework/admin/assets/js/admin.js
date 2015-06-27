// if ( typeof jQuery === 'undefined' ) {
// 	throw new Error( 'JavaScript requires jQuery' )
// }

//$.noConflict();

var ANVAMETA = ANVAMETA || {};

(function($) {

	"use strict";

	ANVAMETA.initialize = {
		init: function() {
			ANVAMETA.initialize.change();
		},

		change: function() {
			var $template = $("#page_template");
			ANVAMETA.initialize.validate( $template.val() );
			$template.on( "change", function() { ANVAMETA.initialize.validate( $(this).val() ); });
		},

		validate: function( val ) {
			var $inputGrid = $(".meta-input-post-grid"),
			 		$inputSidebar = $(".meta-input-sidebar-layout");

			if ( 'template_grid.php' == val ) {
				$inputGrid.show();
			} else {
				$inputGrid.hide();
			}
			
			if ( 'default' == val || 'template_list.php' == val ) {
				$inputSidebar.show();
			} else {
				$inputSidebar.hide();
			}
		}
	};

	ANVAMETA.documentOnReady = {
		init: function() {
			ANVAMETA.initialize.init();
		}
	};

	$(document).ready( ANVAMETA.documentOnReady.init );

})(jQuery);
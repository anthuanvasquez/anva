if ( typeof jQuery === 'undefined' ) {
	throw new Error( 'JavaScript requires jQuery' )
}

$ = jQuery.noConflict();

var ANVAMETA = ANVAMETA || {};

(function($) {

	"use strict";

	ANVAMETA.initialize = {
		init: function() {
			ANVAMETA.initialize.change();
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
		}
	};

	ANVAMETA.documentOnReady = {
		init: function() {
			ANVAMETA.initialize.init();
		}
	};

	$(document).ready( ANVAMETA.documentOnReady.init );

})(jQuery);

jQuery(function(jQuery) {

	// Datepicker
	if ( jQuery(".meta-date-picker").length > 0 ) {
		jQuery(".meta-date-picker").datepicker();
	}
	
	// Upload
	jQuery('.custom_upload_image_button').click( function() {
		formfield = jQuery(this).siblings('.custom_upload_image');
		preview = jQuery(this).siblings('.custom_preview_image');
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			classes = jQuery('img', html).attr('class');
			id = classes.replace(/(.*?)wp-image-/, '');
			formfield.val(id);
			preview.attr('src', imgurl);
			tb_remove();
		}
		return false;
	});
	 
	jQuery('.custom_clear_image_button').click( function() {
		var defaultImage = jQuery(this).parent().siblings('.custom_default_image').text();
		jQuery(this).parent().siblings('.custom_upload_image').val('');
		jQuery(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);
		return false;
	});


	// Repeatable
	jQuery('.repeatable-add').click( function() {
		field = jQuery(this).closest('.meta-controls').find('.custom_repeatable li:last').clone(true);
		fieldLocation = jQuery(this).closest('.meta-controls').find('.custom_repeatable li:last');
		jQuery('input', field).val('').attr('name', function(index, name) {
			return name.replace(/(\d+)/, function(fullMatch, n) {
				return Number(n) + 1;
			});
		});
		field.insertAfter(fieldLocation, jQuery(this).closest('.meta-controls'))
		return false;
	});
 
	jQuery('.repeatable-remove').click( function() {
		var numInput = jQuery(":input[id^=custom_repeatable]").length;
		if (numInput !== 1) {
			jQuery(this).parent().remove();
			return false;
		}
	});
	
	if ( jQuery('.custom_repeatable').length > 0 ) {
		jQuery('.custom_repeatable').sortable({
			opacity: 0.6,
			revert: true,
			cursor: 'move',
			handle: '.sort'
		});
	}
 
});
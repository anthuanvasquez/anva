jQuery(document).ready(function($) {

	'use strict';

	var anva_media_upload, anva_media_selector;

	function anva_media_add_file( event, selector ) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		
		anva_media_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( anva_media_upload ) {
			anva_media_upload.open();
		} else {
			// Create the media frame.
			anva_media_upload = wp.media.frames.anva_media_upload =  wp.media({
				// Set the title of the modal.
				title: $el.data('choose'),

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: $el.data('update'),
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			anva_media_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = anva_media_upload.state().get('selection').first();
				anva_media_upload.close();
				anva_media_selector.find('.upload').val( attachment.attributes.url );
				
				if ( attachment.attributes.type == 'image' ) {
					anva_media_selector.find('.screenshot').empty().hide().append( '<img src="' + attachment.attributes.url + '"><a class="remove-image">X</a>' ).slideDown('fast').addClass('has-image');
				}

				anva_media_selector.find('.upload-button').unbind().addClass('remove-file').removeClass('upload-button').val( anvaMediaJs.remove );
				anva_media_selector.find('.anva-background-properties').slideDown();
				anva_media_selector.find('.remove-image, .remove-file').on( 'click', function() {
					anva_media_remove_file( $(this).parents('.section') );
				});
			});
		}

		// Finally, open the modal
		anva_media_upload.open();
	}

	function anva_media_remove_file( selector ) {
		
		selector.find('.remove-image').hide();
		selector.find('.upload').val('');
		selector.find('.anva-background-properties').hide();
		selector.find('.screenshot').slideUp().removeClass('has-image');
		selector.find('.remove-file').unbind().addClass('upload-button').removeClass('remove-file').val( anvaMediaJs.upload);
		
		// We don't display the upload button if .upload-notice is present
		// This means the user doesn't have the WordPress 3.5 Media Library Support
		if ( $('.section-upload .upload-notice').length > 0 ) {
			$('.upload-button').remove();
		}

		selector.find('.upload-button').on( 'click', function( event ) {
			anva_media_add_file( event, $(this).closest('.section') );
		});
	}

	$('.remove-image, .remove-file').on( 'click', function() {
		anva_media_remove_file( $(this).closest('.section') );
	});

	$('.upload-button').click( function( event ) {
		anva_media_add_file( event, $(this).closest('.section') );
	});

	// Check if each section upload has image
	$('.section-upload, .section-background').each(function() {
		var el = $(this),
		screen = el.find('.screenshot'),
		image = screen.find('img');

		if ( image.length > 0 ) {
			screen.addClass('has-image');
		}
	});

});
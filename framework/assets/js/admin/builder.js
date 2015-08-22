// Implement JSON.stringify serialization
JSON.stringify = JSON.stringify || function (obj) {
	var t = typeof (obj);
	
	if ( t != "object" || obj === null ) {
		
		// Simple data type
		if ( t == "string" ) {
			obj = '"' + obj + '"';
		}
		
		return String( obj );
	
	} else {
		
		// Recurse array or object
		var n, v, json = [], arr = ( obj && obj.constructor == Array );
		
		for ( n in obj ) {
			v = obj[n];
			t = typeof(v);

			if ( t == "string" ) {
				v = '"'+v+'"';
			} else if ( t == "object" && v !== null ) {
				v = JSON.stringify( v );
			}
			
			json.push( ( arr ? "" : '"' + n + '":' ) + String( v ) );
		}
		return ( arr ? "[" : "{" ) + String( json ) + ( arr ? "]" : "}" );
	}
};

(function($) {

	var rand = jQuery.now();
	$("#tabs-1 ul li").draggable({
		connectToSortable: '#builder-sortable-items',
		cursor: 'move',
		revert: 'invalid',
		helper: function () {
			
			var cloned;
			var $targetSelect = $('#anva_options');
			var $targetTitle  = $('#anva_options_title');
			var $targetImage  = $('#anva_options_image');
			
			randomId 			= rand;
			myCheckId 		= $targetSelect.val();
			myCheckTitle 	= $targetTitle.val();
			postType 			= $('#anva_post_type').val();
			myImage 			= $targetImage.val();
			
			if ( myCheckId != '' ) {
				
				var builderItemData = {};
				
				builderItemData.id = randomId;
				builderItemData.shortcode = myCheckId;
				builderItemData.ppb_text_title = myCheckTitle;
				builderItemData.ppb_text_content = '';
				builderItemData.ppb_header_content = '';
				
				var builderItemDataJSON = JSON.stringify( builderItemData );
				var editURL  = ANVA.ajaxurl + '?action=pp_ppb&ppb_post_type=' + $postType + '&shortcode=' + myCheckId + '&rel=' + $randomId;

				builderItem  = '<li id="' + randomId + '" class="item item-' + $randomId + ' ' + myCheckId + ' ui-state-default one" data-current-size="one">';
				builderItem += '<div class="actions">';
				builderItem += '<a href="' + editURL + '" class="button-edit" data-rel="' + $randomId + '"></a>';
				builderItem += '<a href="#" class="button-remove"></a>';
				builderItem += '</div>';
				builderItem += '<div class="thumbnail">';
				builderItem += '<img src="' + myImage + '" alt="' + myCheckTitle + '" />';
				builderItem += '</div>';
				builderItem += '<div class="title">';
				builderItem += '<span class="shortcode-type">' + myCheckTitle + '</span>';
				builderItem += '<span class="shortcode-title"></span>';
				builderItem += '</div>';
				builderItem += '<input type="hidden" class="ppb_setting_columns" value="one_fourth"/>';
				builderItem += '<div class="clear"></div>';
				builderItem += '</li>';

				cloned = builderItem;
			}
			
			return cloned;
		},
		start: function( event, ui ) {
		
		},
		stop: function( event, ui ) {

		}
	});

	$('.tooltip').tooltipster({
		animation: 'grow',
		delay: 200,
		maxWidth: 200,
		theme: 'tooltipster-light',
		touchDevices: true,
		trigger: 'hover'
	});
	
	// Tabs
	$('#elements-tabs, #export-tabs').tabs({
		hide: {
			effect: "fade",
			duration: 400
		},
		show: {
			effect: "fade",
			duration: 400
		}
	});

	// Sort Items
	$( '.builder-sortable-items' ).sortable({
		placeholder: 'ui-state-highlight',
		revert: true
	});
	
	// Disable item selection
	$( '.builder-sortable-items' ).disableSelection();

	// Thumbnail selected
	var $element = $('.builder-elements li');
	$element.on( 'click', function(e) {
		e.preventDefault();
		$element.removeClass('selected');
		$(this).addClass('selected');
		var $elementId = $(this).data('element');
		var $elementTitle = $(this).data('title');
		var $elementImage = $(this).find('img').attr('src');
		$('#anva_options').val( $elementId );
		$('#anva_options_title').val( $elementTitle );
		$('#anva_options_image').val( $elementImage );
	});

	// Add Item
	$('#add-builder-item').on( 'click', function(e) {
		e.preventDefault();

		if ( '' == $('#anva_options').val() ) {
			alert( ANVA.builder_empty_options );
			return false;
		}
		
		var $randomId 	= jQuery.now();
		var $shortcode 	= $('#anva_options').val();
		var $title 			= $('#anva_options_title').val();
		var $image 			= $('#anva_options_image').val();
		var $postType 	= $('#anva_post_type').val();
		
		if ( $shortcode != '' ) {
			
			var builderItemData = {};
			
			builderItemData.id 							= $randomId;
			builderItemData.shortcode 			= $shortcode;
			builderItemData.text_title 			= $title;
			builderItemData.text_content 		= '';
			builderItemData.header_content 	= '';
			
			var builderItemDataJSON = JSON.stringify( builderItemData );
			var ajaxEditURL  = ANVA.ajaxurl + '?action=pp_ppb&ppb_post_type=' + $postType + '&shortcode=' + $shortcode + '&rel=' + $randomId;

			builderItem  = '<li id="' + $randomId + '" class="item item-' + $randomId + ' ' + $shortcode + ' ui-state-default" data-current-size="one">';
			builderItem += '<div class="actions">';
			builderItem += '<a href="' + ajaxEditURL + '" class="button-edit" data-rel="' + $randomId + '"></a>';
			builderItem += '<a href="#" class="button-remove"></a>';
			builderItem += '</div>';
			builderItem += '<div class="thumbnail">';
			builderItem += '<img src="' + $image + '" alt="' + $title + '" />';
			builderItem += '</div>';
			builderItem += '<div class="title">';
			builderItem += '<span class="shortcode-type">' + $title + '</span>';
			builderItem += '<span class="shortcode-title"></span>';
			builderItem += '</div>';
			builderItem += '<span class="spinner spinner-' + $randomId + '"></span>';
			builderItem += '<input type="hidden" class="ppb_setting_columns" value="one_fourth"/>';
			builderItem += '<div class="clear"></div>';
			builderItem += '</li>';

			$('#builder-sortable-items').append( builderItem );
			$('#builder-sortable-items').removeClass('empty');
			$('#' + $randomId).data( 'anva_builder_settings', builderItemDataJSON );
			
			if ( $shortcode != 'divider' && $shortcode != 'empty_line' ) {
				$('#' + $randomId).find('.button-edit').trigger('click');
			}

			$('html, body').animate({
				scrollTop: $('#' + $randomId).offset().top - 32
			}, 1000);
			
		}
	});

	// Remove Item
	$(document).on( 'click', '#builder-sortable-items li a.button-remove', function(e) {
		e.preventDefault();
		var $parentEle = $(this).parent('.actions').parent('li');
		if ( confirm( 'Are you sure you want to delete this item?' ) ) {
			$parentEle.remove();
			
			setTimeout( function() {
				if ( $('#builder-sortable-items li').length == 0 ) {
					$('#builder-sortable-items').addClass('empty');
				}
			}, 500 );
		}
	});
	
	// Edit Item
	$(document).on( 'click', '#builder-sortable-items li .actions a.button-edit', function(e) {
		e.preventDefault();
		
		var ele 			= $(this).parent('.actions').parent('li'),
				id 				= ele.attr('id'),
				itemInner = $('#item-inner-' + id);
		
		if ( itemInner.length == 0 ) {
			$('#anva_inline_current').attr( 'value', $(this).attr('data-rel') );

			var actionURL = $(this).attr('href');

			ele.find('span.spinner').css('visibility', 'visible');
			
			var ajaxCall = $.ajax({
				type: "GET",
				cache: false,
				url: actionURL,
				data: '',
				success: function (data) {
					ele.append('<div id="item-inner-' + id + '" class="item-inner item-inner-'+ id +'" style="display:none;">' + data + '</div>');
					$('#' + id).addClass('has-inline-content');
				} 
			});

			$.when( ajaxCall ).then( function() {
				$('#item-inner-' + id).slideToggle();
				ele.find('span.spinner').css('visibility', 'hidden');

				// Inputs
				$("#ppb_inline :input").each( function() {
					if ( typeof $(this).attr('id') != 'undefined' ) {
						$(this).attr( 'value', '' );
					}
				});
				
				// Color Picker
				$('.colorpicker').wpColorPicker();

				// HTML5 Range
				$('.rangeslider').change( function() {
					var el, newPoint, newPlace, offset;
					el = $(this);
					width = el.width();
					newPoint = ( el.val() - el.attr("min") ) / ( el.attr("max") - el.attr("min") );
					el.next("output").text( el.val() );
				}).trigger('change');

				$( '.builder-sortable-items' ).enableSelection();

				// Scroll to item
				$('html, body').animate({
					scrollTop: $('#' + id).offset().top - 32
				}, 1000);
				

			});

		} else {
			$('#item-inner-' + id).slideToggle();
		}
		
	});

	// Uploader
	$(document).on( 'click', '.metabox_upload_btn', function(e) {
		var formfield = '';
		formfield = $(this).attr('rel');
		var send_attachment_bkp = wp.media.editor.send.attachment;
		wp.media.editor.send.attachment = function( props, attachment ) {
			$('#' + formfield).attr( 'value', attachment.url );
			$('<img src="'+attachment.url+'" />').insertAfter('#' + formfield + '_button');
			wp.media.editor.send.attachment = send_attachment_bkp;
		}
		wp.media.editor.open();
		return false;
	});
	
	// Submit Items
	$('#publish').on( 'click', function(e) {
		$("#builder-sortable-items > li").each( function() {
			$(this).append( '<textarea style="display:none" id="' + $(this).attr('id') + '_data" name="' + $(this).attr('id') + '_data">' + $(this).data('anva_builder_settings') + '</textarea>');
			$(this).append( '<input style="display:none" type="text" id="' + $(this).attr('id') + '_size" name="' + $(this).attr('id') + '_size" value="' + $(this).attr('data-current-size') + '"/>');
		});
		
		var itemOrder = $("#builder-sortable-items").sortable('toArray');
		$('#anva_form_data_order').attr('value', itemOrder);
	});
			
	$('body').on( 'click', '#wp-link-submit', function(e) {
		var linkAtts = wpLink.getAttrs();
		// Get the href attribute and add to a
		// textfield or use as you see fit
		$('#'+wpLink.inputid).val(linkAtts.href);
		wpLink.textarea = $('body');
		wpLink.close();
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		e.stopPropagation();
		return false;
	});
		
	$('body').on( 'click', '#wp-link-cancel, #wp-link-close', function(e) {
		wpLink.textarea = $('body');
		wpLink.close();
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		e.stopPropagation();
		return false;
	});

})(jQuery);
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
		connectToSortable: '#content_builder_sort',
		cursor: 'move',
		revert: 'invalid',
		helper: function () {
			
			var cloned;
			var $targetSelect = $('#ppb_options');
			var $targetTitle  = $('#ppb_options_title');
			var $targetImage  = $('#ppb_options_image');
			
			randomId 			= rand;
			myCheckId 		= $targetSelect.val();
			myCheckTitle 	= $targetTitle.val();
			postType 			= $('#ppb_post_type').val();
			myImage 			= $targetImage.val();
			
			if ( myCheckId != '' ) {
				
				var builderItemData = {};
				
				builderItemData.id = randomId;
				builderItemData.shortcode = myCheckId;
				builderItemData.ppb_text_title = myCheckTitle;
				builderItemData.ppb_text_content = '';
				builderItemData.ppb_header_content = '';
				
				var builderItemDataJSON = JSON.stringify( builderItemData );
				var editURL  = ANVA_VARS.ajaxurl + '?action=pp_ppb&ppb_post_type=' + postType + '&shortcode=' + myCheckId + '&rel=' + randomId;

				builderItem  = '<li id="' + randomId + '" class="item item-' + randomId + ' ' + myCheckId + ' ui-state-default one" data-current-size="one">';
				builderItem += '<div class="actions">';
				builderItem += '<a href="' + editURL + '" class="ppb_edit" data-rel="' + randomId + '"></a>';
				builderItem += '<a href="#" class="ppb_remove"></a>';
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

				// if ( myCheckId != 'ppb_divider' && myCheckId != 'ppb_empty_line' ) {
				// 	$('#' + randomId).find('.ppb_edit').trigger('click');
				// }

				// $('html, body').animate({
				// 	scrollTop: $('#' + randomId).offset().top - 32
				// }, 1000);
		
			}
			
			return cloned;
		},
		start: function( event, ui ) {
		
		},
		stop: function( event, ui ) {
			// alert(rand);
			// var id = cloned.attr('id');
			// alert('done');
		}
	});
	
	// Import / Export
	$('#ppb_export_current_button').on( 'click', function() {
		$('#ppb_export_current').val( 1 );
	});
	
	$('#ppb_import_current_button').on( 'click', function() {
		$('#ppb_import_current').val( 1 );
	});
	
	// Tabs
	$('#modules_tabs, #export_tabs').tabs({
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
	$( '.ppb_sortable' ).sortable({
		placeholder: 'ui-state-highlight',
		revert: true
	});
	
	// Disable item selection
	$( '.ppb_sortable' ).disableSelection();

	// Thumbnail selected
	var $moduleWrapper = $('#ppb_module_wrapper li');
	$moduleWrapper.on( 'click', function(e) {
		e.preventDefault();
		$moduleWrapper.removeClass('selected');
		$(this).addClass('selected');
		var moduleSelectedId = $(this).data('module');
		var moduleSelectedTitle = $(this).data('title');
		var moduleSelectedImage = $(this).find('img').attr('src');	
		$('#ppb_options').val( moduleSelectedId );
		$('#ppb_options_title').val( moduleSelectedTitle );
		$('#ppb_options_image').val( moduleSelectedImage );
	});

	// Add Item
	$('#ppb_sortable_add_button').on( 'click', function(e) {
		e.preventDefault();
		
		var $targetSelect = $('#ppb_options');
		var $targetTitle  = $('#ppb_options_title');
		var $targetImage  = $('#ppb_options_image');
		
		randomId 			= jQuery.now();
		myCheckId 		= $targetSelect.val();
		myCheckTitle 	= $targetTitle.val();
		postType 			= $('#ppb_post_type').val();
		myImage 			= $targetImage.val();
		
		if ( myCheckId != '' ) {
			
			var builderItemData = {};
			
			builderItemData.id = randomId;
			builderItemData.shortcode = myCheckId;
			builderItemData.ppb_text_title = myCheckTitle;
			builderItemData.ppb_text_content = '';
			builderItemData.ppb_header_content = '';
			
			var builderItemDataJSON = JSON.stringify( builderItemData );
			var editURL  = ANVA_VARS.ajaxurl + '?action=pp_ppb&ppb_post_type=' + postType + '&shortcode=' + myCheckId + '&rel=' + randomId;

			builderItem  = '<li id="' + randomId + '" class="item-' + myCheckId + ' ui-state-default one" data-current-size="one">';
			builderItem += '<div class="actions">';
			builderItem += '<a href="' + editURL + '" class="ppb_edit" data-rel="' + randomId + '"></a>';
			builderItem += '<a href="#" class="ppb_remove"></a>';
			builderItem += '</div>';
			builderItem += '<div class="thumbnail">';
			builderItem += '<img src="' + myImage + '" alt="' + myCheckTitle + '" />';
			builderItem += '</div>';
			builderItem += '<div class="title">';
			builderItem += '<span class="shortcode-type">' + myCheckTitle + '</span>';
			builderItem += '<span class="shortcode-title"></span>';
			builderItem += '</div>';
			builderItem += '<span class="spinner spinner-' + randomId + '"></span>';
			builderItem += '<input type="hidden" class="ppb_setting_columns" value="one_fourth"/>';
			builderItem += '<div class="clear"></div>';
			builderItem += '</li>';

			$('#content_builder_sort').append( builderItem );
			$('#content_builder_sort').removeClass('empty');
			$('#' + randomId).data('ppb_setting', builderItemDataJSON);
			
			// var prev1Li = $('#'+randomId).prev();
			// var prev2Li = prev1Li.prev();
			// var prev3Li = prev2Li.prev();
				
			// if ( prev1Li.attr('data-current-size') == 'one_third' && prev2Li.attr('data-current-size') == 'one_third' ) {
			// 	$('#'+randomId).attr('data-current-size', 'one_third last');
			// 	$('#'+randomId).find('.ppb_setting_columns').attr('value', 'one_third last');
			// }
			
			if ( myCheckId != 'ppb_divider' && myCheckId != 'ppb_empty_line' ) {
				$('#' + randomId).find('.ppb_edit').trigger('click');
			}

			$('html, body').animate({
				scrollTop: $('#' + randomId).offset().top - 32
			}, 1000);
			
		}
	});

	// Remove Item
	$(document).on( 'click', '#content_builder_sort li a.ppb_remove', function(e) {
		e.preventDefault();
		var $parentEle = $(this).parent('.actions').parent('li');
		if ( confirm( 'Are you sure you want to delete this item?' ) ) {
			$parentEle.remove();
		}
	});
	
	// Edit Item
	$(document).on( 'click', '#content_builder_sort li .actions a.ppb_edit', function(e) {
		e.preventDefault();
		
		var ele 			= $(this).parent('.actions').parent('li'),
				id 				= ele.attr('id'),
				itemInner = $('#item-inner-' + id);
		
		if ( itemInner.length == 0 ) {
			$('#ppb_inline_current').attr('value', $(this).attr('data-rel'));

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
		$("#content_builder_sort > li").each( function() {
			$(this).append('<textarea style="display:none" id="'+$(this).attr('id')+'_data" name="'+$(this).attr('id')+'_data">'+$(this).data('ppb_setting')+'</textarea>');
			$(this).append('<input style="display:none" type="text" id="'+$(this).attr('id')+'_size" name="'+$(this).attr('id')+'_size" value="'+$(this).attr('data-current-size')+'"/>');
		});
		
		var itemOrder = $("#content_builder_sort").sortable('toArray');
		$('#ppb_form_data_order').attr('value', itemOrder);
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
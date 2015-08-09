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

// Builder Items
function ppbBuildItem() {
	
	// Remove Item
	jQuery("#content_builder_sort li a.ppb_remove").click( function() {
		if ( confirm( 'Are you sure you want to delete this item?' ) ) { 
			jQuery(this).parent('.actions').parent('li').remove();
		}
		
	});
	
	// Edit Item
	jQuery("#content_builder_sort li .actions a.ppb_edit").on( 'click', function(e) {

		e.preventDefault();
		var ele = jQuery(this).parent('.actions').parent('li');
		var id = ele.attr('id');
		var inner = jQuery('#inner-' + id);
		
		if ( inner.length == 0 ) {
			jQuery('#ppb_inline_current').attr('value', jQuery(this).attr('data-rel'));

			var actionURL = jQuery(this).attr('href');

			ele.find('span.spinner').css('visibility','visible');
			
			var ajaxCall = jQuery.ajax({
				type: "GET",
				cache: false,
				url: actionURL,
				data: '',
				success: function (data) {
					ele.append('<div id="inner-'+id+'" style="display:none;">' + data + '</div>');
				} 
			});

			jQuery.when( ajaxCall ).then( function() {
				jQuery('#inner-' + id).slideToggle();
				ele.find('span.spinner').css('visibility','hidden');
			});
		} else {
			jQuery('#inner-' + id).slideToggle();
		}

		jQuery('html, body').animate({
				scrollTop: jQuery('#' + id).offset().top - 32
		}, 1000);
		
	});

}

jQuery(document).ready( function() {
	
	// Import / Export
	jQuery('#ppb_export_current_button').on( 'click', function(){
		jQuery('#ppb_export_current').val(1);
	});
	
	jQuery('#ppb_import_current_button').on( 'click', function(){
		jQuery('#ppb_import_current').val(1);
	});
	
	// Tabs
	jQuery('#ppb_tab, #meta_tab').tabs({
		hide: {
			effect: "fade",
			duration: 400
		},
		show: {
			effect: "fade",
			duration: 400
		}
	});
	
	var containerWidth 	= jQuery('#content_builder_sort').width();
	var oneFourthWidth 	= (containerWidth/4)-6-20;
	var oneHalfWidth 		= (containerWidth/2)-6-20;
	var oneThirdWidth 	= (containerWidth/3)-6-20;
	var twoThirdWidth 	= ((containerWidth/3)*2)-6-20;
	var oneWidth 				= (containerWidth)-6-20;
	
	jQuery('#content_builder_sort').find('li.one_fourth').css('width', oneFourthWidth+'px');
	jQuery('#content_builder_sort').find('li.one_half').css('width', oneHalfWidth+'px');
	jQuery('#content_builder_sort').find('li.one_third').css('width', oneThirdWidth+'px');
	jQuery('#content_builder_sort').find('li.two_third').css('width', twoThirdWidth+'px');
	jQuery('#content_builder_sort').find('li.one').css('width', oneWidth+'px');
	
	jQuery(window).resize(function() {
		var containerWidth 	= jQuery('#content_builder_sort').width();
		var oneFourthWidth 	= (containerWidth/4)-6-20;
		var oneHalfWidth 		= (containerWidth/2)-6-20;
		var oneThirdWidth 	= (containerWidth/3)-6-20;
		var twoThirdWidth 	= ((containerWidth/3)*2)-6-20;
		var oneWidth 				= (containerWidth)-6-20;

		jQuery('#content_builder_sort').find('li.one_fourth').css('width', oneFourthWidth+'px');
		jQuery('#content_builder_sort').find('li.one_half').css('width', oneHalfWidth+'px');
		jQuery('#content_builder_sort').find('li.one_third').css('width', oneThirdWidth+'px');
		jQuery('#content_builder_sort').find('li.two_third').css('width', twoThirdWidth+'px');
		jQuery('#content_builder_sort').find('li.one').css('width', oneWidth+'px');
	});
	
	// Call Builder Item
	ppbBuildItem();
	
	// Add Item
	jQuery("#ppb_sortable_add_button").on( 'click', function(e) {

		e.preventDefault();
		
		var targetSelect = jQuery('#ppb_options');
		var targetTitle  = jQuery('#ppb_options_title');
		var targetImage  = jQuery('#ppb_options_image');
		
		randomId 			= jQuery.now();
		myCheckId 		= targetSelect.val();
		myCheckTitle 	= targetTitle.val();
		postType 			= jQuery('#ppb_post_type').val();
		myImage 			= targetImage.val();
		
		if ( myCheckId != '' ) {
			
			var builderItemData = {};
			
			builderItemData.id = randomId;
			builderItemData.shortcode = myCheckId;
			builderItemData.ppb_text_title = myCheckTitle;
			builderItemData.ppb_text_content = '';
			builderItemData.ppb_header_content = '';
			
			var builderItemDataJSON = JSON.stringify(builderItemData);
			var editURL  = ANVA_VARS.ajaxurl+'?action=pp_ppb&ppb_post_type='+postType+'&shortcode='+myCheckId+'&rel='+randomId+'&width=800&height=900';

			builderItem  = '<li id="' + randomId + '" class="ui-state-default one ' + myCheckId + '" data-current-size="one">';
			builderItem += '<div class="actions">';
			builderItem += '<a href="' + editURL + '" class="ppb_edit" data-rel="' + randomId + '"></a>';
			builderItem += '<a href="javascript:;" class="ppb_remove"></a>';
			builderItem += '</div>';
			builderItem += '<div class="thumbnail">';
			builderItem += '<img src="' + myImage + '" alt="' + myCheckTitle + '" />';
			builderItem += '</div>';

			builderItem += '<div class="title">' + myCheckTitle + '</div>';
			builderItem += '<input type="hidden" class="ppb_setting_columns" value="one_fourth"/>';
			builderItem += '<div class="clear"></div>';
			builderItem += '</li>';

			jQuery('#content_builder_sort').append(builderItem);
			jQuery('#content_builder_sort').removeClass('empty');

			// Call Builder Item
			ppbBuildItem();

			jQuery('#' + randomId).data('ppb_setting', builderItemDataJSON);
			
			var prev1Li = jQuery('#'+randomId).prev();
			var prev2Li = prev1Li.prev();
			var prev3Li = prev2Li.prev();
				
			if ( prev1Li.attr('data-current-size') == 'one_third' && prev2Li.attr('data-current-size') == 'one_third' ) {
				jQuery('#'+randomId).attr('data-current-size', 'one_third last');
				jQuery('#'+randomId).find('.ppb_setting_columns').attr('value', 'one_third last');
			}
			
			if ( myCheckId != 'ppb_divider' && myCheckId != 'ppb_empty_line' ) {
				jQuery('#' + randomId).find('.ppb_edit').trigger('click');
			}

			jQuery('html, body').animate({
				scrollTop: jQuery('#'+randomId).offset().top - 32
			}, 1000);
		}

	});
	
	// Submit Items
	jQuery('#publish').on( 'click', function(){
		
		jQuery("#content_builder_sort > li").each(function(){
			jQuery(this).append('<textarea style="display:none" id="'+jQuery(this).attr('id')+'_data" name="'+jQuery(this).attr('id')+'_data">'+jQuery(this).data('ppb_setting')+'</textarea>');
			jQuery(this).append('<input style="display:none" type="text" id="'+jQuery(this).attr('id')+'_size" name="'+jQuery(this).attr('id')+'_size" value="'+jQuery(this).attr('data-current-size')+'"/>');
		});
		
		var itemOrder = jQuery("#content_builder_sort").sortable('toArray');
		jQuery('#ppb_form_data_order').attr('value', itemOrder);
	})
	
	// Sort Items
	jQuery( ".ppb_sortable" ).sortable({
		start: function(event, ui) {
				
		},
		stop: function(event, ui) {
				
		}
	});
	
	// Disable item selection
	jQuery( ".ppb_sortable" ).disableSelection();
	
	// Thumbnail selected
	jQuery('#ppb_module_wrapper li').click( function() {
		jQuery('#ppb_module_wrapper li').removeClass('selected');
		jQuery(this).addClass('selected');
		var moduleSelectedId = jQuery(this).data('module');
		var moduleSelectedTitle = jQuery(this).data('title');
		var moduleSelectedImage = jQuery(this).find('img').attr('src');	
		jQuery('#ppb_options').val(moduleSelectedId);
		jQuery('#ppb_options_title').val(moduleSelectedTitle);
		jQuery('#ppb_options_image').val(moduleSelectedImage);
	});
	
	jQuery('body').on('click', '.metabox_link_btn', function(event) {
		wpActiveEditor = true;
		wpLink.inputid = jQuery(this).attr('rel');
		wpLink.open();
		return false;
	});
		
	jQuery('body').on('click', '#wp-link-submit', function(event) {
		var linkAtts = wpLink.getAttrs();
		// Get the href attribute and add to a textfield, or use as you see fit
		jQuery('#'+wpLink.inputid).val(linkAtts.href);
		wpLink.textarea = jQuery('body');
		wpLink.close();
		event.preventDefault ? event.preventDefault() : event.returnValue = false;
		event.stopPropagation();
		return false;
	});
		
	jQuery('body').on('click', '#wp-link-cancel, #wp-link-close', function(event) {
		wpLink.textarea = jQuery('body');
		wpLink.close();
		event.preventDefault ? event.preventDefault() : event.returnValue = false;
		event.stopPropagation();
		return false;
	});

});
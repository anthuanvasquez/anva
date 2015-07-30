function removeSortRecord(thisParentLi, targetObj)
{
	jQuery('li#'+thisParentLi+'_sort').remove();
	var order = jQuery('#'+targetObj).sortable('toArray');
    jQuery('#'+targetObj+'_data').val(order);
}

// implement JSON.stringify serialization
JSON.stringify = JSON.stringify || function (obj) {
    var t = typeof (obj);
    if (t != "object" || obj === null) {
        // simple data type
        if (t == "string") obj = '"'+obj+'"';
        return String(obj);
    }
    else {
        // recurse array or object
        var n, v, json = [], arr = (obj && obj.constructor == Array);
        for (n in obj) {
            v = obj[n]; t = typeof(v);
            if (t == "string") v = '"'+v+'"';
            else if (t == "object" && v !== null) v = JSON.stringify(v);
            json.push((arr ? "" : '"' + n + '":') + String(v));
        }
        return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
};

function removeSortRecord(thisParentLi, targetObj)
{
	jQuery('li#'+thisParentLi+'_sort').remove();
	var order = jQuery('#'+targetObj).sortable('toArray');
    jQuery('#'+targetObj+'_data').val(order);
}

function ppbBuildItem()
{
	jQuery("#content_builder_sort li a.ppb_remove").click(function(){
	    jQuery(this).parent('li').remove();
	});
	
	jQuery("#content_builder_sort li a.ppb_plus").click(function(){
	    var currentSize = jQuery(this).parent('li').attr('data-current-size');
	    var prev1Li = jQuery(this).parent('li').prev();
	    var prev2Li = prev1Li.prev();
	    var prev3Li = prev2Li.prev();
	    
	    if(currentSize == 'one_fourth' || currentSize == 'one_fourth last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_third' && prev2Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).parent('li').addClass('one_third');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_third last');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_third last');	

	    	}
	    	else if(prev1Li.attr('data-current-size')=='two_third')
	    	{
	    		jQuery(this).parent('li').addClass('one_third');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_third last');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_third last');	

	    	}
	    	else
	    	{
		    	jQuery(this).parent('li').addClass('one_third');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_third');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_third');	
	    	}
	    	
	    	jQuery(this).parent('li').removeClass('one_fourth');
	    }
	    else if(currentSize == 'one_third' || currentSize == 'one_third last')
	    {	
	    	if(prev1Li.attr('data-current-size')=='one_half')
	    	{
	    		jQuery(this).parent('li').addClass('one_half');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_half last');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_half last');	

	    	}
	    	else
	    	{
		    	jQuery(this).parent('li').addClass('one_half');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_half');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_half');	
	    	}
	    	
	    	jQuery(this).parent('li').removeClass('one_third');
	    }
	    else if(currentSize == 'one_half' || currentSize == 'one_half last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).parent('li').addClass('two_third');
		    	jQuery(this).parent('li').attr('data-current-size', 'two_third last');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'two_third last');	
	    	}
	    	else
	    	{
		    	jQuery(this).parent('li').addClass('two_third');
		    	jQuery(this).parent('li').attr('data-current-size', 'two_third');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'two_third');	
	    	}

	    	jQuery(this).parent('li').removeClass('one_half');
	    }
	    else if(currentSize == 'two_third' || currentSize == 'two_third last')
	    {
	    	jQuery(this).parent('li').addClass('one');
	    	jQuery(this).parent('li').attr('data-current-size', 'one');
	    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one');
	    	jQuery(this).parent('li').removeClass('two_third');
	    }
	    else if(currentSize == 'one')
	    {
	    	return false;
	    }
	    else
	    {
	    	return false;
	    }
	    
	    var containerWidth = jQuery('#content_builder_sort').width();
	    var oneFourthWidth = (containerWidth/4)-6-20;
	    var oneHalfWidth = (containerWidth/2)-6-20;
	    var oneThirdWidth = (containerWidth/3)-6-20;
	    var twoThirdWidth = ((containerWidth/3)*2)-6-20;
	    var oneWidth = (containerWidth)-6-20;
	    
	    jQuery('#content_builder_sort').find('li.one_fourth').css('width', oneFourthWidth+'px');
	    jQuery('#content_builder_sort').find('li.one_half').css('width', oneHalfWidth+'px');
	    jQuery('#content_builder_sort').find('li.one_third').css('width', oneThirdWidth+'px');
	    jQuery('#content_builder_sort').find('li.two_third').css('width', twoThirdWidth+'px');
	    jQuery('#content_builder_sort').find('li.one').css('width', oneWidth+'px');
	});
	
	jQuery("#content_builder_sort li a.ppb_minus").click(function(){
	    var currentSize = jQuery(this).parent('li').attr('data-current-size');
	    var prev1Li = jQuery(this).parent('li').prev();
	    var prev2Li = prev1Li.prev();
	    var prev3Li = prev2Li.prev();
	    
	    if(currentSize == 'one_fourth' || currentSize == 'one_fourth last')
	    {
	    	return false;
	    }
	    else if(currentSize == 'one_third' || currentSize == 'one_third last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_fourth' && prev2Li.attr('data-current-size')=='one_fourth' && prev3Li.attr('data-current-size')=='one_fourth')
	    	{
	    		jQuery(this).parent('li').addClass('one_fourth');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_fourth last');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_fourth last');
	    	}
	    	else
	    	{
		    	jQuery(this).parent('li').addClass('one_fourth');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_fourth');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_fourth');
	    	}
	    	
	    	jQuery(this).parent('li').removeClass('one_third');
	    }
	    else if(currentSize == 'one_half' || currentSize == 'one_half last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_third' && prev2Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).parent('li').addClass('one_third');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_third last');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_third last');	

	    	}
	    	else
	    	{
		    	jQuery(this).parent('li').addClass('one_third');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_third');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_third');	
	    	}
	    	
	    	jQuery(this).parent('li').removeClass('one_half');
	    }
	    else if(currentSize == 'two_third' || currentSize == 'two_third last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_half')
	    	{
	    		jQuery(this).parent('li').addClass('one_half');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_half last');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_half last');	

	    	}
	    	else
	    	{
		    	jQuery(this).parent('li').addClass('one_half');
		    	jQuery(this).parent('li').attr('data-current-size', 'one_half');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'one_half');	
	    	}
	    	
	    	jQuery(this).parent('li').removeClass('two_third');
	    }
	    else if(currentSize == 'one')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).parent('li').addClass('two_third');
		    	jQuery(this).parent('li').attr('data-current-size', 'two_third last');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'two_third last');	
	    	}
	    	else
	    	{
		    	jQuery(this).parent('li').addClass('two_third');
		    	jQuery(this).parent('li').attr('data-current-size', 'two_third');
		    	jQuery(this).parent('li').find('.ppb_setting_columns').attr('value', 'two_third');	
	    	}
	    	
	    	jQuery(this).parent('li').removeClass('one');
	    }
	    else
	    {
	    	return false;
	    }
	    
	    var containerWidth = jQuery('#content_builder_sort').width();
	    var oneFourthWidth = (containerWidth/4)-6-20;
	    var oneHalfWidth = (containerWidth/2)-6-20;
	    var oneThirdWidth = (containerWidth/3)-6-20;
	    var twoThirdWidth = ((containerWidth/3)*2)-6-20;
	    var oneWidth = (containerWidth)-6-20;
	    
	    jQuery('#content_builder_sort').find('li.one_fourth').css('width', oneFourthWidth+'px');
	    jQuery('#content_builder_sort').find('li.one_half').css('width', oneHalfWidth+'px');
	    jQuery('#content_builder_sort').find('li.one_third').css('width', oneThirdWidth+'px');
	    jQuery('#content_builder_sort').find('li.two_third').css('width', twoThirdWidth+'px');
	    jQuery('#content_builder_sort').find('li.one').css('width', oneWidth+'px');
	});
	
	jQuery(".pp_fancybox").fancybox({
	    maxWidth	: 700,
	    maxHeight	: 900,
	    autoSize	: false,
	    closeClick	: false,
	    openEffect	: 'none',
	    closeEffect	: 'none',
	    helpers : {
	    	overlay : {
	            css : {
	                'background-color' : 'rgba(0, 0, 0, 0.7)'
	            }
	        }
	    },
	    onCancel: function(current, previous) {
	    	jQuery("textarea.ppb_input").each(function(){
				tinymce.EditorManager.execCommand( 'mceRemoveEditor', false, jQuery(this).attr('id') );	
			});
	    
	    	jQuery('#ppb_inline_current').attr('value', '');
	    }
	});
	
	jQuery("#content_builder_sort li a.ppb_edit").on( 'click', function(e){
		e.preventDefault();
		jQuery('#ppb_inline_current').attr('value', jQuery(this).attr('data-rel'));
		
		jQuery.fancybox.showLoading();
		var actionURL = jQuery(this).attr('href');
		
		jQuery.ajax({
	      type: "GET",
	      cache: false,
	      url: actionURL,
	      data: '',
	      success: function (data) {
	        jQuery.fancybox(data, {
	          fitToView: false,
	          width: 800,
	          autoSize: false,
	          autoResize: true,
	          autoHeight: true,
	          closeClick: false,
	          openEffect: 'none',
	          closeEffect: 'none',
			  beforeClose: function(current, previous) {
			    jQuery("textarea.ppb_input").each(function(){
				    tinymce.EditorManager.execCommand( 'mceRemoveEditor', false, jQuery(this).attr('id') );	
				});
			    
			    jQuery('#ppb_inline_current').attr('value', '');
			  }
	        }); 
	      } 
	    });
	    
	    return false;
	});
}

jQuery(document).ready(function(){

    jQuery('#current_sidebar li a.sidebar_del').click(function(){
    	if(confirm('Are you sure you want to delete this sidebar? (this can not be undone)'))
    	{
    		sTarget = jQuery(this).attr('href');
    		sSidebar = jQuery(this).attr('rel');
    		objTarget = jQuery(this).parent('li');
    		
    		jQuery.ajax({
        		type: 'POST',
        		url: sTarget,
        		data: 'sidebar_id='+sSidebar,
        		success: function(msg){ 
        			objTarget.fadeOut();
        			setTimeout(function() {
                      location.reload();
                    }, 1000);
        		}
        	});
    	}
    	
    	return false;
    });
    
    jQuery('#current_ggfont li a.ggfont_del').click(function(){
	    if(confirm('Are you sure you want to delete this font? (this can not be undone)'))
	    {
	    	sTarget = jQuery(this).attr('href');
	    	sGGFont = jQuery(this).attr('rel');
	    	objTarget = jQuery(this).parent('li');
	    	
	    	jQuery.ajax({
  	    		type: 'POST',
  	    		url: sTarget,
  	    		data: 'ggfont='+sGGFont,
  	    		success: function(msg){ 
  	    			objTarget.fadeOut();
  	    			setTimeout(function() {
                      location.reload();
                    }, 1000);
  	    		}
	    	});
	    }
	    
	    return false;
	});
    
    jQuery('a.image_del').click(function(){
    	if(confirm('Are you sure you want to delete this image? (this can not be undone)'))
    	{
    		sTarget = jQuery(this).attr('href');
    		sFieldId = jQuery(this).attr('rel');
    		objTarget = jQuery('#'+sFieldId+'_wrapper');
    		
    		jQuery.ajax({
        		type: 'POST',
        		url: sTarget,
        		data: 'field_id='+sFieldId,
        		success: function(msg){ 
        			objTarget.fadeOut();
        			jQuery('#'+sFieldId).val('');
        		}
        	});
    	}
    	
    	return false;
    });
    
    jQuery('#pp_export_current_button').on( 'click', function(){
    	jQuery('#pp_export_current').val(1);
    });
    
    jQuery('#ppb_export_current_button').on( 'click', function(){
    	jQuery('#ppb_export_current').val(1);
    });
    
    jQuery('#ppb_import_current_button').on( 'click', function(){
    	jQuery('#ppb_import_current').val(1);
    });
    
    jQuery('#import_demo li').on( 'click', function(){
	    jQuery('#import_demo li').removeClass('selected');
	    jQuery(this).addClass('selected');
	    
	    var selectedDemo = jQuery(this).data('demo');
	    jQuery('#pp_import_customize_demo').val(selectedDemo);
	});
    
    jQuery('#pp_import_customize_button').on( 'click', function(){
    	jQuery('#pp_import_customize').val(1);
    });
    
    jQuery('#current_sidebar li a.sidebar_del').click(function(){
    	if(confirm('Are you sure you want to delete this sidebar? (this can not be undone)'))
    	{
    		sTarget = jQuery(this).attr('href');
    		sSidebar = jQuery(this).attr('rel');
    		objTarget = jQuery(this).parent('li');
    		
    		jQuery.ajax({
        		type: 'POST',
        		url: sTarget,
        		data: 'sidebar_id='+sSidebar,
        		success: function(msg){ 
        			objTarget.fadeOut();
        		}
        	});
    	}
    	
    	return false;
    });
    
    jQuery('#pp_advance_clear_cache').click(function(){
    	if(confirm('Are you sure you want to clear all cache'))
    	{
    		sTarget = jQuery(this).attr('href');
    		
    		jQuery.ajax({
        		type: 'POST',
        		url: sTarget,
        		data: 'method=clear_cache',
        		success: function(msg){ 
        			jQuery('#pp_advance_clear_cache').html('Successfully cleared. Click here to clear cache files again');
        		}
        	});
    	}
    	
    	return false;
    });
    
   jQuery('#pp_panel a').click(function(){
    	jQuery('#pp_panel a').removeClass('nav-tab-active');
    	jQuery(this).addClass('nav-tab-active');
    	
    	jQuery('.rm_section').css('display', 'none');
    	jQuery(jQuery(this).attr('href')).fadeIn();
    	jQuery('#current_tab').val(jQuery(this).attr('href'));
    	
    	return false;
    });
    
    jQuery('.color_picker').each(function()
	{
	    var inputID = jQuery(this).attr('id');
	    
	    jQuery(this).ColorPicker({
	    	color: jQuery(this).val(),
	    	onShow: function (colpkr) {
	    		jQuery(colpkr).fadeIn(200);
	    		return false;
	    	},
	    	onHide: function (colpkr) {
	    		jQuery(colpkr).fadeOut(200);
	    		return false;
	    	},
	    	onChange: function (hsb, hex, rgb, el) {
	    		jQuery('#'+inputID).val('#' + hex);
	    		jQuery('#'+inputID+'_bg').css('backgroundColor', '#' + hex);
	    	}
	    });	
	    
	    jQuery(this).css('width', '200px');
	    jQuery(this).css('float', 'left');
	});
    
    jQuery('.rm_section').css('display', 'none');
    
    if(self.document.location.hash != '')
	{
	    jQuery('html, body').animate({scrollTop:0}, 'fast');
	    jQuery('.nav-tab').removeClass('nav-tab-active');
	    jQuery('a'+self.document.location.hash+'_a').addClass('nav-tab-active');
	    jQuery('div'+self.document.location.hash).css('display', 'block');
	    jQuery('#current_tab').val(self.document.location.hash);
	}
	else
	{
	    jQuery('div#pp_panel_general').css('display', 'block');
	}
    
    jQuery( ".pp_sortable" ).sortable({
	    placeholder: "ui-state-highlight",
	    create: function(event, ui) { 
	    	myCheckRel = jQuery(this).attr('rel');
	    
	    	var order = jQuery(this).sortable('toArray');
        	jQuery('#'+myCheckRel).val(order);
	    },
	    update: function(event, ui) {
	    	myCheckRel = jQuery(this).attr('rel');
	    
	    	var order = jQuery(this).sortable('toArray');
        	jQuery('#'+myCheckRel).val(order);
	    }
	});
	jQuery( ".pp_sortable" ).disableSelection();
	
	jQuery(".pp_checkbox input").change(function(){
	    myCheckId = jQuery(this).val();
	    myCheckRel = jQuery(this).attr('rel');
	    myCheckTitle = jQuery(this).attr('alt');
	    
	    if (jQuery(this).is(':checked')) { 
	    	jQuery('#'+myCheckRel).append('<li id="'+myCheckId+'_sort" class="ui-state-default">'+myCheckTitle+'</li>');
	    } 
	    else
	    {
	    	jQuery('#'+myCheckId+'_sort').remove();
	    }

	    var order = jQuery('#'+myCheckRel).sortable('toArray');

        jQuery('#'+myCheckRel+'_data').val(order);
	});
	
	jQuery(".pp_sortable_button").click(function(){
	    var targetSelect = jQuery('#'+jQuery(this).attr('data-rel'));
	    
	    myCheckId = targetSelect.find("option:selected").val();
	    myCheckRel = targetSelect.find("option:selected").attr('data-rel');
	    myCheckTitle = targetSelect.find("option:selected").attr('title');

	    if (jQuery('#'+myCheckRel).children('li#'+myCheckId+'_sort').length == 0)
	    {
	    	jQuery('#'+myCheckRel).append('<li id="'+myCheckId+'_sort" class="ui-state-default"><div class="title">'+myCheckTitle+'</div><a data-rel="'+myCheckRel+'" href="javascript:removeSortRecord(\''+myCheckId+'\', \''+myCheckRel+'\');" class="remove">x</a><br style="clear:both"/></li>');
	    	//jQuery('#'+myCheckId+'_sort').remove();
	    	
	    	var order = jQuery('#'+myCheckRel).sortable('toArray');
        	jQuery('#'+myCheckRel+'_data').val(order);
        }
        else
        {
        	alert('You have already added "'+myCheckTitle+'"');
        }
	});
	
	jQuery(".pp_sortable li a.remove").click(function(){
	    jQuery(this).parent('li').remove();
	    var order = jQuery('#'+jQuery(this).attr('data-rel')).sortable('toArray');
        jQuery('#'+jQuery(this).attr('data-rel')+'_data').val(order);
	});
    
    jQuery(".pp_font").change(function(){
    	var valueElement = jQuery(this).data('value');
    	var sampleElement = jQuery(this).data('sample');
    	jQuery("#"+valueElement).attr('value', jQuery(this).children("option:selected").attr('data-family'));
    
    	var ppGGFont = 'http://fonts.googleapis.com/css?family='+jQuery(this).val();
    	jQuery('head').append('<link rel="stylesheet" id="google_fonts_'+valueElement+'" href="'+ppGGFont+'" type="text/css" media="all">');
    	
    	if(jQuery(this).children("option:selected").attr('data-family') != '')
    	{
    		jQuery('#'+sampleElement).css('font-family', '"'+jQuery(this).children("option:selected").attr('data-family')+'"');
    	}
    });
    
    jQuery(".pp_font").each(function(){
    	jQuery(this).trigger('change');
    });
    
    jQuery('#ppb_tab').tabs();
    jQuery('#meta_tab').tabs();
            
    var formfield = '';
	
	jQuery('.metabox_upload_btn').on( 'click', function() {
	    jQuery('.fancybox-overlay').css('visibility', 'hidden');
	    jQuery('.fancybox-wrap').css('visibility', 'hidden');
     	formfield = jQuery(this).attr('rel');
	    
	    var send_attachment_bkp = wp.media.editor.send.attachment;
	    wp.media.editor.send.attachment = function(props, attachment) {
	     	jQuery('#'+formfield).attr('value', attachment.url);
	
	        wp.media.editor.send.attachment = send_attachment_bkp;
	        jQuery('.fancybox-overlay').css('visibility', 'visible');
	     	jQuery('.fancybox-wrap').css('visibility', 'visible');
	    }
	
	    wp.media.editor.open();
     	return false;
    });
    
    jQuery("input.upload_text").on( 'click', function() { jQuery(this).select(); } );
	
	var containerWidth = jQuery('#content_builder_sort').width();
	var oneFourthWidth = (containerWidth/4)-6-20;
	var oneHalfWidth = (containerWidth/2)-6-20;
	var oneThirdWidth = (containerWidth/3)-6-20;
	var twoThirdWidth = ((containerWidth/3)*2)-6-20;
	var oneWidth = (containerWidth)-6-20;
	
	jQuery('#content_builder_sort').find('li.one_fourth').css('width', oneFourthWidth+'px');
	jQuery('#content_builder_sort').find('li.one_half').css('width', oneHalfWidth+'px');
	jQuery('#content_builder_sort').find('li.one_third').css('width', oneThirdWidth+'px');
	jQuery('#content_builder_sort').find('li.two_third').css('width', twoThirdWidth+'px');
	jQuery('#content_builder_sort').find('li.one').css('width', oneWidth+'px');
	
	jQuery(window).resize(function(){
	    var containerWidth = jQuery('#content_builder_sort').width();
	    var oneFourthWidth = (containerWidth/4)-6-20;
	    var oneHalfWidth = (containerWidth/2)-6-20;
	    var oneThirdWidth = (containerWidth/3)-6-20;
	    var twoThirdWidth = ((containerWidth/3)*2)-6-20;
	    var oneWidth = (containerWidth)-6-20;
	    
	    jQuery('#content_builder_sort').find('li.one_fourth').css('width', oneFourthWidth+'px');
	    jQuery('#content_builder_sort').find('li.one_half').css('width', oneHalfWidth+'px');
	    jQuery('#content_builder_sort').find('li.one_third').css('width', oneThirdWidth+'px');
	    jQuery('#content_builder_sort').find('li.two_third').css('width', twoThirdWidth+'px');
	    jQuery('#content_builder_sort').find('li.one').css('width', oneWidth+'px');
	});
	
	ppbBuildItem();
	
	jQuery("#ppb_sortable_add_button").on( 'click', function(){
	    var targetSelect = jQuery('#ppb_options');
	    var targetTitle = jQuery('#ppb_options_title');
	    
	    randomId = jQuery.now();
	    myCheckId = targetSelect.val();
	    myCheckTitle = targetTitle.val();
	    postType = jQuery('#ppb_post_type').val();
	    
	    if(myCheckId != '')
	    {
	    	var builderItemData = {};
	    	builderItemData.id = randomId;
	    	builderItemData.shortcode = myCheckId;
	    	builderItemData.ppb_text_title = myCheckTitle;
	    	builderItemData.ppb_text_content = '';
	    	builderItemData.ppb_header_content = '';
	    	var builderItemDataJSON = JSON.stringify(builderItemData);
	
	    	builderItem = '<li id="'+randomId+'" class="ui-state-default one '+myCheckId+'" data-current-size="one">';
	    	/*builderItem+= '<a href="javascript:;" class="ppb_plus button">+</a>';
	    	builderItem+= '<a href="javascript:;" class="ppb_minus button">-</a>';*/
	    	builderItem+= '<div class="title">'+myCheckTitle+'</div>';
	    	builderItem+= '<a href="javascript:;" class="ppb_remove">x</a>';
	    	
	    	var editURL = tgAjax.ajaxurl+'?action=pp_ppb&ppb_post_type='+postType+'&shortcode='+myCheckId+'&rel='+randomId+'&width=800&height=900';
	    	
	    	builderItem+= '<a data-rel="'+randomId+'" href="'+editURL+'" class="thickbox ppb_edit"></a>';
	    	builderItem+= '<input type="hidden" class="ppb_setting_columns" value="one_fourth"/>';
	    	builderItem+= '</li>';
	
	    	jQuery('#content_builder_sort').append(builderItem);
	    	jQuery('#content_builder_sort').removeClass('empty');
	    	ppbBuildItem();
	    	jQuery('#'+randomId).data('ppb_setting', builderItemDataJSON);
	    	
	    	var prev1Li = jQuery('#'+randomId).prev();
	        var prev2Li = prev1Li.prev();
	        var prev3Li = prev2Li.prev();
	        
	        if(prev1Li.attr('data-current-size')=='one_third' && prev2Li.attr('data-current-size')=='one_third')
	    	{
	        	jQuery('#'+randomId).attr('data-current-size', 'one_third last');
	        	jQuery('#'+randomId).find('.ppb_setting_columns').attr('value', 'one_third last');	
	
	    	}
	    	
	    	if(myCheckId!='ppb_divider' && myCheckId!='ppb_empty_line')
	    	{
	    		jQuery('#'+randomId).find('.ppb_edit').trigger('click');
	    	}
	    }
	    
	    return false;
	});
	
	jQuery('#publish').on( 'click', function(){
	    jQuery("#content_builder_sort > li").each(function(){
	    	jQuery(this).append('<textarea style="display:none" id="'+jQuery(this).attr('id')+'_data" name="'+jQuery(this).attr('id')+'_data">'+jQuery(this).data('ppb_setting')+'</textarea>');
	    	jQuery(this).append('<input style="display:none" type="text" id="'+jQuery(this).attr('id')+'_size" name="'+jQuery(this).attr('id')+'_size" value="'+jQuery(this).attr('data-current-size')+'"/>');
	    });
	    
	    var itemOrder = jQuery("#content_builder_sort").sortable('toArray');
	    jQuery('#ppb_form_data_order').attr('value', itemOrder);
	})
	
	jQuery( ".ppb_sortable" ).sortable({
	    start: function(event, ui) {
	        
	    },
	    stop: function(event, ui) {
	        
	    }
	});
	
	jQuery( ".ppb_sortable" ).disableSelection();
	
	jQuery('#ppb_enable').on('ifToggled', function(event){
	    jQuery(this).on('ifChecked', function(event){
	      	jQuery('#postdivrich').hide();
	      	jQuery('#preview-action').hide();
	    });
	    
	    jQuery(this).on('ifUnchecked', function(event){
	      	jQuery('#postdivrich').show();
	      	jQuery('#preview-action').show();
	    });
	});
	
	jQuery('#ppb_module_wrapper li').click(function(){
		jQuery('#ppb_module_wrapper li').removeClass('selected');
		jQuery(this).addClass('selected');
		
		var moduleSelectedId = jQuery(this).data('module');
		var moduleSelectedTitle = jQuery(this).data('title');
		
		jQuery('#ppb_options').val(moduleSelectedId);
		jQuery('#ppb_options_title').val(moduleSelectedTitle);
	});
	
	jQuery('#pp_theme_go_update_bth').click(function(){
		update_true = confirm('Are you sure to update the theme?');
        if(update_true == false) 
        {
        	return false;
        }
		else
		{
	        jQuery('.update_message').show();
	        jQuery(this).hide();
	       
	        var data = {
	            'action': 'pp_update_theme'
	        };
	
	        jQuery.post(ajaxurl, data, function(response) {
	            jQuery('.update_message').html('<div class="update_message_success">'+ response +'</div>');
	        });
	    }
	    
	    return false;
	});
	
	jQuery('body').on('click', '.metabox_link_btn', function(event) {
        wpActiveEditor = true;
        wpLink.inputid = jQuery(this).attr('rel');
        wpLink.open();
        return false;
    });
    
    jQuery('body').on('click', '#wp-link-submit', function(event) {
        var linkAtts = wpLink.getAttrs();
        jQuery('#'+wpLink.inputid).val(linkAtts.href);//get the href attribute and add to a textfield, or use as you see fit
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
    
    jQuery('#pp_import_default_button').on( 'click', function(){
	    jQuery('#pp_import_default').val(1);
	});
	
	jQuery('#import_demo_content li').on( 'click', function(){
	    jQuery('#import_demo_content li').removeClass('selected');
	    jQuery(this).addClass('selected');
	    
	    var selectedDemo = jQuery(this).data('demo');
	    jQuery('#pp_import_demo_content').val(selectedDemo);
	});
	
	jQuery('#pp_import_content_button').on( 'click', function(){
		if(jQuery('#pp_import_demo_content').val()=='')
		{
			alert('Please select demo content you want to import');
			return false;
		}
	
	    import_true = confirm('Are you sure to import demo content? it will overwrite the existing data');
        if(import_true == false) return;

        jQuery('.import_message').show();
        jQuery(this).hide();
       
        var data = {
            'action': 'pp_import_demo_content',
            'demo': jQuery('#pp_import_demo_content').val()
        };

        jQuery.post(ajaxurl, data, function(response) {
            jQuery('.import_message').html('<div class="import_message_success">'+ response +'</div>');
        });
	});
	
	jQuery('#ppb_module_wrapper li').on( 'click', function(){
		jQuery('#ppb_module_wrapper li').removeClass('selected');
		jQuery(this).addClass('selected');
		
		var moduleSelectedId = jQuery(this).data('module');
		var moduleSelectedTitle = jQuery(this).data('title');
		
		jQuery('#ppb_options').val(moduleSelectedId);
		jQuery('#ppb_options_title').val(moduleSelectedTitle);
	});
});
jQuery(document).ready(function($) {
	var pageTemplate = jQuery("#page_template");
	var pageGrid = jQuery("#post_grid");

	// Initial Validation
	if ( 'template-post_grid.php' == pageTemplate.val() ) {
		pageGrid.show();
	} else {
		pageGrid.hide();
	}

	// On Change
	pageTemplate.on( "change", function(e) {		
		if ( 'template-post_grid.php' == jQuery(this).val() ) {
			pageGrid.show();
		} else {
			pageGrid.hide();
		}
	});

});
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo tm_get_local( 'search_for' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo tm_get_local( 'search' ); ?>" value="" name="s" title="<?php echo tm_get_local( 'search_for' ); ?>" />
	</label>
	<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
</form>
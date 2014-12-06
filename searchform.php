<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<div class="input-group">
		<input type="search" class="search-field form-control" placeholder="<?php echo anva_get_local( 'search' ); ?>" value="" name="s" title="<?php echo anva_get_local( 'search_for' ); ?>" />
		<span class="input-group-btn">
			<button type="submit" class="btn btn-default search-submit">
				<span class="sr-only"><?php echo anva_get_local( 'search_for' ); ?></span>
				<i class="fa fa-search"></i>
			</button>
		</span>
	</div>
</form>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="search" class="search-field form-control" placeholder="<?php anva_local( 'search' ); ?>" value="" name="s" title="<?php anva_local( 'search_for' ); ?>" />
		<span class="input-group-btn">
			<button type="submit" class="btn btn-default search-submit">
				<span class="sr-only"><?php anva_local( 'search_for' ); ?></span>
				<i class="icon-search"></i>
			</button>
		</span>
	</div>
</form>

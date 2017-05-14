<!-- Top Search -->
<div id="top-search">
	<a href="#" id="top-search-trigger">
		<i class="icon-search3"></i>
		<i class="icon-line-cross"></i>
	</a>
	<form role="search" id="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="text" name="s" id="s" class="form-control" autocomplete="off" value="" placeholder="<?php esc_attr_e( 'Type & Hit Enter..', 'anva' ); ?>">
		<?php if ( anva_support_feature( 'anva-instant-search' ) ) : ?>
			<div id="instantsearch" class="hidden"></div>
		<?php endif; ?>
	</form>
</div><!-- #top-search end -->

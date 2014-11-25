<?php
	$hide_title = tm_get_post_meta('_hide_title');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'hide' != $hide_title ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php the_content(); ?>
		<div class="clearfix"></div>
	</div>

</article>
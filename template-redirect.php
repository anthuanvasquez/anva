<?php
/**
 * Template Name: Redirect
 *
 * WARNING: This template file is a core part of the
 * Anva WordPress Framework. It is advised
 * that any edits to the way this file displays its
 * content be done with via hooks, filters, and
 * template parts.
 *
 * USAGE:
 *
 * Add an URL to the content of the page (e.g. http://www.google.com OR google.com OR www.google.com)
 * Select "Redirect" as the page template
 * That's it!
 *
 * @version      1.0.0
 * @author       Anthuan Vásquez
 * @copyright    Copyright (c) Anthuan Vásquez
 * @link         https://anthuanvasquez.net
 * @package      AnvaFramework
 */

if ( have_posts() ) : the_post();
$url = get_the_content();
if ( ! preg_match( '/^http:\/\//', $url ) && ! preg_match( '/^https:\/\//', $url ) ) {
	$url = 'http://' . $url;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Refresh" content="0; url=<?php echo esc_url( $url ); ?>">
</head>
<body>
</body>
</html>
<?php endif; ?>

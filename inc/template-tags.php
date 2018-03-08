<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package maranda
 */

if ( ! function_exists( 'maranda_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function maranda_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'maranda' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'maranda' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'maranda_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function maranda_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'maranda' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'maranda' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'maranda' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'maranda' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'maranda' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'maranda' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'maranda_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function maranda_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
		?>
	</a>

	<?php endif; // End is_singular().
}
endif;

if( !function_exists('slugify') ) {
  /**
   * Slugify
   * @param $text
   * @return url friendlt text
   */
  function slugify($text) {
    $text = preg_replace("/[^A-Za-z0-9 -]/", '', $text);
  	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
  	$text = trim($text, '-');
  	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  	$text = strtolower($text);
  	$text = preg_replace('~[^-\w]+~', '', $text);

  	if (empty($text)) {
  		return 'n-a';
  	}

  	return $text;
  }
}

if( !function_exists('getBrowser') ) {
  /**
   * Browser Detection
   * @link http://php.net/manual/en/function.get-browser.php
   * @return browser information
   */
  function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
    $mobile = "desktop";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    if(preg_match('/Mobile/i',$u_agent)) { $mobile = "mobile"; }

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'   => $pattern,
        'mobile'    => $mobile
    );
  }
}

if( !function_exists('maranda_custom_pagination') ) {
  /**
   * Custom Pagination
   * @param $numpages
   * @param $pagerange
   * @param $paged
   * @link http://callmenick.com/post/custom-wordpress-loop-with-pagination
   */
  function maranda_custom_pagination($numpages = '', $pagerange = '', $paged='') {
    if (empty($pagerange)) {
      $pagerange = 2;
    }

    global $paged;
    if (empty($paged)) {
      $paged = 1;
    }
    if ($numpages == '') {
      global $wp_query;
      $numpages = $wp_query->max_num_pages;
      if(!$numpages) {
          $numpages = 1;
      }
    }

    $pagination_args = array(
      'base'            => get_pagenum_link(1) . '%_%',
      'format'          => '&paged=%#%',
      'total'           => $numpages,
      'current'         => $paged,
      'show_all'        => False,
      'end_size'        => 1,
      'mid_size'        => $pagerange,
      'prev_next'       => True,
      'prev_text'       => __('&laquo;', 'maranda'),
      'next_text'       => __('&raquo;', 'maranda'),
      'type'            => 'plain',
      'add_args'        => false,
      'add_fragment'    => ''
    );

    $paginate_links = paginate_links($pagination_args);
    if ($paginate_links) {
      echo "<nav class='custom-pagination row'>";
        //echo "<span class='page-numbers page-num'>Page " . $paged . " of " . $numpages . "</span> ";
        echo $paginate_links;
      echo "</nav>";
    }
  }
}

if( !function_exists('auto_copyright') ) {
  /**
   * Auto Copyright
   * @param $year
   */
  function auto_copyright($year = 'auto'){
    if(intval($year) == 'auto'){ $year = date('Y'); }
    if(intval($year) == date('Y')){ echo intval($year); }
    if(intval($year) < date('Y')){ echo intval($year) . ' - ' . date('Y'); }
    if(intval($year) > date('Y')){ echo date('Y'); }
  }
}

if( !function_exists('utility_nav') ) {
  /**
   * Utility Nav
   */
  function utility_nav() {
    ob_start();
  ?>

  	<div id="utility-nav" class="row bg-black">
  		<div class="container">
    		<div class="row">
      		<div class="hidden-md-down col-lg-7">
      		</div>
      		<div class="col-md-12 col-lg-6 offset-lg-6">
        		<div class="row">
          		<div class="col-sm-6">
          			<?php if( get_theme_mod( 'linkedin' ) || get_theme_mod( 'facebook' ) || get_theme_mod( 'twitter' ) || get_theme_mod( 'youtube' )|| get_theme_mod( 'blog' ) ) : ?>
          			<ul class="social-links row">
            			<?php if( get_theme_mod( 'twitter' ) ) : ?>
            			<li class="social-link twitter col"><a href="<?php echo get_theme_mod( 'twitter' ); ?>"><i class="fa fa-twitter"></i></a></li>
            			<?php endif; ?>
            			<?php if( get_theme_mod( 'facebook' ) ) : ?>
            			<li class="social-link facebook col"><a href="<?php echo get_theme_mod( 'facebook' ); ?>"><i class="fa fa-facebook"></i></a></li>
            			<?php endif; ?>
            			<?php if( get_theme_mod( 'linkedin' ) ) : ?>
            			<li class="social-link linkedin col"><a href="<?php echo get_theme_mod( 'linkedin' ); ?>"><i class="fa fa-linkedin"></i></a></li>
            			<?php endif; ?>
            			<?php if( get_theme_mod( 'youtube' ) ) : ?>
            			<li class="social-link youtube col"><a href="<?php echo get_theme_mod( 'youtube' ); ?>"><i class="fa fa-youtube-play"></i></a></li>
            			<?php endif; ?>
            			<?php if( get_theme_mod( 'instagram' ) ) : ?>
            			<li class="social-link instagram col"><a href="<?php echo get_theme_mod( 'instagram' ); ?>"><i class="fa fa-instagram"></i></a></li>
            			<?php endif; ?>
            			<?php if( get_theme_mod( 'pinterest' ) ) : ?>
            			<li class="social-link pinterest col"><a href="<?php echo get_theme_mod( 'pinterest' ); ?>"><i class="fa fa-pinterest"></i></a></li>
            			<?php endif; ?>
            			<?php if( get_theme_mod( 'google_plus' ) ) : ?>
            			<li class="social-link google-plus col"><a href="<?php echo get_theme_mod( 'google_plus' ); ?>"><i class="fa fa-google-plus"></i></a></li>
            			<?php endif; ?>
            			<?php if( get_theme_mod( 'blog' ) ) : ?>
            			<li class="social-link blog col"><a href="<?php echo get_theme_mod( 'blog' ); ?>"><i class="fa fa-rss"></i></a></li>
            			<?php endif; ?>
          			</ul>
          			<?php endif; ?>
          		</div>
          		<div class="col-sm-6">
            		<?php if( get_theme_mod( 'primary_number' ) ) : ?>
            		<div class="primary-contact-phone bg-white">
              		<p><?php echo __('Reach out:', 'maranda'); ?><a href="tel:<?php echo get_theme_mod( 'primary_number' ); ?>"><?php echo get_theme_mod( 'primary_number' ); ?></a></p>
            		</div>
            		<?php endif; ?>
          		</div>
        		</div>
      		</div>
    		</div>
  		</div>
  	</div>

  <?php
    echo ob_get_clean();
  }
}

if( !function_exists('set_slug_for_id') ) {
  /**
   * Set page slug as page ID
   * @return $slug
   */
  function set_slug_for_id() {
    global $post;

    if($post) {
      if(is_search()) {
        $slug = 'search-result';
      } elseif(is_archive()) {
        $slug = get_post_type($post).'-archive';
      } elseif(is_front_page() && is_home()) {
        $slug = 'blog';
      } else {
        $slug = $post->post_name;
      }
    } else {
      if(is_404()) {
        $slug = 'error-404';
      } elseif(is_archive()) {
        $slug = 'archive';
      } elseif(is_front_page() && is_home()) {
        $slug = 'blog';
      } elseif(is_search()) {
        $slug = 'search-no-result';
      } else {
        $slug = wp_get_theme()->get('TextDomain');
      }
    }

    return $slug;
  }
}

/**
 * Customizer: Sanitization Callbacks
 *
 * This file demonstrates how to define sanitization callback functions for various data types.
 *
 * @package   code-examples
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 */

if( !function_exists('maranda_slug_sanitize_checkbox') ) {
  /**
   * Checkbox sanitization callback example.
   *
   * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
   * as a boolean value, either TRUE or FALSE.
   *
   * @param bool $checked Whether the checkbox is checked.
   * @return bool Whether the checkbox is checked.
   */
  function maranda_slug_sanitize_checkbox( $checked ) {
  	// Boolean check.
  	return ( ( isset( $checked ) && true == $checked ) ? true : false );
  }
}

if( !function_exists('maranda_slug_sanitize_css') ) {
  /**
   * CSS sanitization callback example.
   *
   * - Sanitization: css
   * - Control: text, textarea
   *
   * Sanitization callback for 'css' type textarea inputs. This callback sanitizes
   * `$css` for valid CSS.
   *
   * NOTE: wp_strip_all_tags() can be passed directly as `$wp_customize->add_setting()`
   * 'sanitize_callback'. It is wrapped in a callback here merely for example purposes.
   *
   * @see wp_strip_all_tags() https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
   *
   * @param string $css CSS to sanitize.
   * @return string Sanitized CSS.
   */
  function maranda_slug_sanitize_css( $css ) {
  	return wp_strip_all_tags( $css );
  }
}

if( !function_exists('maranda_slug_sanitize_dropdown_pages') ) {
  /**
   * Drop-down Pages sanitization callback example.
   *
   * - Sanitization: dropdown-pages
   * - Control: dropdown-pages
   *
   * Sanitization callback for 'dropdown-pages' type controls. This callback sanitizes `$page_id`
   * as an absolute integer, and then validates that $input is the ID of a published page.
   *
   * @see absint() https://developer.wordpress.org/reference/functions/absint/
   * @see get_post_status() https://developer.wordpress.org/reference/functions/get_post_status/
   *
   * @param int                  $page    Page ID.
   * @param WP_Customize_Setting $setting Setting instance.
   * @return int|string Page ID if the page is published; otherwise, the setting default.
   */
  function maranda_slug_sanitize_dropdown_pages( $page_id, $setting ) {
  	// Ensure $input is an absolute integer.
  	$page_id = absint( $page_id );

  	// If $page_id is an ID of a published page, return it; otherwise, return the default.
  	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
  }
}

if( !function_exists('maranda_slug_sanitize_email') ) {
  /**
   * Email sanitization callback example.
   *
   * - Sanitization: email
   * - Control: text
   *
   * Sanitization callback for 'email' type text controls. This callback sanitizes `$email`
   * as a valid email address.
   *
   * @see sanitize_email() https://developer.wordpress.org/reference/functions/sanitize_key/
   * @link sanitize_email() https://codex.wordpress.org/Function_Reference/sanitize_email
   *
   * @param string               $email   Email address to sanitize.
   * @param WP_Customize_Setting $setting Setting instance.
   * @return string The sanitized email if not null; otherwise, the setting default.
   */
  function maranda_slug_sanitize_email( $email, $setting ) {
  	// Strips out all characters that are not allowable in an email address.
  	$email = sanitize_email( $email );

  	// If $email is a valid email, return it; otherwise, return the default.
  	return ( ! is_null( $email ) ? $email : $setting->default );
  }
}

if( !function_exists('maranda_slug_sanitize_hex_color') ) {
  /**
   * HEX Color sanitization callback example.
   *
   * - Sanitization: hex_color
   * - Control: text, WP_Customize_Color_Control
   *
   * Note: sanitize_hex_color_no_hash() can also be used here, depending on whether
   * or not the hash prefix should be stored/retrieved with the hex color value.
   *
   * @see sanitize_hex_color() https://developer.wordpress.org/reference/functions/sanitize_hex_color/
   * @link sanitize_hex_color_no_hash() https://developer.wordpress.org/reference/functions/sanitize_hex_color_no_hash/
   *
   * @param string               $hex_color HEX color to sanitize.
   * @param WP_Customize_Setting $setting   Setting instance.
   * @return string The sanitized hex color if not null; otherwise, the setting default.
   */
  function maranda_slug_sanitize_hex_color( $hex_color, $setting ) {
  	// Sanitize $input as a hex value without the hash prefix.
  	$hex_color = sanitize_hex_color( $hex_color );

  	// If $input is a valid hex value, return it; otherwise, return the default.
  	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
  }
}

if( !function_exists('maranda_slug_sanitize_html') ) {
  /**
   * HTML sanitization callback example.
   *
   * - Sanitization: html
   * - Control: text, textarea
   *
   * Sanitization callback for 'html' type text inputs. This callback sanitizes `$html`
   * for HTML allowable in posts.
   *
   * NOTE: wp_filter_post_kses() can be passed directly as `$wp_customize->add_setting()`
   * 'sanitize_callback'. It is wrapped in a callback here merely for example purposes.
   *
   * @see wp_filter_post_kses() https://developer.wordpress.org/reference/functions/wp_filter_post_kses/
   *
   * @param string $html HTML to sanitize.
   * @return string Sanitized HTML.
   */
  function maranda_slug_sanitize_html( $html ) {
  	return wp_filter_post_kses( $html );
  }
}

if( !function_exists('maranda_slug_sanitize_image') ) {
  /**
   * Image sanitization callback example.
   *
   * Checks the image's file extension and mime type against a whitelist. If they're allowed,
   * send back the filename, otherwise, return the setting default.
   *
   * - Sanitization: image file extension
   * - Control: text, WP_Customize_Image_Control
   *
   * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
   *
   * @param string               $image   Image filename.
   * @param WP_Customize_Setting $setting Setting instance.
   * @return string The image filename if the extension is allowed; otherwise, the setting default.
   */
  function maranda_slug_sanitize_image( $image, $setting ) {
  	/*
  	 * Array of valid image file types.
  	 *
  	 * The array includes image mime types that are included in wp_get_mime_types()
  	 */
      $mimes = array(
          'jpg|jpeg|jpe' => 'image/jpeg',
          'gif'          => 'image/gif',
          'png'          => 'image/png',
          'bmp'          => 'image/bmp',
          'tif|tiff'     => 'image/tiff',
          'ico'          => 'image/x-icon'
      );
  	// Return an array with file extension and mime_type.
      $file = wp_check_filetype( $image, $mimes );
  	// If $image has a valid mime_type, return it; otherwise, return the default.
      return ( $file['ext'] ? $image : $setting->default );
  }
}

if( !function_exists('maranda_slug_sanitize_nohtml') ) {
  /**
   * No-HTML sanitization callback example.
   *
   * - Sanitization: nohtml
   * - Control: text, textarea, password
   *
   * Sanitization callback for 'nohtml' type text inputs. This callback sanitizes `$nohtml`
   * to remove all HTML.
   *
   * NOTE: wp_filter_nohtml_kses() can be passed directly as `$wp_customize->add_setting()`
   * 'sanitize_callback'. It is wrapped in a callback here merely for example purposes.
   *
   * @see wp_filter_nohtml_kses() https://developer.wordpress.org/reference/functions/wp_filter_nohtml_kses/
   *
   * @param string $nohtml The no-HTML content to sanitize.
   * @return string Sanitized no-HTML content.
   */
  function maranda_slug_sanitize_nohtml( $nohtml ) {
  	return wp_filter_nohtml_kses( $nohtml );
  }
}

if( !function_exists('maranda_slug_sanitize_number_absint') ) {
  /**
   * Number sanitization callback example.
   *
   * - Sanitization: number_absint
   * - Control: number
   *
   * Sanitization callback for 'number' type text inputs. This callback sanitizes `$number`
   * as an absolute integer (whole number, zero or greater).
   *
   * NOTE: absint() can be passed directly as `$wp_customize->add_setting()` 'sanitize_callback'.
   * It is wrapped in a callback here merely for example purposes.
   *
   * @see absint() https://developer.wordpress.org/reference/functions/absint/
   *
   * @param int                  $number  Number to sanitize.
   * @param WP_Customize_Setting $setting Setting instance.
   * @return int Sanitized number; otherwise, the setting default.
   */
  function maranda_slug_sanitize_number_absint( $number, $setting ) {
  	// Ensure $number is an absolute integer (whole number, zero or greater).
  	$number = absint( $number );

  	// If the input is an absolute integer, return it; otherwise, return the default
  	return ( $number ? $number : $setting->default );
  }
}

if( !function_exists('maranda_slug_sanitize_number_range') ) {
  /**
   * Number Range sanitization callback example.
   *
   * - Sanitization: number_range
   * - Control: number, tel
   *
   * Sanitization callback for 'number' or 'tel' type text inputs. This callback sanitizes
   * `$number` as an absolute integer within a defined min-max range.
   *
   * @see absint() https://developer.wordpress.org/reference/functions/absint/
   *
   * @param int                  $number  Number to check within the numeric range defined by the setting.
   * @param WP_Customize_Setting $setting Setting instance.
   * @return int|string The number, if it is zero or greater and falls within the defined range; otherwise,
   *                    the setting default.
   */
  function maranda_slug_sanitize_number_range( $number, $setting ) {

  	// Ensure input is an absolute integer.
  	$number = absint( $number );

  	// Get the input attributes associated with the setting.
  	$atts = $setting->manager->get_control( $setting->id )->input_attrs;

  	// Get minimum number in the range.
  	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );

  	// Get maximum number in the range.
  	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );

  	// Get step.
  	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );

  	// If the number is within the valid range, return it; otherwise, return the default
  	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
  }
}

if( !function_exists('maranda_slug_sanitize_select') ) {
  /**
   * Select sanitization callback example.
   *
   * - Sanitization: select
   * - Control: select, radio
   *
   * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
   * as a slug, and then validates `$input` against the choices defined for the control.
   *
   * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
   * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
   *
   * @param string               $input   Slug to sanitize.
   * @param WP_Customize_Setting $setting Setting instance.
   * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
   */
  function maranda_slug_sanitize_select( $input, $setting ) {

  	// Ensure input is a slug.
  	$input = sanitize_key( $input );

  	// Get list of choices from the control associated with the setting.
  	$choices = $setting->manager->get_control( $setting->id )->choices;

  	// If the input is a valid key, return it; otherwise, return the default.
  	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
  }
}

if( !function_exists('maranda_slug_sanitize_url') ) {
  /**
   * URL sanitization callback example.
   *
   * - Sanitization: url
   * - Control: text, url
   *
   * Sanitization callback for 'url' type text inputs. This callback sanitizes `$url` as a valid URL.
   *
   * NOTE: esc_url_raw() can be passed directly as `$wp_customize->add_setting()` 'sanitize_callback'.
   * It is wrapped in a callback here merely for example purposes.
   *
   * @see esc_url_raw() https://developer.wordpress.org/reference/functions/esc_url_raw/
   *
   * @param string $url URL to sanitize.
   * @return string Sanitized URL.
   */
  function maranda_slug_sanitize_url( $url ) {
  	return esc_url_raw( $url );
  }
}

if( !function_exists('maranda_slug_sanitize_js') ) {
  /**
   * js sanitization callback example.
   *
   * - Sanitization: js
   * - Control: text, js
   *
   * Sanitization callback for 'js' type text inputs. This callback sanitizes `$js` as a valid js.
   *   *
   * @see esc_js() https://developer.wordpress.org/reference/functions/esc_js/
   *
   * @param string $url URL to sanitize.
   * @return string Sanitized JS.
   */
  function maranda_slug_sanitize_js( $js ) {
  	return esc_js( $js );
  }
}

if( ! function_exists( 'maranda_str_lreplace' ) ) :
  /**
   * Replaces last instance of substring
   *
   * @param string $search - heystack
   * @param string $subject - needle
   * @param string $replace - replacement string
   * @return edited string
   */
  function maranda_str_lreplace($search, $replace, $subject) {
      $pos = strrpos($subject, $search);

      if($pos !== false) {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
      }

      return $subject;
  }

endif;

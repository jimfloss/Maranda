<?php
/**
 * maranda functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package maranda
 */

if ( ! function_exists( 'maranda_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function maranda_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on maranda, use a find and replace
		 * to change 'maranda' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'maranda', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'maranda' ),
	  		'menu-2' => esc_html__( 'Footer', 'maranda' ),
	  		'menu-3' => esc_html__( 'Header Utility', 'maranda' ),
	  		'menu-4' => esc_html__( 'Footer Utility', 'maranda' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'maranda_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'maranda_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function maranda_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'maranda_content_width', 640 );
}
add_action( 'after_setup_theme', 'maranda_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function maranda_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'maranda' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'maranda' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'maranda_widgets_init' );

/**
 * Special Navigation Classes
 * @param $classes
 * @param $item
 * @param $args
 * @param $depth
 */
function special_nav_class( $classes, $item, $args, $depth ){
     if($depth == 0){
      $classes[] = 'col-sm-12 col-md-auto';
     } else {
      $classes[] = 'col-sm-12 col-md-6';
     }

     return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 4);

/**
 * Customize Login Screen
 */
function maranda_customize_login() { ?>
  <style type="text/css">
  <?php if( get_theme_mod( 'login_logo' ) ) { ?>
    #login h1 a, .login h1 a {
      background-image: url(<?php echo get_theme_mod( 'login_logo' ); ?>);
    }
  <?php } ?>
  <?php echo get_theme_mod( 'login_custom_css' ); ?>
  </style>
<?php
}
add_action('login_enqueue_scripts', 'maranda_customize_login');

// Function to change email address
add_filter( 'wp_mail_from', 'wpb_sender_email' );
function wpb_sender_email( $original_email_address ) {
    return get_option('admin_email');
}

// Function to change sender name
add_filter('wp_mail_from_name', 'wpb_sender_name');
function wpb_sender_name( $original_email_from ) {
    return get_bloginfo('name');
}

/**
  * Exclude specific post types from search results
  */
function searchFilter($query) {
  if ($query->is_search) {
    $query->set('post_type', array('post', 'page', 'team', 'projects') );
  }
  return $query;
}
add_filter('pre_get_posts','searchFilter');

/**
 * Move Yoast to bottom
 */
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

/*
 * Update Yoast Social Media Links Automatically from Customizer
 * http://hookr.io/classes/wpseo_option_social/
 */
function update_yoast_social_media_links( ) {
  $options = get_option( 'wpseo_social' );

  if( $options ) {

    //Update Facebook
    if( !$options['facebook_site'] ) {
      if( get_theme_mod( 'facebook' ) ) {
        $options['facebook_site'] = get_theme_mod( 'facebook' );
      }
    }

    //Update Twitter
    if( !$options['twitter_site'] ) {
      if( get_theme_mod( 'twitter' ) ) {
        $options['twitter_site'] = explode( '.com/', get_theme_mod( 'twitter' ) )[1];
        $options['twitter_site'] = true;
        $options['twitter_card_type'] = 'summary';
      }
    }

    //Update Linkedin
    if( !$options['linkedin_url'] ) {
      if( get_theme_mod( 'linkedin' ) ) {
        $options['linkedin_url'] = get_theme_mod( 'linkedin' );
      }
    }

    //Update YouTube
    if( !$options['youtube_url'] ) {
      if( get_theme_mod( 'youtube' ) ) {
        $options['youtube_url'] = get_theme_mod( 'youtube' );
      }
    }

    //Update Instagram
    if( !$options['instagram_url'] ) {
      if( get_theme_mod( 'instagram' ) ) {
        $options['instagram_url'] = get_theme_mod( 'instagram' );
      }
    }

    //Update Pinterest
    if( !$options['pinterest_url'] ) {
      if( get_theme_mod( 'pinterest' ) ) {
        $options['pinterest_url'] = get_theme_mod( 'pinterest' );
      }
    }

    //Update Google+
    if( !$options['google_plus_url'] ) {
      if( get_theme_mod( 'google_plus' ) ) {
        $options['google_plus_url'] = get_theme_mod( 'google_plus' );
      }
    }

    update_option( 'wpseo_social', $options );
  }
}
add_action('init', 'update_yoast_social_media_links', 10);

/**
 * Hide Advanced Custom Fields from non-admins
 */
function my_acf_show_admin( $show ) {

	return current_user_can('manage_options');

}
add_filter('acf/settings/show_admin', 'my_acf_show_admin');

/**
 * Remove Dashboard Widgets
 */
function remove_dashboard_widgets () {

	remove_meta_box('dashboard_quick_press','dashboard','side'); //Quick Press widget
	remove_meta_box('dashboard_primary','dashboard','side'); //WordPress.com Blog
	remove_meta_box('dashboard_activity','dashboard', 'normal'); //Activity
	remove_action('welcome_panel','wp_welcome_panel');
	// remove_meta_box('dashboard_recent_drafts','dashboard','side'); //Recent Drafts
	// remove_meta_box('dashboard_secondary','dashboard','side'); //Other WordPress News
	// remove_meta_box('dashboard_incoming_links','dashboard','normal'); //Incoming Links
	//remove_meta_box('dashboard_plugins','dashboard','normal'); //Plugins
	// remove_meta_box('dashboard_right_now','dashboard', 'normal'); //Right Now
	// remove_meta_box('rg_forms_dashboard','dashboard','normal'); //Gravity Forms
	// remove_meta_box('dashboard_recent_comments','dashboard','normal'); //Recent Comments
	// remove_meta_box('icl_dashboard_widget','dashboard','normal'); //Multi Language Plugin
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

/**
 * Remove dashboard meta.
 */
function remove_dashboard_meta() {
  remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' );
}
add_action( 'admin_init', 'remove_dashboard_meta' );

/**
 * Add SVG Support to the theme.
 * Replaces Scalable Vector Graphics (SVG) plugin
 * @return $mimes
 */
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * Fix SVG display issues in admin area.
 */
function fix_svg_thumb_display() {
  echo '
    <style>
      td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
        width: 100% !important;
        height: auto !important;
      }
    </style>';
}
add_action('admin_head', 'fix_svg_thumb_display');

/**
 * Enqueue scripts and styles.
 */
function maranda_scripts() {

	wp_enqueue_style( 'maranda-style', get_stylesheet_uri() );
	
	//Enqueue jQuery, jQuery Core and jQuery Migrate in the footer
	wp_scripts()->add_data( 'jquery', 'group', 1 );
	wp_scripts()->add_data( 'jquery-core', 'group', 1 );
	wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );
	
	wp_enqueue_script( 'maranda-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'headroom', get_template_directory_uri() . '/js/headroom.min.js', array(), '0.9.4', true );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.min.js', array(), '3.0.5', true );
	wp_enqueue_script( 'instafeed', get_template_directory_uri() . '/js/instafeed.min.js', array(), '1.4.1', true );
	wp_enqueue_script( 'match-height', get_template_directory_uri() . '/js/match-height.min.js', array('jquery'), '0.7.2', true );
	wp_enqueue_script( 'scrollTo', get_template_directory_uri() . '/js/scrollTo.min.js', array('jquery'), '2.1.0', true );
	wp_enqueue_script( 'slick-slider', get_template_directory_uri() . '/js/slick.min.js', array('jquery'), '1.6.0', true );
	wp_enqueue_script( 'maranda-scripts', get_template_directory_uri() . '/js/maranda-scripts.js', array('jquery','match-height','scrollTo', 'slick-slider', 'headroom', 'isotope', 'instafeed' ), '0.0.1', true );
	
	//IMPORTANT The AJAX script must be named after the js AND the ajax object must be an underscore not a hyphen AND it has to go beneath the js
	wp_localize_script( 'maranda-scripts', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'maranda_scripts' );

/**
 * Registers an editor stylesheet for the theme.
 */
function wpdocs_theme_add_editor_styles() {
    add_editor_style( 'style-admin.css' );
}
add_action( 'admin_init', 'wpdocs_theme_add_editor_styles' );


//Implement the Custom Header feature.
require get_template_directory() . '/inc/custom-header.php';
//Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';
//Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';
//Customizer additions.
require get_template_directory() . '/inc/customizer.php';

//Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


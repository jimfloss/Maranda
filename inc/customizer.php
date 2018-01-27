<?php
/**
 * maranda Theme Customizer
 *
 * @package maranda
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'maranda_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'maranda_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'maranda_customize_register' );

/**
 * Upload Header Image
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_customizer_header_register( $wp_customize ) {

  // Header Logo
	$wp_customize->add_setting('header_logo', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_image'
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'control_logo_upload', array(
		'label'    => __( 'Upload Logo', 'maranda' ),
		'section'  => 'title_tagline',
		'settings' => 'header_logo',
	) ) );

}
add_action( 'customize_register', 'maranda_customizer_header_register' );

/**
 * Upload Header Image for Sub-pages
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_customizer_header_sub_register( $wp_customize ) {

  // Header Logo
	$wp_customize->add_setting('header_sub_logo', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_image'
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'control_sub_logo_upload', array(
		'label'    => __( 'Upload Sub Page Logo', 'maranda' ),
		'section'  => 'title_tagline',
		'settings' => 'header_sub_logo',
	) ) );

}
add_action( 'customize_register', 'maranda_customizer_header_sub_register' );

/**
 * Upload Header Image for Sub-pages
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_customizer_footer_logo_register( $wp_customize ) {

  // Header Logo
	$wp_customize->add_setting('footer_logo', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_image'
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'control_footer_logo_upload', array(
		'label'    => __( 'Upload Footer Logo', 'maranda' ),
		'section'  => 'title_tagline',
		'settings' => 'footer_logo',
	) ) );

}
add_action( 'customize_register', 'maranda_customizer_footer_logo_register' );

/**
 * Setup Global Content Panel
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function register_global_content_panel( $wp_customize ) {

  //Global Content
	$wp_customize->add_panel('global_content', array(
  	'title' => 'Global Content',
  	'priority' => 120,
  	'capability' => 'edit_theme_options',
  	'theme_supports' => '',
  	'description' => 'Content used on multiple pages or sections. i.e. contact info, social media links'
	));

	//Contact Information
	$wp_customize->add_section("contact_information", array(
  	'title' => 'Contact Information',
  	'priority' => 10,
  	'panel' => 'global_content'
	));

	//Locations
	$wp_customize->add_section("locations", array(
  	'title' => 'Locations',
  	'priority' => 10,
  	'panel' => 'global_content'
	));

	//Social Media
	$wp_customize->add_section("social_media", array(
  	'title' => 'Social Media',
  	'priority' => 10,
  	'panel' => 'global_content'
	));

	//Blog Archive
	$wp_customize->add_section("blog_archive", array(
  	'title' => 'Blog Archive',
  	'priority' => 10,
  	'panel' => 'global_content'
	));

	//Newsletter CTA
	$wp_customize->add_section("newsletter_cta", array(
  	'title' => 'Newsletter CTA',
  	'priority' => 10,
  	'panel' => 'global_content'
	));

	//Form IDs
	$wp_customize->add_section("form_ids", array(
  	'title' => 'Form IDs',
  	'priority' => 10,
  	'panel' => 'global_content'
	));

	//Login Styles
	$wp_customize->add_section("login_styles", array(
  	'title' => 'Login Styles',
  	'priority' => 10,
  	'panel' => 'global_content'
	));

}
add_action( 'customize_register', 'register_global_content_panel' );

/**
 * Add Contact Information
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_contact_1_register( $wp_customize ) {

	//Primary Number
  $wp_customize->add_setting('primary_number', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'primary_number', array(
   'label'   => 'Primary Number',
    'section'  => 'contact_information',
    'type'    => 'text',
  ));

	//Primary Fax
  $wp_customize->add_setting('primary_fax', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'primary_fax', array(
   'label'   => 'Primary Fax',
    'section'  => 'contact_information',
    'type'    => 'text',
  ));

	//Primary Email
  $wp_customize->add_setting('primary_email', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_email'
  ));
  $wp_customize->add_control( 'primary_email', array(
   'label'   => 'Primary Email',
    'section'  => 'contact_information',
    'type'    => 'text',
  ));
}
add_action( 'customize_register', 'maranda_contact_1_register' );

/**
 * Add Location Information
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_location_1_register( $wp_customize ) {
  //Location Image
	$wp_customize->add_setting('location_1_logo', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_image'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'location_1_logo_upload', array(
		'label'    => __( 'Upload Image', 'maranda' ),
		'section'  => 'locations',
		'settings' => 'location_1_logo',
	) ) );

	//location title
  $wp_customize->add_setting('location_1_title', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_1_title', array(
   'label'   => 'Location Title',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location Address
  $wp_customize->add_setting('location_1_address', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_1_address', array(
   'label'   => 'Location Address',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location city
  $wp_customize->add_setting('location_1_city', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_1_city', array(
   'label'   => 'Location City',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location state
  $wp_customize->add_setting('location_1_state', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_1_state', array(
   'label'   => 'Location State',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location zip
  $wp_customize->add_setting('location_1_zip', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_1_zip', array(
   'label'   => 'Location Zipcode',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location number
  $wp_customize->add_setting('location_1_number', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_1_number', array(
   'label'   => 'Location Phone Number',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location number
  $wp_customize->add_setting('location_1_directions', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_1_directions', array(
   'label'   => 'Directions',
    'section'  => 'locations',
    'type'    => 'text',
  ));
}
add_action( 'customize_register', 'maranda_location_1_register' );

/**
 * Add Location Information 2
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_location_2_register( $wp_customize ) {
  //Location Image
	$wp_customize->add_setting('location_2_logo', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_image'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'location_2_logo_upload', array(
		'label'    => __( 'Upload Image', 'maranda' ),
		'section'  => 'locations',
		'settings' => 'location_2_logo',
	) ) );

	//location title
  $wp_customize->add_setting('location_2_title', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_2_title', array(
   'label'   => 'Location Title',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location Address
  $wp_customize->add_setting('location_2_address', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_2_address', array(
   'label'   => 'Location Address',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location city
  $wp_customize->add_setting('location_2_city', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_2_city', array(
   'label'   => 'Location City',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location state
  $wp_customize->add_setting('location_2_state', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_2_state', array(
   'label'   => 'Location State',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location zip
  $wp_customize->add_setting('location_2_zip', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_2_zip', array(
   'label'   => 'Location Zipcode',
    'section'  => 'locations',
    'type'    => 'text',
  ));

	//location number
  $wp_customize->add_setting('location_2_number', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'location_2_number', array(
   'label'   => 'Location Phone Number',
    'section'  => 'locations',
    'type'    => 'text',
  ));
}
add_action( 'customize_register', 'maranda_location_2_register' );

/**
 * Add Social Media Information
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_social_media_register( $wp_customize ) {
  //LinkedIn
  $wp_customize->add_setting('linkedin', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_url'
  ));
  $wp_customize->add_control( 'linkedin', array(
   'label'   => 'LinkedIn URL',
    'section'  => 'social_media',
    'type'    => 'text',
  ));

	//Facebook
  $wp_customize->add_setting('facebook', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_url'
  ));
  $wp_customize->add_control( 'facebook', array(
   'label'   => 'Facebook URL',
    'section'  => 'social_media',
    'type'    => 'text',
  ));

  //Twitter
  $wp_customize->add_setting('twitter', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_url'
  ));
  $wp_customize->add_control( 'twitter', array(
   'label'   => 'Twitter URL',
    'section'  => 'social_media',
    'type'    => 'text',
  ));

  //YouTube
  $wp_customize->add_setting('youtube', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_url'
  ));
  $wp_customize->add_control( 'youtube', array(
   'label'   => 'YouTube URL',
    'section'  => 'social_media',
    'type'    => 'text',
  ));

  //Instagram
  $wp_customize->add_setting('instagram', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_url'
  ));
  $wp_customize->add_control( 'instagram', array(
   'label'   => 'Instagram URL',
    'section'  => 'social_media',
    'type'    => 'text',
  ));

  //Pinterest
  $wp_customize->add_setting('pinterest', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_url'
  ));
  $wp_customize->add_control( 'pinterest', array(
   'label'   => 'Pinterest URL',
    'section'  => 'social_media',
    'type'    => 'text',
  ));

  //Google Plus
  $wp_customize->add_setting('google_plus', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_url'
  ));
  $wp_customize->add_control( 'google_plus', array(
   'label'   => 'Google+ URL',
    'section'  => 'social_media',
    'type'    => 'text',
  ));

  //Blog
  $wp_customize->add_setting('blog', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_url'
  ));
  $wp_customize->add_control( 'blog', array(
   'label'   => 'Blog URL',
    'section'  => 'social_media',
    'type'    => 'text',
  ));

  //Snapchat
  $wp_customize->add_setting('snap', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_url'
  ));
  $wp_customize->add_control( 'snap', array(
   'label'   => 'Snapchat',
    'section'  => 'social_media',
    'type'    => 'text',
  ));
}
add_action( 'customize_register', 'maranda_social_media_register' );

/**
 * Add Blog Hero and Blurb Support
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_global_blog_register( $wp_customize ) {
  //Blog Hero Image
	$wp_customize->add_setting('blog_hero_logo', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_image'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'blog_logo_upload', array(
		'label'    => __( 'Upload Image', 'maranda' ),
		'section'  => 'blog_archive',
		'settings' => 'blog_hero_logo',
	) ) );

  //Blog Blurb
  $wp_customize->add_setting('blog_blurb', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_html'
  ));
  $wp_customize->add_control( 'blog_blurb', array(
   'label'   => 'Blog Blurb',
    'section'  => 'blog_archive',
    'type'    => 'textarea',
  ));
}
add_action( 'customize_register', 'maranda_global_blog_register' );

/**
 * Add Newsletter CTA
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_global_newsletter_register( $wp_customize ) {

  //Newsletter Title
  $wp_customize->add_setting('newsletter_title', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'newsletter_title', array(
   'label'   => 'Newsletter Title',
    'section'  => 'newsletter_cta',
    'type'    => 'text',
  ));

  //Newsletter Blurb
  $wp_customize->add_setting('newsletter_blurb', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_html'
  ));
  $wp_customize->add_control( 'newsletter_blurb', array(
   'label'   => 'Newsletter Blurb',
    'section'  => 'newsletter_cta',
    'type'    => 'textarea',
  ));
}
add_action( 'customize_register', 'maranda_global_newsletter_register' );

/**
 * Add Forms for Header and Footer with Blurbs
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_global_form_register( $wp_customize ) {
  //Header Form Blurb
  $wp_customize->add_setting('header_form_blurb', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'header_form', array(
   'label'   => 'Header Form Blurb',
    'section'  => 'form_ids',
    'type'    => 'text',
  ));

  //Header Form ID
  $wp_customize->add_setting('form_id_header', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'form_id_header', array(
   'label'   => 'Header Form ID',
    'section'  => 'form_ids',
    'type'    => 'text',
  ));

  //Footer Form Blurb
  $wp_customize->add_setting('footer_form_blurb', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'footer_form', array(
   'label'   => 'Footer Form Blurb',
    'section'  => 'form_ids',
    'type'    => 'text',
  ));

  //Footer Form ID
  $wp_customize->add_setting('form_id_footer', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_nohtml'
  ));
  $wp_customize->add_control( 'form_id_footer', array(
   'label'   => 'Footer Form ID',
    'section'  => 'form_ids',
    'type'    => 'text',
  ));
}
add_action( 'customize_register', 'maranda_global_form_register' );

/**
 * Customize Login Page
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function maranda_login_styles_register( $wp_customize ) {
  //Login Image
	$wp_customize->add_setting('login_logo', array(
		'type' => 'theme_mod',
		'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_image'
	));
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'login_logo_upload', array(
		'label'    => __( 'Upload Image', 'maranda' ),
		'section'  => 'login_styles',
		'settings' => 'login_logo',
	) ) );

	//Login CSS
  $wp_customize->add_setting('login_custom_css', array(
    'type' => 'theme_mod',
    'capability' => 'edit_theme_options',
		'default' => '',
		'transport' => '',
		'sanitize_callback' => 'maranda_slug_sanitize_css'
  ));
  $wp_customize->add_control( 'login_custom_css', array(
   'label'   => 'Login Custom CSS',
    'section'  => 'login_styles',
    'type'    => 'textarea',
  ));

}
add_action( 'customize_register', 'maranda_login_styles_register' );

/**
 * Render the site title for the selective refresh partial.
 * @return void
 */
function maranda_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 * @return void
 */
function maranda_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function maranda_customize_preview_js() {
	wp_enqueue_script( 'maranda-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'maranda_customize_preview_js' );

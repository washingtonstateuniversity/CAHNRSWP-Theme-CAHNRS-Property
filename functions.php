<?php

include_once( __DIR__ . '/includes/customizer.php' ); // Include CAHNRS customizer functionality.

/**
 * Set up a theme hook for the site header.
 */
function cahnrswp_site_header() {
	do_action( 'cahnrswp_site_header' );
}

class WSU_CAHNRS_Property_Theme {
	
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'dequeue_scripts' ), 21 );
		add_action( 'cahnrswp_site_header', array( $this, 'cahnrswp_default_header' ), 1 );
		add_filter( 'mce_buttons_2', array( $this, 'mce_buttons_2' ) );
		add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_filter( 'theme_page_templates', array( $this, 'theme_page_templates' ) );
	}

	/**
 	 * Remove certain things Wordpress adds to the header.
 	 */
	public function init() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_action( 'wp_head', 'feed_links_extra', 3 ); 
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'parent_post_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'start_post_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		remove_action( 'wp_head', 'rel_canonical');
		remove_action( 'wp_head', 'wp_generator' );
		add_filter( 'tiny_mce_plugins', array( $this, 'disable_emojis_tinymce' ) );
	}

	/**
	 * Filter function to remove the tinymce emoji plugin.
	 * 
	 * @param array $plugins  
	 * @return array Difference betwen the two arrays
	 */
	public function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	/**
	 * Enqueue scripts and styles required for front end pageviews.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'cahnrs', 'http://m1.wpdev.cahnrs.wsu.edu/global/cahnrs.css', array( 'spine-theme' ) );
		wp_enqueue_style( 'spine-theme-child', get_stylesheet_directory_uri() . '/style.css', array( 'cahnrs' ) );
		wp_enqueue_script( 'cahnrs', 'http://m1.wpdev.cahnrs.wsu.edu/global/cahnrs.js', array( 'jquery' ) );
	}

	/**
	 * Dequeue Spine Bookmark stylesheet.
	 */
	public function dequeue_scripts() {
		wp_dequeue_style( 'spine-theme-extra' );
	}

	/**
	 * Add the default header via hook.
	 */
	public function cahnrswp_default_header() {
		get_template_part( 'parts/default-header' );
	}

	/**
	 * Add Table controls to tinyMCE editor.
	 */
	public function mce_buttons_2( $buttons ) {
		 array_push( $buttons, 'table' );
		 return $buttons;
	}

	/**
	 * Register the tinyMCE Table plugin.
	 */
	public function mce_external_plugins( $plugin_array ) {
		 $plugin_array['table'] = get_stylesheet_directory_uri() . '/tinymce/table-plugin.min.js';
		 return $plugin_array;
	}

	/**
	 * Body classes.
	 */
	public function body_class( $classes ) {
		if ( get_post_meta( get_the_ID(), 'body_class', true ) ) {
			$classes[] = esc_attr( get_post_meta( get_the_ID(), 'body_class', true ) );
		}
		if ( is_customize_preview() ) {
			$classes[] = 'customizer-preview';
		}
		$classes[] = 'spine-' . esc_attr( spine_get_option( 'spine_color' ) );
		return $classes;
	}

	/**
	 * Remove most of the Spine page templates.
	 */
	public function theme_page_templates( $templates ) {
		unset( $templates['templates/blank.php'] );
		unset( $templates['templates/halves.php'] );
		unset( $templates['templates/margin-left.php'] );
		unset( $templates['templates/margin-right.php'] );
		unset( $templates['templates/section-label.php'] );
		unset( $templates['templates/side-left.php'] );
		//unset( $templates['templates/side-right.php'] );
		unset( $templates['templates/single.php'] );
		return $templates;
	}
	
}

new WSU_CAHNRS_Property_Theme();
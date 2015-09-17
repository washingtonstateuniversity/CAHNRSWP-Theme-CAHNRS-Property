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
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 21 );
		add_action( 'cahnrswp_site_header', array( $this, 'cahnrswp_default_header' ), 1 );
		add_filter( 'mce_buttons_2', array( $this, 'mce_buttons_2' ) );
		add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
		add_filter( 'theme_page_templates', array( $this, 'theme_page_templates' ) );
	}

	/**
	 * Enqueue scripts and styles required for front end pageviews.
	 */
	public function enqueue_scripts() {
		wp_dequeue_style( 'spine-theme-extra' );
		wp_enqueue_style( 'cahnrs', 'http://m1.wpdev.cahnrs.wsu.edu/global/cahnrs.css', array( 'wsu-spine' ) );
		wp_enqueue_script( 'cahnrs', 'http://m1.wpdev.cahnrs.wsu.edu/global/cahnrs.js', array( 'jquery' ) );
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
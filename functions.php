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
		add_action( 'edit_form_after_title', array( $this, 'edit_form_after_title' ), 1 );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ), 10, 1 );
		add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		add_filter( 'mce_buttons_2', array( $this, 'mce_buttons_2' ) );
		add_filter( 'mce_external_plugins', array( $this, 'mce_external_plugins' ) );
		add_filter( 'theme_page_templates', array( $this, 'theme_page_templates' ) );
		add_filter( 'body_class', array( $this, 'body_class' ) );
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
		$cahnrs_tooling = spine_get_option( 'cahnrs_tooling' );
		if ( 'develop' !== $cahnrs_tooling && 'disable' !== $cahnrs_tooling && 0 === absint( $cahnrs_tooling ) ) {
			$cahnrs_tooling = 0;
		}
		if ( 'disable' !== $cahnrs_tooling ) {
			wp_enqueue_style( 'cahnrs', 'http://repo.wsu.edu/cahnrs/' . $cahnrs_tooling . '/cahnrs.min.css', array( 'spine-theme' ) );
			wp_enqueue_script( 'cahnrs', 'http://repo.wsu.edu/cahnrs/' . $cahnrs_tooling . '/cahnrs.min.js', array( 'jquery' ) );
		}
	}

	/**
	 * Dequeue Spine Bookmark stylesheet (only a precaution) and empty child theme stylesheet.
	 */
	public function dequeue_scripts() {
		wp_dequeue_style( 'spine-theme-extra' );
		wp_dequeue_style( 'spine-theme-child' );
	}

	/**
	 * Add the default header via hook.
	 */
	public function cahnrswp_default_header() {
		get_template_part( 'parts/default-header' );
	}

	/**
	 * Add a 'Hide Title' checkbox after the title.
	 *
	 * @param WP_Post $post
	 */
	public function edit_form_after_title( $post ) {
		if ( 'page' !== $post->post_type ) {
			return;
		}
		wp_nonce_field( 'cahnrswp_hide_title', 'cahnrswp_hide_title_nonce' );
		$value = get_post_meta( $post->ID, '_cahnrswp_hide_title', true );
		?><label><input type="checkbox" name="_cahnrswp_hide_title" value="1" <?php checked( $value, '1' ); ?> /> Hide Title</label><?php
	}

	/**
	 * Add custom meta boxes. (Restrict to displaying only when PB is not active for posts?)
	 *
	 * @param string $post_type The slug of the current post type.
	 */
	public function add_meta_boxes( $post_type ) {
		if ( 'post' !== $post_type ) {
			return;
		}
		add_meta_box(
			'cahnrswp_post_sidebar',
			'Post Sidebar',
			array( $this, 'cahnrswp_post_sidebar' ),
			'post',
			'side',
			'default'
		);
	}

	/**
	 * Post sidebar selection markup.
	 */
	public function cahnrswp_post_sidebar( $post ) {
		wp_nonce_field( 'cahnrswp_sidebar', 'cahnrswp_sidebar_nonce' );
		$sidebar = get_post_meta( $post->ID, '_cahnrswp_sidebar', true );
		?><select name="_cahnrswp_sidebar">
			<option value="">select</option>
			<?php
			global $wp_registered_sidebars;
			if ( empty( $wp_registered_sidebars ) ) {
				return	$post_id;
			}
			$value = get_post_meta( $post->ID, '_cahnrswp_sidebar', true );
			foreach ( $wp_registered_sidebars as $sidebar ) : ?>
				<option value="<?php echo $sidebar['id']; ?>" <?php selected( $value, $sidebar['id'] ); ?>><?php echo $sidebar['name']; ?></option>
    	<?php endforeach; ?>
		</select><?php
	}

	/**
	 * Save custom data.
	 *
	 * @param int $post_id
	 *
	 * @return mixed
	 */
	public function save_post( $post_id, $post ) {
		// Bail if autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		// Bail if user doesn't have adequate permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		if ( 'page' == $post->post_type ) {
			// Check nonce.
			if ( ! isset( $_POST['cahnrswp_hide_title_nonce'] ) ) {
				return $post_id;
			}
			$nonce = $_POST['cahnrswp_hide_title_nonce'];
			if ( ! wp_verify_nonce( $nonce, 'cahnrswp_hide_title' ) ) {
				return $post_id;
			}
			// Sanitize and save 'hide title' option.
			if ( isset( $_POST['_cahnrswp_hide_title'] ) ) {
				update_post_meta( $post_id, '_cahnrswp_hide_title', 1 );
			} else {
				delete_post_meta( $post_id, '_cahnrswp_hide_title' );
			}
		}
		if ( 'post' == $post->post_type ) {
			// Check nonce.
			if ( ! isset( $_POST['cahnrswp_sidebar_nonce'] ) ) {
				return $post_id;
			}
			$nonce = $_POST['cahnrswp_sidebar_nonce'];
			if ( ! wp_verify_nonce( $nonce, 'cahnrswp_sidebar' ) ) {
				return $post_id;
			}
			// Sanitize and save post sidebar selection.
			if ( isset( $_POST['_cahnrswp_sidebar'] ) ) {
				update_post_meta( $post_id, '_cahnrswp_sidebar', sanitize_text_field( $_POST['_cahnrswp_sidebar'] ) );
			} else {
				delete_post_meta( $post_id, '_cahnrswp_sidebar' );
			}
		}
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
	 * Remove most of the Spine page templates.
	 */
	public function theme_page_templates( $templates ) {
		unset( $templates['templates/blank.php'] );
		unset( $templates['templates/halves.php'] );
		unset( $templates['templates/margin-left.php'] );
		unset( $templates['templates/margin-right.php'] );
		unset( $templates['templates/section-label.php'] );
		unset( $templates['templates/side-left.php'] );
		unset( $templates['templates/side-right.php'] );
		unset( $templates['templates/single.php'] );
		return $templates;
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
	
}

new WSU_CAHNRS_Property_Theme();
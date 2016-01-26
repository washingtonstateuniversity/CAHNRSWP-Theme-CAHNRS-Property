<?php
$spine_main_header_values = spine_get_main_header();

if ( is_archive() ) {
	if ( ! is_post_type_archive( 'post' ) || 'post' !== get_post_type() ) {
		$post_type = get_post_type_object( get_post_type( $post ) );
		$spine_main_header_values['page_title'] = $post_type->labels->name;
		$spine_main_header_values['post_title'] = $post_type->labels->name;
		$spine_main_header_values['sub_header_default'] = $post_type->labels->name;
	}
}

$parent_unit = spine_get_option( 'cahnrs_header_unit_parent' );
?>

<div class="cahnrs-header-group<?php
	echo ( spine_get_option( 'cahnrs_fixed_header_behavior' ) ) ? ' disable-js' : '';
	echo ( spine_get_option( 'cahnrs_header_bg_color' ) ) ? ' ' . esc_attr( spine_get_option( 'cahnrs_header_bg_color' ) ) : ' gray';
	echo ( spine_get_option( 'cahnrs_header_fixed' ) ) ? ' fixed' : '';
	echo ( spine_get_option( 'cahnrs_header_bg_vellum' ) && has_post_thumbnail() && is_page() ) ? ' ' . esc_attr( spine_get_option( 'cahnrs_header_bg_vellum' ) ) : '';
?>">
		<div id="cahnrs-heading">
			<a href="http://cahnrs.wsu.edu/">CAHNRS</a>
			<?php /*
				$cahnrs_menu_response = wp_remote_get( 'https://cahnrs.wsu.edu/wp-json/wp/v2/global-menu' );
				if ( ! is_wp_error( $cahnrs_menu_response ) ) :
					$data = wp_remote_retrieve_body( $cahnrs_menu_response );
					if ( ! empty( $data ) ) :
						$cahnrs_menu = json_decode( $data );
						?>
						<div class="quicklinks">
							<dl>
								<dt><a href="http://cahnrs.wsu.edu/">College of Agricultural, Human, and Natural Resource Sciences</a></dt>
								<span class="cahnrs-ql-padding">CAHNRS</span><dd>
					 			<?php echo $cahnrs_menu; ?>
								</dd>
							</dl>
						</div>
        		<?php
					endif;
				endif;*/
			?>
			<div class="quicklinks">
				<dl>
					<dt><a href="http://cahnrs.wsu.edu/">College of Agricultural, Human, and Natural Resource Sciences</a></dt>
					<span class="cahnrs-ql-padding">CAHNRS</span><dd>
						 <ul>
							<li><a href="http://cahnrs.wsu.edu/academics/">Academics</a></li>
							<li><a href="http://cahnrs.wsu.edu/research/">Research</a></li>
							<li><a href="http://cahnrs.wsu.edu/extension/">Extension</a></li>
							<li><a href="http://cahnrs.wsu.edu/alumni/">Alumni and Friends</a></li>
							<li><a href="http://cahnrs.wsu.edu/fs/">Faculty and Staff</a></li>
						</ul>
					</dd>
				</dl>
			</div>
		</div><?php if ( $parent_unit ) : ?><div id="extension-heading">
			<?php
				if ( 'extension' === $parent_unit ) {
					$parent_unit_url = 'https://extension.wsu.edu/';
				} elseif ( 'research' === $parent_unit ) {
					$parent_unit_url = 'https://cahnrs.wsu.edu/research/';
				} elseif ( 'operations' === $parent_unit ) {
					$parent_unit_url = 'https://cahnrs.wsu.edu/operations/';
				}
			?>
			<a href="<?php echo esc_url( $parent_unit_url ); ?>"><?php echo ucfirst( esc_html( $parent_unit ) ); ?></a>
			<?php /*
				// @todo Set up generous caching (perhaps wp_cache_set, wp_cache_get).
				$parent_menu_response = wp_remote_get( esc_url( $parent_unit_url ) . 'wp-json/wp/v2/global-menu' );
				if ( ! is_wp_error( $parent_menu_response ) ) :
					$data = wp_remote_retrieve_body( $parent_menu_response );
					if ( ! empty( $data ) ) :
						$parent_menu = json_decode( $data );
						?>
						<div class="quicklinks">
							<dl>
								<dt><a href="<?php echo esc_url( $parent_unit_url ); ?>"><?php echo ucfirst( esc_html( $parent_unit ) ); ?></a></dt><dd>
					 			<?php echo $parent_menu; ?>
								</dd>
							</dl>
						</div>
        		<?php
					endif;
				endif;*/
			?>
		</div><?php endif; ?><sup class="sup-header" data-section="<?php echo $spine_main_header_values['section_title']; ?>" data-pagetitle="<?php echo $spine_main_header_values['page_title']; ?>" data-posttitle="<?php echo $spine_main_header_values['post_title']; ?>" data-default="<?php echo esc_html($spine_main_header_values['sup_header_default']); ?>" data-alternate="<?php echo esc_html($spine_main_header_values['sup_header_alternate']); ?>">
			<span class="sup-header-default"><?php echo strip_tags( $spine_main_header_values['sup_header_default'], '<a>' ); ?></span>
		</sup>
	</div>
	<?php if ( is_front_page() ) : ?>
	<sub class="sub-header" data-sitename="<?php echo $spine_main_header_values['site_name']; ?>" data-pagetitle="<?php echo $spine_main_header_values['page_title']; ?>" data-posttitle="<?php echo $spine_main_header_values['post_title']; ?>" data-default="<?php echo esc_html( $spine_main_header_values['sub_header_default'] ); ?>" data-alternate="<?php echo esc_html($spine_main_header_values['sub_header_alternate']); ?>">
		<span class="sub-header-default"><?php echo strip_tags( $spine_main_header_values['sub_header_default'], '<a>' ); ?></span>
	</sub>
	<?php endif; ?>
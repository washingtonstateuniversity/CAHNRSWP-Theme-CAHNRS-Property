<?php if ( spine_get_option( 'main_header_show' ) == 'true' ) : ?>

<header class="main-header<?php echo ( spine_get_option( 'cahnrs_header_bg_color' ) ) ? ' ' . esc_attr( spine_get_option( 'cahnrs_header_bg_color' ) ) : ' gray'; ?>">

	<?php cahnrswp_site_header(); ?>

</header>

<?php endif; ?>
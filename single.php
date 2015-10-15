<?php

get_header();

// If a featured image is assigned to the post, display as a background image.
if ( spine_has_background_image() ) {
	$background_image_src = spine_get_background_image_src();

	?><style> html { background-image: url('<?php echo esc_url( $background_image_src ); ?>'); }</style><?php
}
?>

<main>

<?php get_template_part('parts/headers'); ?>

<?php if ( class_exists( 'CWP_Pagebuilder' ) && has_shortcode( get_the_content(), 'section' ) ) : ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<header class="article-header">
					<h1 class="article-title"><?php the_title(); ?></h1>
				</header>

				<?php the_content(); ?>

			</div>

<?php else: ?>

	<?php get_template_part( 'parts/single-layout', get_post_type() ); ?>

<?php endif; ?>

<footer class="main-footer">
	<section class="row halves pager prevnext gutter pad-ends">
		<div class="column one">
			<?php previous_post_link(); ?>
		</div>
		<div class="column two">
			<?php next_post_link(); ?>
		</div>
	</section><!--pager-->
</footer>

	<?php get_template_part( 'parts/footers' ); ?>

</main><!--/#page-->

<?php get_footer(); ?>
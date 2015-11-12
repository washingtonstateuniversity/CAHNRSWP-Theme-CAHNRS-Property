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

	<?php if ( class_exists( 'CWP_Pagebuilder' ) && has_shortcode( get_the_content(), 'row' ) ) : ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class( 'builder-layout' ); ?>>

			<header class="article-header">
				<h1 class="article-title"><?php the_title(); ?></h1>
			</header>

			<?php the_content(); ?>

		</div>

	<?php else: ?>

		<?php $sidebar = get_post_meta( get_the_ID(), '_cahnrswp_sidebar', true ); ?>

		<?php echo $sidebar; ?>

		<?php $layout = ( $sidebar ) ? 'side-right' : 'single'; ?>

		<section class="row <?php echo $layout; ?> gutter pad-ends">

			<div class="column one">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'articles/post', get_post_type() ) ?>

				<?php endwhile; ?>

			</div><!--/column-->

			<?php if ( $sidebar ) : ?>

				<div class="column two">

					<?php if ( is_active_sidebar( $sidebar ) ) : ?>
						<?php dynamic_sidebar( $sidebar ); ?>
					<?php endif; ?>

				</div><!--/column two-->

			<?php endif; ?>

		</section>

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
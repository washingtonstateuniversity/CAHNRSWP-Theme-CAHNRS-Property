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

	<?php while ( have_posts() ) : the_post(); ?>

		<?php if ( class_exists( 'CWP_Pagebuilder' ) && has_shortcode( get_the_content(), 'row' ) ) : ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class( 'builder-layout' ); ?>>

				<header class="article-header">
					<hgroup>
						<h1 class="article-title"><?php the_title(); ?></h1>
					</hgroup>
					<hgroup class="source">
						<time class="article-date" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
						<cite class="article-author" role="author"><?php the_author_posts_link(); ?></cite>
					</hgroup>
				</header>

				<?php the_content(); ?>

			</div>

		<?php else: ?>

			<?php $sidebar = get_post_meta( get_the_ID(), '_cahnrswp_sidebar', true ); ?>

			<?php $layout = ( $sidebar ) ? 'side-right' : 'single'; ?>

			<section class="row <?php echo $layout; ?> gutter pad-ends">

				<div class="column one">

					<?php get_template_part( 'articles/post', get_post_type() ) ?>

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

	<?php endwhile; ?>

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
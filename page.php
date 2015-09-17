<?php get_header(); ?>

	<main class="spine-blank-template">

		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

			<?php get_template_part('parts/headers'); ?>
			<?php get_template_part('parts/featured-images'); ?>

			<?php //if ( class_exists( 'pagebuilder' ) ) : ?>

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php the_content(); ?>

			</div>

			<?php /*else : ?>

			<section class="row side-right gutter pad-ends">

				<div class="column one">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part('articles/article'); ?>

					<?php endwhile; ?>

				</div><!--/column-->

				<div class="column two">

					<?php get_sidebar(); ?>

				</div><!--/column two-->

			</section>

			<?php endif; */ ?>

		<?php endwhile; endif; ?>

		<?php get_template_part( 'parts/footers' ); ?>

	</main>

<?php get_footer(); ?>
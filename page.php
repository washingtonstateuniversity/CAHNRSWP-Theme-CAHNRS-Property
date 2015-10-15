<?php get_header(); ?>

	<main class="spine-blank-template">

		<?php get_template_part('parts/headers'); ?>
		<?php get_template_part('parts/featured-images'); ?>

		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

      <?php if ( class_exists( 'CWP_Pagebuilder' ) && has_shortcode( get_the_content(), 'section' ) ) : ?>

			<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! is_front_page() ) : ?>
				<header class="article-header">
					<h1 class="article-title"><?php the_title(); ?></h1>
				</header>
				<?php endif; ?>

				<?php the_content(); ?>

			</div>

			<?php else : ?>

			<section class="row side-right gutter pad-ends">

				<div class="column one">

						<?php get_template_part('articles/article'); ?>

				</div><!--/column-->

				<div class="column two">

					<?php get_sidebar(); ?>

				</div><!--/column two-->

			</section>

			<?php endif; ?>

		<?php endwhile; endif; ?>

		<?php get_template_part( 'parts/footers' ); ?>

	</main>

<?php get_footer(); ?>
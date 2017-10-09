<?php
/**
 * The template for displaying all pages.
 */

get_header(); ?>


	<?php while ( have_posts() ) : the_post(); ?>
		<div class="container">
			<?php get_template_part( 'content', 'page' ); ?>
		</div>
	<?php endwhile; ?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
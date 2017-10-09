<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page.
 */

get_header(); ?>

	
	<?php while ( have_posts() ) : the_post(); ?>
		<div class="container">
			<?php get_template_part( 'landing', 'page' ); ?>
		</div>
	<?php endwhile; // end of the loop. ?>

	
<?php get_footer(); ?>
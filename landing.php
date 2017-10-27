<?php
/**
 * The default template for displaying content.
 */
?>

	<article <?php post_class(); ?>>
		
		<div>
			<div class="row intro-row">
				<div class="col-md-12 intro-column-content">
					<h1><?php echo get_theme_mod( 'landing_page_intro_section_1'); ?></h1>
					<p></p>
				</div>
			</div>
			<div class="row statistic-row">
				<div class="col-md-4 statistic-column-content-odd">
					<img src="<?php echo get_theme_mod( 'landing_page_statistics_section_image_1'); ?>" ?>
				</div>
				<div class="col-md-4 statistic-column-content-even">
					<img src="<?php echo get_theme_mod( 'landing_page_statistics_section_image_2'); ?>" ?>
				</div>
				<div class="col-md-4 statistic-column-content-odd">
					<img src="<?php echo get_theme_mod( 'landing_page_statistics_section_image_3'); ?>" ?>
				</div>
			</div>
			<div class="row ottawa-row">
				<div class="col-md-12 ottawa-column-content">
					<h2><?php echo get_theme_mod( 'landing_page_ottawa_section_1'); ?></h2>
					<p><?php echo get_theme_mod( 'landing_page_ottawa_section_2', 'Ottawa info'); ?></p>
					<a class="btn ottawa-column-a" href="<?php echo get_theme_mod( 'landing_page_ottawa_section_3', '#'); ?>"><?php echo get_theme_mod( 'landing_page_ottawa_section_4', 'Learn more'); ?></a>
				</div>
			</div>
			<div class="row program-row">
				<div class="col-md-9 program-column-media">
				</div>
				<div class="col-md-3 program-column-list">
					<h2><?php echo get_theme_mod( 'landing_page_program_section_1'); ?></h2>
					<?wp_nav_menu( array( 'theme_location' => 'program-menu', 'items_wrap' => '<ul class="footer-column-ul">%3$s</ul>' ) ); ?>
				</div>
			</div>
			<div class="row youtube-row">
				<div class="col-md-12 youtube-column-content">
					<h2><?php echo get_theme_mod( 'landing_page_youtube_section_1'); ?></h2>
					<p><?php echo get_theme_mod( 'landing_page_youtube_section_2', 'Ottawa info'); ?></p>
					<a class="btn youtube-column-a" target="_blank" href="<?php echo get_theme_mod( 'landing_page_youtube_section_3', '#'); ?>"><?php echo get_theme_mod( 'landing_page_youtube_section_4', 'View'); ?></a>
				</div>
			</div>
			<!--<div class="row testimonial-row-odd">
				<div class="col-md-2 testimonial-column-media">
				</div>
				<div class="col-md-4 testimonal-column-text">
				</div>
				<div class="col-md-2 testimonial-column-media">
				</div>
				<div class="col-md-4 testimonal-column-text">
				</div>
			</div>
			<div class="row testimonial-row-even">
				<div class="col-md-4 testimonal-column-media">
				</div>
				<div class="col-md-2 testimonial-column-media">
				</div>
				<div class="col-md-4 testimonal-column-media">
				</div>
				<div class="col-md-2 testimonial-column-media">
				</div>
			</div>-->
		</div>

	</article>

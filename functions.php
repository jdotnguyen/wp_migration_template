<?php
/**
 * Migration functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 */


/**
 * Sets up theme defaults and registers the various WordPress features that
 * the Migration theme supports.
 *
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 */
function migration_setup() {

	// This theme styles the visual editor with editor-style.css to give it some niceties.
	add_editor_style();

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'migration' ) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 500, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'migration_setup' );


/**
 * Enqueues scripts and styles for front-end.
 */
function migration_scripts_styles() {
	global $wp_styles;

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'migration-style', get_stylesheet_uri() );

	/*
	 * Optional: Loads the Internet Explorer specific stylesheet.
	 */
	//wp_enqueue_style( 'migration-ie', get_template_directory_uri() . '/css/ie.css', array( 'migration-style' ), '20121010' );
	//$wp_styles->add_data( 'migration-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'migration_scripts_styles' );

//Custom headers
$args = array(
	'width'         => 100,
	'default-image' => get_template_directory_uri() . '/images/header.png',
);
add_theme_support( 'custom-header', $args );

//Custom navigation menus
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'program-menu' => __( 'Landing Page - Program Menu' ),
      'footer-menu1' => __( 'Footer Menu 1' ),
	  'footer-menu2' => __( 'Footer Menu 2' ),
	  'footer-menu3' => __( 'Footer Menu 3' ),
      'sidebar-menu' => __( 'Sidebar Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

//Style anchors
add_filter('nav_menu_link_attributes', 'wpse156165_menu_add_class', 10, 3 );

function wpse156165_menu_add_class( $atts, $item, $args ) {
    $class = 'nav-link'; // or something based on $item
    $atts['class'] = $class;
    return $atts;
}

//Style nav with active depending on page
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}

//Add class to menu LI items
// Remove id from nav menu items
add_filter( 'nav_menu_item_id', '__return_empty_string' );

// Add 'nav-item' class
add_filter( 'nav_menu_css_class', 'My_Theme_nav_menu_item_class', 10, 4 );

function My_Theme_nav_menu_item_class( $classes , $item, $args, $depth ) {

	$new_classes = array( 'nav-item' );
	if ( in_array( 'current-menu-item', $classes ) ) {
		$new_classes[] = 'selected';
	}

	return $new_classes;
}

// Add 'nav-link' class
add_filter( 'nav_menu_link_attributes', 'My_Theme_nav_menu_link_atts', 10, 4 );

function My_Theme_nav_menu_link_atts( $atts, $item, $args, $depth ) {
	$new_atts = array( 'class' => 'nav-link' );
	if ( isset( $atts['href'] ) ) {
		$new_atts['href'] = $atts['href'];
	}

	return $new_atts;
}

function html5blank_nav() {
	if ( $menu ) {
		echo $html . $menu .  '</nav>';
	}
}

//Nested menu anchor fix
add_filter( 'nav_menu_link_attributes', 'add_class_to_items_link', 10, 3 );

function add_class_to_items_link( $atts, $item, $args ) {
  // check if the item has children
  $hasChildren = (in_array('menu-item-has-children', $item->classes));
  if ($hasChildren) {
    // add the desired attributes:
    $atts['class'] = 'nav-link dropdown-toggle';
    $atts['data-toggle'] = 'dropdown';
    $atts['data-target'] = '#';
  }
  return $atts;
}

//Extend walker
class WPSE_78121_Sublevel_Walker extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class='dropdown-menu' aria-labelledby='dropdown01'><ul>\n";
    }
    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div>\n";
    }
}

//Add Footer customization
add_action( 'customize_register', 'footerchild_register_theme_customizer' );

/*
 * Register Our Customizer Stuff Here
 */
function footerchild_register_theme_customizer( $wp_customize ) {
	//
	//
	// LANDING PAGE SECTION
	//
	//
	$wp_customize->add_panel( 'landing_page_blocks', array(
		'priority'       => 500,
		'theme_supports' => '',
		'title'          => __( 'Landing Page', 'landingchild' ),
		'description'    => __( 'Edit landing page content.', 'landingchild' ),
	) );
	//
	// Intro Section
	//
	$wp_customize->add_section( 'landing_page_intro_section' , array(
		'title'    => __('Intro Section','landingchild'),
		'panel'    => 'landing_page_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'landing_page_intro_section_1', array(
		 'default'           => __( 'Learn English or French through the world\'s most prestigious language school. Around the world in 40 years!', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_intro_section_1',
		    array(
		        'label'    => __( 'Header', 'landingchild' ),
		        'section'  => 'landing_page_intro_section',
		        'settings' => 'landing_page_intro_section_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_intro_section_2', array(
		 'default'           => __( 'Learn More', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Image_Control(
           $wp_customize,
           'landing_page_intro_section_2',
           array(
               'label'      => __( 'Upload a logo', 'landingchild' ),
               'section'    => 'landing_page_intro_section',
               'settings'   => 'landing_page_intro_section_2'
           )
       )
   	);
	//Add this background into CSS
	add_action( 'wp_head', 'mytheme_customize_css_intro');
	function mytheme_customize_css_intro()
	{
	    ?>
	         <style type="text/css">
	             .intro-column-content { 
	             	background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
	             	url('<?php echo get_theme_mod('landing_page_intro_section_2', ''); ?>'); 
	             	background-size: cover;
	             	background-position:center;
	             }
	         </style>
	    <?php
	}
	//
	// Statistics Section
	//
	$wp_customize->add_section( 'landing_page_statistics_section' , array(
		'title'    => __('Statistics Section','landingchild'),
		'panel'    => 'landing_page_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'landing_page_statistics_section_1', array(
		 'default'           => __( 'Countries', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_statistics_section_1',
		    array(
		        'label'    => __( 'Header 1', 'landingchild' ),
		        'section'  => 'landing_page_statistics_section',
		        'settings' => 'landing_page_statistics_section_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_statistics_section_1_1', array(
		 'default'           => __( '75+', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_statistics_section_1_1',
		    array(
		        'label'    => __( 'Big Stat 1', 'landingchild' ),
		        'section'  => 'landing_page_statistics_section',
		        'settings' => 'landing_page_statistics_section_1_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_statistics_section_1_2', array(
		 'default'           => __( '75+', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_statistics_section_1_2',
		    array(
		        'label'    => __( 'Big Info 1', 'landingchild' ),
		        'section'  => 'landing_page_statistics_section',
		        'settings' => 'landing_page_statistics_section_1_2',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_statistics_section_2', array(
		 'default'           => __( 'Years served', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_statistics_section_2',
		    array(
		        'label'    => __( 'Header 2', 'landingchild' ),
		        'section'  => 'landing_page_statistics_section',
		        'settings' => 'landing_page_statistics_section_2',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_statistics_section_2_1', array(
		 'default'           => __( '40+', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_statistics_section_2_1',
		    array(
		        'label'    => __( 'Big Stat 2', 'landingchild' ),
		        'section'  => 'landing_page_statistics_section',
		        'settings' => 'landing_page_statistics_section_2_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_statistics_section_2_2', array(
		 'default'           => __( '40+', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_statistics_section_2_2',
		    array(
		        'label'    => __( 'Big Info 2', 'landingchild' ),
		        'section'  => 'landing_page_statistics_section',
		        'settings' => 'landing_page_statistics_section_2_2',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_statistics_section_3', array(
		 'default'           => __( 'Average age', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_statistics_section_3',
		    array(
		        'label'    => __( 'Header 3', 'landingchild' ),
		        'section'  => 'landing_page_statistics_section',
		        'settings' => 'landing_page_statistics_section_3',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_statistics_section_3_1', array(
		 'default'           => __( '25', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_statistics_section_3_1',
		    array(
		        'label'    => __( 'Big Stat 3', 'landingchild' ),
		        'section'  => 'landing_page_statistics_section',
		        'settings' => 'landing_page_statistics_section_3_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_statistics_section_3_2', array(
		 'default'           => __( '25', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_statistics_section_3_2',
		    array(
		        'label'    => __( 'Big Info 3', 'landingchild' ),
		        'section'  => 'landing_page_statistics_section',
		        'settings' => 'landing_page_statistics_section_3_2',
		        'type'     => 'text'
		    )
	    )
	);
	//
	// Ottawa Section
	//
	$wp_customize->add_section( 'landing_page_ottawa_section' , array(
		'title'    => __('Ottawa Section','landingchild'),
		'panel'    => 'landing_page_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'landing_page_ottawa_section_1', array(
		 'default'           => __( 'Ottawa', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_ottawa_section_1',
		    array(
		        'label'    => __( 'Ottawa Section', 'landingchild' ),
		        'section'  => 'landing_page_ottawa_section',
		        'settings' => 'landing_page_ottawa_section_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_ottawa_section_2', array(
		 'default'           => __( 'Body Text', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_ottawa_section_2',
		    array(
		        'label'    => __( 'Body Text', 'landingchild' ),
		        'section'  => 'landing_page_ottawa_section',
		        'settings' => 'landing_page_ottawa_section_2',
		        'type'     => 'textarea'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_ottawa_section_3', array(
		 'default'           => __( '#', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_ottawa_section_3',
		    array(
		        'label'    => __( 'Button URL', 'landingchild' ),
		        'section'  => 'landing_page_ottawa_section',
		        'settings' => 'landing_page_ottawa_section_3',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_ottawa_section_4', array(
		 'default'           => __( 'Learn More', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_ottawa_section_4',
		    array(
		        'label'    => __( 'Button Text', 'landingchild' ),
		        'section'  => 'landing_page_ottawa_section',
		        'settings' => 'landing_page_ottawa_section_4',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_ottawa_section_5', array(
		 'default'           => __( 'Learn More', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Image_Control(
           $wp_customize,
           'landing_page_ottawa_section_5',
           array(
               'label'      => __( 'Upload a logo', 'landingchild' ),
               'section'    => 'landing_page_ottawa_section',
               'settings'   => 'landing_page_ottawa_section_5'
           )
       )
   	);
	//Add this background into CSS
	add_action( 'wp_head', 'mytheme_customize_css_ottawa');
	function mytheme_customize_css_ottawa()
	{
	    ?>
	         <style type="text/css">
	             .ottawa-row { 
	             	background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
	             	url('<?php echo get_theme_mod('landing_page_ottawa_section_5', ''); ?>'); 
	             	background-size: cover;
				    background-position: center;
	             }
	         </style>
	    <?php
	}
	//
	// Program Section
	//
	$wp_customize->add_section( 'landing_page_program_section' , array(
		'title'    => __('Program Section','landingchild'),
		'panel'    => 'landing_page_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'landing_page_program_section_1', array(
		 'default'           => __( 'Programs', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_program_section_1',
		    array(
		        'label'    => __( 'Header', 'landingchild' ),
		        'section'  => 'landing_page_program_section',
		        'settings' => 'landing_page_program_section_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_program_section_2', array(
		 'default'           => __( 'Learn More', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Image_Control(
           $wp_customize,
           'landing_page_program_section_2',
           array(
               'label'      => __( 'Upload a logo', 'landingchild' ),
               'section'    => 'landing_page_program_section',
               'settings'   => 'landing_page_program_section_2'
           )
       )
   	);
	//Add this background into CSS
	add_action( 'wp_head', 'mytheme_customize_css_program');
	function mytheme_customize_css_program()
	{
	    ?>
	         <style type="text/css">
	             .program-column-media { 
	             	background: url('<?php echo get_theme_mod('landing_page_program_section_2', ''); ?>'); 
	             	background-size: cover;
	             }
	         </style>
	    <?php
	}
	//
	// YouTube Section
	//
	$wp_customize->add_section( 'landing_page_youtube_section' , array(
		'title'    => __('YouTube Section','landingchild'),
		'panel'    => 'landing_page_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'landing_page_youtube_section_1', array(
		 'default'           => __( 'Watch Our Videos', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_youtube_section_1',
		    array(
		        'label'    => __( 'Header', 'landingchild' ),
		        'section'  => 'landing_page_youtube_section',
		        'settings' => 'landing_page_youtube_section_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_youtube_section_2', array(
		 'default'           => __( 'Check out our YouTube channel for our latest videos!', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_youtube_section_2',
		    array(
		        'label'    => __( 'Body Text', 'landingchild' ),
		        'section'  => 'landing_page_youtube_section',
		        'settings' => 'landing_page_youtube_section_2',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'landing_page_youtube_section_3', array(
		 'default'           => __( 'https://www.youtube.com/user/interlangues', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_youtube_section_3',
		    array(
		        'label'    => __( 'YouTube page URL', 'landingchild' ),
		        'section'  => 'landing_page_youtube_section',
		        'settings' => 'landing_page_youtube_section_3',
		        'type'     => 'text'
		    )
	    )
	);
	//
	// Testimonial Section
	//
	$wp_customize->add_section( 'landing_page_testimonial_section' , array(
		'title'    => __('Testimonial Section','landingchild'),
		'panel'    => 'landing_page_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'landing_page_testimonial_section_1', array(
		 'default'           => __( 'Testimonial', 'landingchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'landing_page_testimonial_section_1',
		    array(
		        'label'    => __( 'Testimonial Section', 'landingchild' ),
		        'section'  => 'landing_page_testimonial_section',
		        'settings' => 'landing_page_testimonial_section_1',
		        'type'     => 'text'
		    )
	    )
	);

	//
	//
	// FOOTER SECTION
	//
	//
	$wp_customize->add_panel( 'text_blocks', array(
		'priority'       => 500,
		'theme_supports' => '',
		'title'          => __( 'Footer Content', 'footerchild' ),
		'description'    => __( 'Edit footer content.', 'footerchild' ),
	) );
	//
	// Column Header Title Section
	//
	$wp_customize->add_section( 'custom_footer_text2' , array(
		'title'    => __('Column Header Titles','footerchild'),
		'panel'    => 'text_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'footer_column_header_1', array(
		 'default'           => __( 'Follow Us', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_column_header_text1',
		    array(
		        'label'    => __( 'Column Header Title 1', 'footerchild' ),
		        'section'  => 'custom_footer_text2',
		        'settings' => 'footer_column_header_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_column_header_1_1', array(
		 'default'           => __( 'Contact', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_column_header_text1_1',
		    array(
		        'label'    => __( 'Column Header Title 1-1', 'footerchild' ),
		        'section'  => 'custom_footer_text2',
		        'settings' => 'footer_column_header_1_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_column_header_2', array(
		 'default'           => __( 'About Interlangues', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_column_header_text2',
		    array(
		        'label'    => __( 'Column Header Title 2', 'footerchild' ),
		        'section'  => 'custom_footer_text2',
		        'settings' => 'footer_column_header_2',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_column_header_3', array(
		 'default'           => __( 'Programs', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_column_header_text3',
		    array(
		        'label'    => __( 'Column Header Title 3', 'footerchild' ),
		        'section'  => 'custom_footer_text2',
		        'settings' => 'footer_column_header_3',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_column_header_4', array(
		 'default'           => __( 'Student Help', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_column_header_text4',
		    array(
		        'label'    => __( 'Column Header Title 4', 'footerchild' ),
		        'section'  => 'custom_footer_text2',
		        'settings' => 'footer_column_header_4',
		        'type'     => 'text'
		    )
	    )
	);
	//
	// Social Media Section
	//
	// Add section.
	$wp_customize->add_section( 'custom_footer_text1' , array(
		'title'    => __('Social Icons Column','footerchild'),
		'panel'    => 'text_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'footer_social_1', array(
		 'default'           => __( 'https://www.facebook.com/Interlangues1976', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_text1',
		    array(
		        'label'    => __( 'Facebook URL', 'footerchild' ),
		        'section'  => 'custom_footer_text1',
		        'settings' => 'footer_social_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_social_2', array(
		 'default'           => __( 'https://www.instagram.com/interlangues76/', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_text2',
		    array(
		        'label'    => __( 'Instagram URL', 'footerchild' ),
		        'section'  => 'custom_footer_text1',
		        'settings' => 'footer_social_2',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_social_3', array(
		 'default'           => __( 'https://twitter.com/Interlangues76', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_text3',
		    array(
		        'label'    => __( 'Twitter URL', 'footerchild' ),
		        'section'  => 'custom_footer_text1',
		        'settings' => 'footer_social_3',
		        'type'     => 'text'
		    )
	    )
	);
	//
	// Contact Section
	//
	// Add section.
	$wp_customize->add_section( 'custom_footer_contact_text1' , array(
		'title'    => __('Contact Column Content','footerchild'),
		'panel'    => 'text_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'footer_contact_1', array(
		 'default'           => __( '130 Albert St., Suite 710', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_contact_text1',
		    array(
		        'label'    => __( 'Street', 'footerchild' ),
		        'section'  => 'custom_footer_contact_text1',
		        'settings' => 'footer_contact_1',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_contact_2', array(
		 'default'           => __( 'Ottawa, Ontario, Canada', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_contact_text2',
		    array(
		        'label'    => __( 'City, Province, Country', 'footerchild' ),
		        'section'  => 'custom_footer_contact_text1',
		        'settings' => 'footer_contact_2',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_contact_3', array(
		 'default'           => __( 'K1P 5G4', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_contact_text3',
		    array(
		        'label'    => __( 'Postal Code', 'footerchild' ),
		        'section'  => 'custom_footer_contact_text1',
		        'settings' => 'footer_contact_3',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_contact_4', array(
		 'default'           => __( '1.613.232.5000', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_contact_text4',
		    array(
		        'label'    => __( 'Phone Number', 'footerchild' ),
		        'section'  => 'custom_footer_contact_text1',
		        'settings' => 'footer_contact_4',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_contact_5', array(
		 'default'           => __( '(Monday to Friday, 8AM - 4:30PM E.S.T.)', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_contact_text5',
		    array(
		        'label'    => __( 'Business Hours', 'footerchild' ),
		        'section'  => 'custom_footer_contact_text1',
		        'settings' => 'footer_contact_5',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_contact_6', array(
		 'default'           => __( '1.613.290.9009', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_contact_text6',
		    array(
		        'label'    => __( 'SMS Number', 'footerchild' ),
		        'section'  => 'custom_footer_contact_text1',
		        'settings' => 'footer_contact_6',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_contact_7', array(
		 'default'           => __( '1.613.236.6063', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_contact_text7',
		    array(
		        'label'    => __( 'Fax Number', 'footerchild' ),
		        'section'  => 'custom_footer_contact_text1',
		        'settings' => 'footer_contact_7',
		        'type'     => 'text'
		    )
	    )
	);
	// Add setting
	$wp_customize->add_setting( 'footer_contact_8', array(
		 'default'           => __( 'info@interlangues.ca', 'footerchild' ),
		 'sanitize_callback' => 'sanitize_text'
	) );
	// Add control
	$wp_customize->add_control( new WP_Customize_Control(
	    $wp_customize,
		'custom_footer_contact_text8',
		    array(
		        'label'    => __( 'Contact Email', 'footerchild' ),
		        'section'  => 'custom_footer_contact_text1',
		        'settings' => 'footer_contact_8',
		        'type'     => 'text'
		    )
	    )
	);

 	// Sanitize text
	function sanitize_text( $text ) {
	    return sanitize_text_field( $text );
	}
}
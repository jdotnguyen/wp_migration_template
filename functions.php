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

add_action( 'customize_register', 'footerchild_register_theme_customizer' );

/*
 * Register Our Customizer Stuff Here
 */
function footerchild_register_theme_customizer( $wp_customize ) {
	//
	//
	// Social Media Section
	//
	//
	// Create custom panel.
	$wp_customize->add_panel( 'text_blocks', array(
		'priority'       => 500,
		'theme_supports' => '',
		'title'          => __( 'Footer Content', 'footerchild' ),
		'description'    => __( 'Edit footer content.', 'footerchild' ),
	) );
	// Add Footer Text
	// Add section.
	$wp_customize->add_section( 'custom_footer_text1' , array(
		'title'    => __('Social Icons Column','footerchild'),
		'panel'    => 'text_blocks',
		'priority' => 10
	) );
	// Add setting
	$wp_customize->add_setting( 'footer_social_1', array(
		 'default'           => __( 'http://www.interlangues.ca/', 'footerchild' ),
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
		 'default'           => __( 'http://www.interlangues.ca/', 'footerchild' ),
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
		 'default'           => __( 'http://www.interlangues.ca/', 'footerchild' ),
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
	//
	// Column Header Title Section
	//
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

 	// Sanitize text
	function sanitize_text( $text ) {
	    return sanitize_text_field( $text );
	}
}
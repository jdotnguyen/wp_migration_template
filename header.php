<?php
/**
 * The Header for our theme.
 */
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>

    <!-- Bootstrap core CSS -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:100,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <?php wp_head(); ?>
  </head>

  <body>
    <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
      <div class="container">  
        <a class="navbar-brand" href="/"><img class="header-logo" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <?wp_nav_menu( array( 'theme_location' => 'header-menu', 'container_class' => 'collapse navbar-collapse', 'container_id' => 'navbarsExampleDefault', 'menu_class' => 'navbar-nav ml-auto', 'walker' => new WPSE_78121_Sublevel_Walker ) ); ?>
          <!--<form class="form-inline my-2 my-lg-0">
            <a class="navbar-brand" href="#"><img class="header-logo" src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>"></a>
          </form>-->
      </div>
    </nav>
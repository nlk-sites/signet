<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Signet Armorlite
 * @subpackage signet
 * @since signet 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php

if ( function_exists('get_wpseo_options') ) {
	wp_title('');
} else {
  /*
   * Print the <title> tag based on what is being viewed.
   */
  global $page, $paged;

  wp_title( '|', true, 'right' );

  // Add the blog name.
  bloginfo( 'name' );

  // Add the blog description for the home/front page.
  $site_description = get_bloginfo( 'description', 'display' );
  if ( $site_description && ( is_home() || is_front_page() ) ) {
    echo " | $site_description";
  }

  // Add a page number if necessary:
  if ( $paged >= 2 || $page >= 2 ) {
    echo ' | ' . sprintf( __( 'Page %s', 'signet' ), max( $paged, $page ) );
  }
}
  ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php

  /* Always have wp_head() just before the closing </head>
   * tag of your theme, or you will break many plugins, which
   * generally use this hook to add elements to <head> such
   * as styles, scripts, and meta tags.
   */
  wp_head();
?>
<!--[if IE 9]>
  <style type="text/css">
    #special_submit { position:relative; top:0px; right:4px}
  </style>
<![endif]-->

<!--[if IE 8]>
  <style type="text/css">
    #special_submit { position:relative; top:7px; right:3px}
  </style>
<![endif]-->

<!--[if lte IE 7]>
  <style type="text/css">
    #special_submit { position:relative; top:-1px; right:3px}
    .menu-header .sub-menu li {clear:both}
    .top_img_txt h1 {height:auto; position:relative; top:190px}
    .top_img_txt_ecps h1 {height:auto; position:relative; top:100px}
    .top_img_txt_lab h1 {height:auto; position:relative; top:55px}
    #main_content{padding-bottom:25px}
    .ecps_title{ line-height:35px}
    .labtech_title{ line-height:35px}
  </style>
<![endif]-->
</head>
<body <?php body_class(); ?>>
  <div id="wrapper" class="hfeed">
    <div id="header">
      <div id="masthead">
        <a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" id="logo"><?php bloginfo( 'name' ); ?></a>
        <div id="tagline"><?php bloginfo( 'description' ); ?></div>
        <div class="top_right">
		  <?php signet_social(); ?>
          <div id="country">
            <?php dynamic_sidebar( 'lang-widget-area' ); ?>
          </div>
          <form action="<?php bloginfo('url'); ?>" id="searchform" method="get" role="search">
            <input class="special_search" type="text" id="s" name="s" value="">
            <input id="special_submit" type="submit" value="">
          </form>
        </div>
        <div id="access" role="navigation">
          <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
          <div class="skip-link screen-reader-text">
            <a href="#content" title="<?php esc_attr_e( 'Skip to content', 'signet' ); ?>"><?php _e( 'Skip to content', 'signet' ); ?></a>
          </div>
          <?php 
          /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  
           * The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
          <?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
          <div style="clear:both;"></div>
        </div><!-- #access -->
        <div style="clear:both;"></div>
      </div><!-- #masthead -->
      <div style="clear:both;"></div>
    </div><!-- #header -->
    <div id="main">

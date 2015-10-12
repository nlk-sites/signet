<?php
/**
 *
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Signet Armorlite
 * @subpackage signet
 * @since signet 1.0
 */

get_header();
?>
<div id="container">
  <div class="top_box_ecps">
    <div class="top_img_ecps">
      <img width="960" height="286" title="featured_img11" alt="featured_img11" class="attachment-960x286 wp-post-image" src="<?php bloginfo('template_directory') ?>/images/featured_img11.jpg">
    </div>
  </div>
  <div class="page_sidebar">
    <?php dynamic_sidebar( 'page-widget-area' ); ?>
  </div>
  <div id="main_content" role="main">
    <div class="ecps_title">Page not found</div>
    <p>We are sorry but the page you requested does not exist. Please use the navigation menu above.</p>
  </div><!-- #content -->
</div><!-- #container -->
<?php get_footer(); ?>

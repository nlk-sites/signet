<?php
/**
 * Template Name: International Subpage
 *
 * The template for displaying Labtech pros page.
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
  <div class="top_box_labtech">
    <div class="top_img_txt_lab">
      <h1 style="color:#CCC"><?php echo get_post_meta(get_the_ID(), 'Image-text', true); ?></h1>
    </div>
    <img src="<?php bloginfo('template_directory') ?>/images/labtech_back.jpg" />
  </div>
  <div id="labtech" class="page_sidebar resources_bar">
    <?php dynamic_sidebar( 'resources-widget-area' ); ?>
  </div>
  <div id="main_content" role="main">
    <div id="main_content_sub">
      <div class="labtech_title">
        International
      </div>
      <?php if ( have_posts() ):  while ( have_posts() ) : the_post();?>
        <h3><?php the_title() ?></h3>
        <?php the_content() ?>
        <p><a style="text-decoration:underline" href="?page_id=40">Back to International Page</a></p>
      <?php endwhile; endif; ?>
    </div>
    <div class="clear"></div>
  </div><!-- #content -->
</div><!-- #container -->
<?php get_footer(); ?>

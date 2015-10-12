<?php
/**
 * Template Name: Labtech Pros Subage
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
$page_id = 0;
?>
<div id="container">

  <div class="top_box_labtech">
    <div class="top_img_txt_lab">
      <h1 style="color:#CCC"><?php echo get_post_meta(get_the_ID(), 'Image-text', true); ?></h1>
    </div>
    <img src="<?php bloginfo('template_directory') ?>/images/labtech_back.jpg" />
  </div>
  <div id="labtech" class="page_sidebar resources_bar">
    <?php dynamic_sidebar( 'labtech-widget-area' ); ?>
  </div>

  <div id="main_content" role="main">
    <?php if ( have_posts() ): while ( have_posts() ) : the_post(); $page_id = get_the_ID();?>
      <div id="main_content_sub">
        <div class="labtech_title"><?php the_title() ?></div>
        <?php the_content(); ?>
      </div>
    <?php endwhile; endif; ?>
    <div class="clear"></div>
  </div><!-- #content -->

</div><!-- #container -->
<?php get_footer(); ?>

<?php
/**
 *
 * Template Name: Advisory Member
 *
 * The template for displaying advisory members.
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
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div id="generic" class="page_sidebar resources_bar">
      <?php dynamic_sidebar( 'ecps-widget-area' ); ?>
      <div class="back_link">
        <?php $permalink = get_permalink($post->post_parent); ?>
        <a href="<?php echo $permalink; ?>"><?php esc_attr_e('Back to Advisory Board List','signet') ?></a>
      </div>
    </div>
    <div id="main_content" role="main">
      <div id="main_content_sub">
        <div class="ecps_title"><?php the_title() ?></div>
        <?php the_content(); ?>
      </div>
    </div><!-- #content -->
  <?php endwhile; endif; ?>
</div><!-- #container -->
<?php get_footer(); ?>

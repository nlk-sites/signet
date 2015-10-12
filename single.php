<?php
/**
 * The single post.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Signet Armorlite
 * @subpackage signet
 * @since signet 1.0
 */

get_header();
global $wp_query;
$category = get_the_category( $wp_query->post->ID );
$category_name = end($category)->cat_name;
?>
<!-- singel -->
<div id="container">

  <div class="top_box_labtech">
    <div class="top_img_txt_lab"><h1 style="color:#CCC"><?php echo $category_name; ?></h1></div>
    <img src="<?php bloginfo('template_directory') ?>/images/labtech_back.jpg" />
  </div>

  <div id="labtech" class="page_sidebar">
    <?php dynamic_sidebar( 'blog-widget-area' ); ?>
  </div>

  <div id="main_content" role="main">
    <div id="main_content_sub">
      <div class="labtech_title">
        <?php echo $category_name; ?>
      </div>
      <?php if ( have_posts() ) :  while ( have_posts() ) : the_post();?>
        <h3><?php the_title() ?></h3>
        <?php the_content() ?>
      <?php endwhile; endif; ?>
    </div>
    <div class="clear"></div>
  </div><!-- #content -->

</div><!-- #container -->
<?php get_footer(); ?>

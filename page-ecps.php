<?php
/**
 *
 * Template Name: ECPS Page
 *
 * The template for displaying ECPS pages.
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
<!-- page-ecps -->
<div id="container">

  <?php if ( have_posts() ): ?>

    <?php while ( have_posts() ) : the_post(); $page_id = get_the_ID();?>

      <div class="top_box_ecps">
        <div class="top_img_ecps">
          <div class="top_img_txt_ecps"><h1><?php echo get_post_meta(get_the_ID(), 'Image-text', true); ?></h1></div>
          <?php if(has_post_thumbnail()) : ?>
            <?php the_post_thumbnail(array(960,286)); ?>
          <?php else : ?>
            <img width="960" height="286" alt="default_featured_image" class="attachment-960x286 wp-post-image" src="<?php bloginfo('template_directory'); ?>/images/default_featured_img_1.jpg" />
          <?php endif; ?>
        </div>
      </div>

      <div id="generic" class="page_sidebar resources_bar">
        <?php dynamic_sidebar( 'ecps-widget-area' ); ?>
      </div>

      <div id="main_content" role="main">
        <div id="main_content_sub">
          <div class="fix">
            <?php the_content(); ?>
          </div>

          <?php 
          $pages = get_pages( array( 'parent' => $page_id, 'child_of' => $page_id, 'sort_column' => 'menu_order', 'sort_order' => 'asc' ) );
          foreach( $pages as $page ) :
            ?>
            <div class="entry_box">
              <div class="entry_box_content">
                <?php  echo $page->post_excerpt; ?>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="clear"></div>
        </div>
      </div><!-- #content -->

    <?php endwhile; ?>
  <?php endif; ?>

</div><!-- #container -->
<?php get_footer(); ?>

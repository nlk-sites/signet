<?php
require_once ('dompdf/dompdf_config.inc.php');
ob_start();
?>
<?php
/*
Template Name: PDF
 */
get_header();
?>
<div id="container">

  <?php if ( have_posts() ): while ( have_posts() ) : the_post();?>

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
      <?php dynamic_sidebar( 'page-widget-area' ); ?>
    </div>

    <div id="main_content" role="main">
      <div id="main_content_sub">
        <div class="ecps_title">TEST: <?php the_title() ?></div>

        <?php the_content(); ?>
      </div>
    </div><!-- #content -->

  <?php endwhile; endif; ?>

</div><!-- #container -->

<?php get_footer(); ?>

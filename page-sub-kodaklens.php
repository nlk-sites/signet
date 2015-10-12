<?php
/**
 *
 * Template Name: Kodak Lens Subpage
 *
 * The template for displaying Kodak Lens subpages.
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
  <?php if ( have_posts() ): while ( have_posts() ) : the_post();?>
    <div class="top_box">
      <div class="sidemenu">
        <span><strong>Kodak</strong> <span>Lens</span></span>
        <?php wp_nav_menu( array( 'container' => '', 'theme_location' => 'kodak', 'menu_class' => 'sidenav' ) ); ?>
      </div>
      <div class="top_img">
        <div class="gradient_img_box"><img src="<?php bloginfo('template_directory') ?>/images/gradient_img_box.png" /></div>
        <div class="top_img_txt"><h1><?php echo get_post_meta(get_the_ID(), 'Image-text', true); ?></h1></div>
        <?php if(has_post_thumbnail()) : ?>
          <?php the_post_thumbnail(array(650,366)); ?>
        <?php else : ?>
          <img width="650" height="366" alt="default_featured_image" class="attachment-650x366 wp-post-image" src="<?php bloginfo('template_directory'); ?>/images/default_featured_img_2.png" />
        <?php endif; ?>
      </div>
    </div>

    <div class="page_sidebar">
      <div class="widget-container">
        <div id="widget-title"><?php esc_attr_e('Resources','signet') ?></div>
        <div class="widget_content">
          <?php 
          if(get_post_meta(get_the_ID(), 'Resources', false)) :
            $resources = get_post_meta(get_the_ID(), 'Resources', false);
            foreach($resources as $resource) :
              $attributes = explode('|',$resource);
              if($attributes[0] == 'video') : 
                ?>
                <div class="resource_entry">
                  <a class="fancybox iframe" href="http://www.youtube.com/embed/<?php echo $attributes[2]; ?>">
                    <img src="<?php bloginfo('template_directory') ?>/images/video.png" />
                    <span><?php echo $attributes[1]; ?></span>
                  </a><br />
                </div>
              <?php 
              elseif($attributes[0] == 'pdf'): 
              ?>
                <div class="resource_entry">
                  <a target="_blank" href="<?php echo $attributes[2]; ?>">
                    <img src="<?php bloginfo('template_directory') ?>/images/pdf.png" />
                    <span><?php echo $attributes[1]; ?></span>
                  </a><br />
                </div>
              <?php 
              endif; 
            endforeach; 
          else:
            esc_attr_e('There are no resources','signet');
          endif; 
          ?>
        </div>
      </div>
    </div><!-- end page_sidebar -->
    <div id="main_content" role="main">
      <div id="main_content_sub">
        <?php the_content(); ?>
      </div>
    </div><!-- #content -->
  <?php endwhile; endif; ?>
</div><!-- #container -->
<?php get_footer(); ?>

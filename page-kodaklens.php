<?php
/**
 * Template Name: Kodak Lens Page 
 *
 * The template for displaying kodak lens page.
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
<!-- page-kodaklens -->
<div id="container">
        
  <?php if ( have_posts() ) while ( have_posts() ) : the_post(); $page_id = get_the_ID(); ?>
    <div class="top_box">
      <div class="sidemenu">
        <span><strong>Kodak</strong> <span>Lens</span></span>
        <?php wp_nav_menu( array( 'container' => '', 'theme_location' => 'kodak', 'menu_class' => 'sidenav' ) ); ?>
      </div><!-- .sidemenu -->
      <div class="top_img">
        <div class="gradient_img_box">
          <img src="<?php bloginfo('template_directory') ?>/images/gradient_img_box.png" />
        </div>
        <div class="top_img_txt">
          <h1>
            <?php echo get_post_meta(get_the_ID(), 'Image-text', true); ?>
          </h1>
        </div>
        <?php if(has_post_thumbnail()) : ?>
          <?php the_post_thumbnail(array(650,366)); ?>
        <?php else : ?>
          <img width="650" height="366" alt="default_featured_image" class="attachment-650x366 wp-post-image" src="<?php bloginfo('template_directory'); ?>/images/default_featured_img_2.png" />
				<?php endif; ?>
      </div><!-- .gradient_img_box -->
    </div><!-- .top_box -->
            
  <?php endwhile; ?>
  
  <div id="labtech" class="page_sidebar"></div>
  
  <div id="main_content" role="main">
    <div id="main_content_sub" class="kodaklens">
      <?php $pages = get_pages( array( 'child_of' => $page_id, 'sort_column' => 'menu_order', 'sort_order' => 'asc' ) );
			foreach( $pages as $page ) :
			?>
        <div class="entry_box">
          <div class="entry_box_content">
            <?php  echo $page->post_excerpt; ?>
          </div>
        </div>
      <?php endforeach; ?>
                
      <div class="clear"></div>
    </div><!-- #main_content_sub -->
  </div><!-- #main_content -->

</div><!-- #container -->
<?php get_footer(); ?>

<?php
/**
 * The main template file.
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
$page_id = 0;
?>
<!-- index -->
<div id="container">

  <div class="top_box_labtech">
    <div class="top_img_txt_lab">
      <h1 style="color:#CCC">
        <?php if(is_search()) : ?>
          Search results
        <?php elseif(is_archive()) : ?>
          <?php echo single_cat_title(); ?>
        <?php endif; ?>
      </h1>
    </div>
    <img src="<?php bloginfo('template_directory') ?>/images/labtech_back.jpg" />
  </div>

  <div id="labtech" class="page_sidebar">
    <?php dynamic_sidebar( 'blog-widget-area' ); ?>
  </div>

  <div id="main_content" role="main">
    <div id="main_content_sub">
      <div class="labtech_title">
        <?php if(is_search()) : ?>
          Search results
        <?php elseif(is_archive()) : ?>
          <?php echo single_cat_title(); ?>
        <?php endif; ?>
      </div>

      <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post();?>
          <h3><?php the_title(); ?></h3>
          <?php
          $content = strip_tags(get_the_content());
          if(strlen($content) > 400) {
            $content = substr($content,0,400).'...';
          }
          ?>
          <p><?php echo $content; ?></p>
          <span class="read_more"><a style="color:#FFB700" class="read_more" href="<?php the_permalink() ?>">READ MORE</a></span>
          <hr />
        <?php endwhile; ?>
        <div class="posts_nav">
          <?php posts_nav_link( '', '<span class="previous">&laquo; PREVIOUS</span>', '<span class="next">NEXT &raquo;</span>' ); ?>
        </div>

      <?php else : ?>

        <h3>No results found</h3>
        <p>No results found. Please, use the navigation menu above...</p>

      <?php endif; ?>

      <div class="clear"></div>
    </div><!-- end main_content_sub -->
  </div><!-- #content -->

</div><!-- #container -->
<?php get_footer(); ?>

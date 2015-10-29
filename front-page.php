<?php
/**
 * Home Page
 *
 * @package Signet Armorlite
 * @subpackage signet
 * @since signet 1.0
 */

get_header(); 
?>
<div id="home">
  <?php 
  if ( have_posts() ): 
    while ( have_posts() ) : the_post();
      $args = array(
        'order'          => 'ASC',
        'orderby'        => 'menu_order',
        'post_type'      => 'attachment',
        'post_parent'    => $post->ID,
        'post_mime_type' => 'image',
        'post_status'    => null,
        'numberposts'    => -1,
      );
      $attachments = get_posts($args);
      if ($attachments) {
        $hdots = '<div id="hdots"><div class="l"></div>';
        foreach ( $attachments as $k => $a ) {
          echo '<div class="slide"><img src="'. $a->guid .'" alt="'. $a->post_title .'" /></div>';
          $hdots .= '<a href="#"'.  ($k==0 ? ' class="first"' : '') .'>'. $k .'</a>';
        }
        $hdots .= '<div class="r"></div></div>';
        
        if ( count( $attachments ) > 1 ) {
          echo $hdots;
        }
      }
    endwhile; 
  endif; 
  ?>
</div>
<script type="text/javascript">hflashloc = '<?php bloginfo('template_url'); ?>/intro.swf';</script>
<?php get_footer(); ?>

<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package Signet Armorlite
 * @subpackage signet
 * @since signet 1.0
 */
?>
    </div><!-- #main -->

    <div id="footer" role="contentinfo">
      <?php if ( is_front_page() ) { ?>
        <div class="fblocks">

          <div class="fblock k">
            <div class="in">
              <h3 class="ftitle"><span>Kodak </span>Lens</h3>
              <?php
              $lenspages = explode('<li', wp_list_pages( 'title_li=&child_of=7&echo=0&exclude=20,3465' ) );
              @array_shift($lenspages);
              $lensmenus = '<ul><li'. implode( '<li', array_slice($lenspages,0,5) ) .'</ul><ul><li'. implode( '<li', array_slice($lenspages,5) ) .'</ul>';
              echo str_replace( '>Kodak', '><strong>Kodak</strong>', $lensmenus );
              ?>
              <!--<a href="<?php echo get_permalink(20); ?>" class="morep">more&nbsp;+</a>-->
            </div>
          </div>

          <div class="fblock a">
            <div class="fslide on">
              <a href="<?php echo get_permalink(42); ?>"><img src="<?php bloginfo('template_url'); ?>/images/footer-lens.jpg" alt="Explore Kodak Lens : Quality &amp; Innovation" width="310" height="166" /></a>
            </div>
            <div class="fslide">
              <a href="<?php echo get_permalink(26); ?>"><img src="<?php bloginfo('template_url'); ?>/images/footer-ECPS.jpg" alt="Eyecare Professionals : Resources &amp; Downloads" width="310" height="166" /></a>
            </div>
            <div id="fdots"><a href="#" class="on"></a><a href="#"></a></div>
          </div>

          <div class="fblock n">
            <div class="in">
              <h3 class="ftitle">Signet Armorlite News</h3>
              <?php
              $latestposts = get_posts(array(
                'numberposts' => 1,
                'category' => 14
              ));
              global $post;
              $oldpost = $post;
              $post = $latestposts[0];
              ?>
              <p>
                <?php the_date('m-d-Y'); ?><br />
                <a href="<?php echo get_permalink(); ?>"><strong><?php echo $post->post_title ?></strong></a><br />
                <?php
                $c = wp_kses( $post->post_content, array() );
                if ( strlen($c) > 88 ) {
                  $c = substr($c, 0, strrpos( substr( $c, 0, 88 ), ' ' ) ). '...';
                }
                echo $c;
                ?><br />
                <a href="category/news/" class="mn">More News</a>
              </p>
            </div>
          </div>

        </div><!-- end fblocks -->
      <?php } ?>

      <div id="colophon">
        <div class="sitemap open">
          <a href="#" class="collapse">Sitemap and <strong>Kodak</strong> Lens Family of Products</a>
          <form method="post" action="http://visitor.constantcontact.com/manage/optin/ea?v=001GEtTiJRQgs3gE-yZa6DjevUXJ7wcz_rHb7HiLJQJ40W7os2HK-4lddu10y_2g210_bDN8WuTugR2_m2alJ-vB497FcRk2NI0" id="command">
            <input type="hidden" value="<?php bloginfo('url'); ?>" name="ref" />
            <h3>Newsletter</h3>
            <input type="text" maxlength="80" value="enter email" class="email-input" name="emailAddr" id="emailAddr" onfocus="if(jQuery(this).val()=='enter email') jQuery(this).val('');" onblur="if(jQuery(this).val()=='') jQuery(this).val('enter email');" />
            <input type="image" value="submit" class="btn-primary" name="_save" src="<?php bloginfo('template_url'); ?>/images/fsignup.png" />
          </form>
          <div class="inside">
            <div class="mblock k">
              <h4 class="mtitle"><img src="<?php bloginfo('template_url'); ?>/images/ftr-kodak.gif" alt="Kodak" /> LENS</h4>
              <?php wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'kodak' ) ); ?>
            </div>
            <div class="mblock">
              <h4 class="mtitle"><img src="<?php bloginfo('template_url'); ?>/images/ftr-sa.gif" alt="SA" /> Eyecare PROFESSIONALS</h4>
              <?php wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'eyecare' ) ); ?>
            </div>
            <div class="mblock">
              <h4 class="mtitle"><img src="<?php bloginfo('template_url'); ?>/images/ftr-sa.gif" alt="SA" /> LabTech PROS</h4>
              <?php wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'labtech' ) ); ?>
            </div>
            <div class="mblock">
              <h4 class="mtitle">RESOURCES</h4>
              <?php wp_nav_menu( array( 'container_class' => 'menu', 'theme_location' => 'resources' ) ); ?>
            </div>
          </div><!-- inside -->
        </div><!-- sitemap -->

        <div id="site-info">
          Signet Armorlite, Inc: 800.759.4630 &nbsp; &nbsp;<span class="light">&copy; 2013 Signet Armorlite, Inc.</span><br /><br />
          <img src="<?php bloginfo('template_url'); ?>/images/kodaklicense.gif" alt="Kodak Licensed Product" />Kodak trademark and trade dress are<br />
          used under license from Kodak by Signet Armorlite.
        </div><!-- #site-info -->
        <div id="site-generator">
          <?php 
		  do_action( 'signet_credits' );
		  wp_nav_menu( array( 'container_class' => 'menu footer_menu', 'theme_location' => 'footer', 'after' => '<span style="padding-left:10px"> | </span>' ) );
		  signet_social();
		  ?>
        </div><!-- #site-generator -->
        <div style="clear:both;"></div>

      </div><!-- #colophon -->
      <div style="clear:both;"></div>

    </div><!-- #footer -->
    <div style="clear:both;"></div>

  </div><!-- #wrapper -->

  <script type="text/javascript">
  jQuery(document).ready( function(){
    jQuery("#menu-footer li:first span").css('visibility','hidden');
  });
  </script>

  <!--[if lt IE 7]>
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dd_belatedpng.js"></script>
    <script type="text/javascript">
      DD_belatedPNG.fix('img, .png_bg');
    </script>
  <![endif]-->

  <?php wp_footer(); ?>
</body>
</html>

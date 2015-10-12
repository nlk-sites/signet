<?php
/**
 *
 * Template Name: Template With Upload Field 
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
?>
 <script type="text/javascript" src="http://github.com/malsup/media/raw/master/jquery.media.js?v0.92"></script>
<script type="text/javascript" src="http://malsup.github.com/chili-1.7.pack.js"></script>
<script type="text/javascript" src="http://malsup.github.com/jquery.media.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/meta-data.js"></script>
<script type="text/javascript">
    $(function() {
        $('a.media').media({width:500, height:400});
    });
</script>
<!-- page-sub-ecps -->
<div id="container">
        
  <?php if ( have_posts() ) while ( have_posts() ) : the_post();?>
    <div class="top_box_ecps">
      <div class="top_img_ecps">
        <div class="top_img_txt_ecps">
          <h1>
            <?php echo get_post_meta(get_the_ID(), 'Image-text', true); ?>
          </h1>
        </div><!-- .top_img_txt_ecps -->
        <?php if(has_post_thumbnail()) : ?>
          <?php the_post_thumbnail(array(960,286)); ?>
        <?php else : ?>
          <img width="960" height="286" alt="default_featured_image" class="attachment-960x286 wp-post-image" src="<?php bloginfo('template_directory'); ?>/images/ecps_header1.jpg" />
        <?php endif; ?>
      </div><!-- .top_img_ecps -->
    </div><!-- .top_box_ecps -->
            
    <div id="generic" class="page_sidebar resources_bar">
      <?php dynamic_sidebar( 'ecps-widget-area' ); ?>
    </div><!-- #generic -->
            
    <div id="main_content" role="main">
      <div id="main_content_sub">
        <div class="ecps_title">
          <?php the_title(); ?>
        </div><!-- .ecps_title -->
        	<?php the_content(); ?>  
            <?php the_field('please_note'); ?>        
        <?php global $wp_query;
			if (isset($wp_query->query_vars['myvar']) || ($wp_query->query_vars['myvar2']))
		{?>
        <?php if (isset($wp_query->query_vars['myvar'])) $somevar = esc_attr($wp_query->query_vars['myvar']); ?>
        <?php echo $somevar;?>
		<?php if ($wp_query->query_vars['myvar']) :?>
        	<strong>option1a</strong>
        <?php endif ;?>
        <?php if ($wp_query->query_vars['myvar']) :?>
        	<strong>option2b</strong>
        <?php  endif; ?>

        <a class="media" href="<?php bloginfo('template_url'); ?>/pdf/test.pdf">PDF File</a>
    <a id="mike" class="media {type: 'html'}" href="<?php bloginfo('template_url'); ?>/">HTML File</a>
<form method="POST" enctype="multipart/form-data" action="index.asp?page_id=147&amp;AdType=1">
    <table>
    
    <tbody><tr><td><p>Select Logo:</p></td><td> <input type="file" name="txtFile"></td></tr>
    <tr><td><br></td><td> </td></tr>
      
    <tr><td><p>Doctor's Name:</p></td><td> <input type="text" maxlength="30" name="DocName"></td></tr>  
    <tr><td><p>Company Name:</p></td><td> <input type="text" maxlength="30" name="BusName"></td></tr>
    <tr><td><p>Address Line 1:</p></td><td> <input type="text" maxlength="30" name="Address1"></td></tr>
    <tr><td><p>Address Line 2:</p></td><td> <input type="text" maxlength="30" name="Address2"></td></tr>
    <tr><td><p>Phone:</p></td><td>(<input type="text" maxlength="3" size="2" name="Area">)<input type="text" maxlength="3" size="2" name="Prefix">-<input type="text" maxlength="4" size="3" name="Number"> ext.<input type="text" maxlength="5" size="4" name="Ext"></td></tr>
    <tr><td><p>Offer Text:</p></td><td><textarea rows="4" cols="15" name="CouponText"></textarea></td></tr>
    <tr><td><p>Offer Expiration:</p></td><td><p><input type="text" maxlength="2" size="2" name="ExpireMonth">/<input type="text" maxlength="2" size="2" name="ExpireDay">/<input type="text" maxlength="2" size="2" name="ExpireYear"></p></td></tr>  
    <tr><td></td><td><p>(mm/dd/yy)</p></td></tr>
    <tr><td colspan="2"><input type="submit" selected="" value="Continue" name="cmdSubmit"></td></tr>
    </tbody></table>
    <input type="hidden" value="1" name="AdType">
    </form>
<?php }?>
<?php //print $wp_query->query_vars['myvar2'];?>
<!--<br />
<a href="http://ninthlink.net/signetarmorlite/site/eye-care-professionals/marketing-tools/test/?myvar=option1">Option 1</a>
<a href="http://ninthlink.net/signetarmorlite/site/eye-care-professionals/marketing-tools/test/?myvar=option2">Option 2</a>-->
      </div><!-- .main_content_sub -->
    </div><!-- #main_content -->

  <?php endwhile; ?>
            
</div><!-- #container -->
<?php get_footer(); ?>

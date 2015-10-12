<?php //require_once ('dompdf/dompdf_config.inc.php'); ?>
<?php get_header();?>
  <script type="text/javascript">
    function showHide() {
            document.getElementById("hidden_div").style.display = "block";
    }
</script>
<div id="container">
        

    <div class="top_box_ecps">
      <div class="top_img_ecps">
        <div class="top_img_txt_ecps">
          <h1>
            <?php echo get_post_meta(get_the_ID(), 'Image-text', true); ?>
          </h1>
        </div><!-- .top_img_txt_ecps -->
        <?php /*if(has_post_thumbnail()) : ?>
          <?php the_post_thumbnail(array(960,286)); ?>
        <?php else :*/ ?>
          <img width="960" height="286" alt="default_featured_image" class="attachment-960x286 wp-post-image" src="<?php bloginfo('template_directory'); ?>/images/default_featured_img_1.jpg" />
        <?php //endif; ?>
      </div><!-- .top_img_ecps -->
    </div><!-- .top_box_ecps -->
            
    <div id="generic" class="page_sidebar resources_bar">
      <?php dynamic_sidebar( 'ecps-widget-area' ); ?>
    </div><!-- #generic -->
            
    <div id="main_content" role="main">
      <div id="main_content_sub" class="escps_content">
        <div class="ecps_title">
          <?php the_title() ?>

        </div><!-- .ecps_title -->
	<?php 
    /*$terms = get_the_terms( $post->ID , 'product_category' );
    foreach ( $terms as $term ) {
    	$term_link = get_term_link( $term, 'product_category' );
    	echo "<a href='".$term_link."'>" . $term->name . "</a>";
    } */
    ?>
  <?php if( has_term('countertop-option-1', 'product_category')) { ?>
  	<?php dynamic_sidebar( 'countertop-info' ); ?>
    
    <form id="myform" method="POST" enctype="multipart/form-data" action="<?php echo get_template_directory_uri(); ?>/dompdf/www/form_countertop_option1.php" target="preview">
        <input type="hidden" value="<?php echo get_the_ID(); ?>" maxlength="30" name="custId">
    <table>
    
    <tbody>
    <tr><td><p>Select Logo:</p></td><td> <input type="file" name="txtFile" id="txtFile"></td></tr>
    <tr><td><br></td><td> </td></tr>
    <tr><td><p>Company Name:</p></td><td> <input type="text" maxlength="30" name="BusName"></td></tr>
    <tr><td colspan="2"><input type="submit" selected="" value="Continue" name="cmdSubmit"  onclick="showHide()"></td></tr>
    </tbody></table>
    <input type="hidden" value="1" name="AdType">
    
    </form>
     <br />
   	<div class="echo" id="hidden_div" style="display:none; border:1px solid #F00; padding:7px;">
    	<?php dynamic_sidebar( 'preview-instructions' ); ?>
    </div>
  <?php } elseif( has_term('countertop-option-2', 'product_category')){?>
  <?php dynamic_sidebar( 'countertop-info2' ); ?>
  <form id="myform" method="POST" enctype="multipart/form-data" action="<?php echo get_template_directory_uri(); ?>/dompdf/www/form_countertop_option2.php" target="preview">
        <input type="hidden" value="<?php echo get_the_ID(); ?>" maxlength="30" name="custId">
    <table>
<tbody><tr><td><p>Offer Title:</p></td><td><select name="CouponTitle">
<option>LIMITED TIME OFFER</option>
<option>SPECIAL OFFER</option>
<option>HOLIDAY PROMOTION</option>
<option>BACK TO SCHOOL SPECIAL</option>
</select></td></tr>   
<tr><td><p>Offer Text:</p></td><td><textarea rows="8" cols="30" name="CouponText"></textarea></td></tr>
<tr><td><p>Offer Expiration:</p></td><td><p><input type="text" maxlength="2" size="2" name="ExpireMonth">/<input type="text" maxlength="2" size="2" name="ExpireDay">/<input type="text" maxlength="2" size="2" name="ExpireYear"></p></td></tr>

<tr><td><br></td><td> </td></tr>
<tr><td colspan="2"><input type="submit" selected="" value="Continue" name="cmdSubmit"></td></tr>
</tbody>
</table>
    <input type="hidden" value="1" name="AdType">
    
    </form>
  <?php } elseif( has_term('postcard-option1', 'product_category')){?>
  <?php dynamic_sidebar( 'recall-info-above' ); ?>
  <form id="myform" method="POST" enctype="multipart/form-data" action="<?php echo get_template_directory_uri(); ?>/dompdf/www/form_postcard_option1.php" target="preview">
        <input type="hidden" value="<?php echo get_the_ID(); ?>" maxlength="30" name="custId">
<table>
    
    <tbody><tr><td><p>Select Logo:</p></td><td> <input type="file" name="txtFile"></td></tr>
    <tr><td><br></td><td> </td></tr>
    
    <tr><td><p>Business Name:</p></td><td> <input type="text" name="BusName"></td></tr>
    <tr><td><p>Address Line 1:</p></td><td> <input type="text" name="Address1"></td></tr>
    <tr><td><p>Address Line 2:</p></td><td> <input type="text" name="Address2"></td></tr>
    <tr><td><p>Phone:</p></td><td>(<input type="text" maxlength="3" size="2" name="Area">)<input type="text" maxlength="3" size="2" name="Prefix">-<input type="text" maxlength="4" size="3" name="Number"> ext.<input type="text" maxlength="5" size="4" name="Ext"></td></tr>
    
    <tr><td><p>Card Type:</p></td><td><p><input type="radio" value="call" name="CardType">Call For Appt <input type="radio" value="dated" name="CardType">Dated Appt </p></td></tr>
    
    <tr><td colspan="2"><input type="submit" selected="" value="Continue" name="cmdSubmit" onclick="showHide()"></td></tr>
    </tbody></table>
    <input type="hidden" value="1" name="AdType">
    
    </form>
<?php dynamic_sidebar( 'recall-info-below' ); ?>
 <br />
   	<div class="echo" id="hidden_div" style="display:none; border:1px solid #F00; padding:7px;">
    	<?php dynamic_sidebar( 'preview-instructions' ); ?>
    </div>
  <?php }  elseif( has_term('power-of-3-option', 'product_category')){?>
  <?php dynamic_sidebar( 'recall-info-above' ); ?>
  <form id="myform" method="POST" enctype="multipart/form-data" action="<?php echo get_template_directory_uri(); ?>/dompdf/www/form_power_of_3.php" target="preview">
        <input type="hidden" value="<?php echo get_the_ID(); ?>" maxlength="30" name="custId">
<table>
    
    <tbody><tr><td><p>Select Logo:</p></td><td> <input type="file" name="txtFile"></td></tr>
    <tr><td><br></td><td> </td></tr>
    
    <tr><td><p>Business Name:</p></td><td> <input type="text" name="BusName"></td></tr>
    <tr><td><p>Address Line 1:</p></td><td> <input type="text" name="Address1"></td></tr>
    <tr><td><p>Address Line 2:</p></td><td> <input type="text" name="Address2"></td></tr>
    <tr><td><p>Phone:</p></td><td>(<input type="text" maxlength="3" size="2" name="Area">)<input type="text" maxlength="3" size="2" name="Prefix">-<input type="text" maxlength="4" size="3" name="Number"> ext.<input type="text" maxlength="5" size="4" name="Ext"></td></tr>
    
    <tr><td><p>Website:</p></td><td> <input type="text" name="website"></td></tr>
    
    <tr><td colspan="2"><input type="submit" selected="" value="Continue" name="cmdSubmit" onclick="showHide()"></td></tr>
    </tbody></table>
    <input type="hidden" value="1" name="AdType">
    
    </form>
<?php dynamic_sidebar( 'recall-info-below' ); ?>
 <br />
   	<div class="echo" id="hidden_div" style="display:none; border:1px solid #F00; padding:7px;">
    	<?php dynamic_sidebar( 'preview-instructions' ); ?>
    </div>
  <?php }  elseif( has_term('postcard-option-2', 'product_category')){?>
  <?php dynamic_sidebar( 'recall-info-above' ); ?>

  <form id="myform" method="POST" enctype="multipart/form-data" action="<?php echo get_template_directory_uri(); ?>/dompdf/www/form_postcard_option2.php" target="preview">
        <input type="hidden" value="<?php echo get_the_ID(); ?>" maxlength="30" name="custId">
<table>
    
    <tbody><tr><td><p>Business Name:</p></td><td> <input type="text" name="BusName"></td></tr>
    <tr><td><p>Address Line 1:</p></td><td> <input type="text" name="Address1"></td></tr>
    <tr><td><p>Address Line 2:</p></td><td> <input type="text" name="Address2"></td></tr>
    <tr><td><p>Phone:</p></td><td>(<input type="text" maxlength="3" size="2" name="Area">)<input type="text" maxlength="3" size="2" name="Prefix">-<input type="text" maxlength="4" size="3" name="Number"> ext.<input type="text" maxlength="5" size="4" name="Ext"></td></tr>
    
    <tr><td><p>Offer Expiration:</p></td><td><p><select name="ExpireMonth">
						<option>January</option>
						<option>February</option>
                        <option>March</option>
                        <option>April</option>
                        <option>May</option>
                        <option>June</option>
                        <option>July</option>
                        <option>August</option>
                        <option>September</option>
                        <option>October</option>
                        <option>November</option>
                        <option>December</option>
</select>/<input type="text" maxlength="2" size="2" name="ExpireDay">/<input type="text" maxlength="2" size="2" name="ExpireYear"></p></td></tr>      
    <tr><td></td><td><p>(mm/dd/yy)</p></td></tr>    
    
    <tr><td colspan="2"><input type="submit" selected="" value="Continue" name="cmdSubmit" onclick="showHide()"></td></tr>
    </tbody></table>    <input type="hidden" value="1" name="AdType">
    
    </form>
<?php dynamic_sidebar( 'recall-info-below' ); ?>
 <br />
   	<div class="echo" id="hidden_div" style="display:none; border:1px solid #F00; padding:7px;">
    	<?php dynamic_sidebar( 'preview-instructions' ); ?>
    </div>
  <?php }else {?>  
  <?php dynamic_sidebar( 'ins-above' ); ?>
		<form id="myform" method="POST" enctype="multipart/form-data" <?php if(has_term('ads-horizontal', 'product_category')) { ?>action="<?php echo get_template_directory_uri(); ?>/dompdf/www/form_horizontal.php" <?php } elseif(has_term('ads-vertical', 'product_category')) {?> action="<?php echo get_template_directory_uri(); ?>/dompdf/www/form.php" <?php }?> target="preview">
        <input type="hidden" value="<?php echo get_the_ID(); ?>" maxlength="30" name="custId">
    <table>
    
    <tbody>
    <?php if(has_term('ads-horizontal', 'product_category')) { ?>
    <tr><td><p>Select Logo:</p></td><td> <input type="file" name="txtFile" id="txtFile"></td></tr>
    <tr><td><br></td><td> </td></tr>
    <?php }?>  
    <tr><td><p>Doctor's Name:</p></td><td> <input type="text" maxlength="30" name="DocName"></td></tr>  
    <tr><td><p>Company Name:</p></td><td> <input type="text" maxlength="30" name="BusName"></td></tr>
    <tr><td><p>Address Line 1:</p></td><td> <input type="text" maxlength="30" name="Address1"></td></tr>
    <tr><td><p>Address Line 2:</p></td><td> <input type="text" maxlength="30" name="Address2"></td></tr>
    <tr><td><p>Phone:</p></td><td>(<input type="text" maxlength="3" size="2" name="Area">)<input type="text" maxlength="3" size="2" name="Prefix">-<input type="text" maxlength="4" size="3" name="Number"> ext.<input type="text" maxlength="5" size="4" name="Ext"></td></tr>
    <tr><td><p>Offer Text:</p></td><td><textarea rows="4" cols="15" name="CouponText"></textarea></td></tr>
    <tr><td><p>Offer Expiration:</p></td><td><p><input type="text" maxlength="2" size="2" name="ExpireMonth">/<input type="text" maxlength="2" size="2" name="ExpireDay">/<input type="text" maxlength="2" size="2" name="ExpireYear"></p></td></tr>  
    <tr><td></td><td><p>(mm/dd/yy)</p></td></tr>
    <tr><td colspan="2"><input type="submit" selected="" value="Continue" name="cmdSubmit" onclick="showHide()"></td></tr>
    </tbody></table>
    <input type="hidden" value="1" name="AdType">
    
    </form>
   <?php dynamic_sidebar( 'ins-below' ); ?>
   <br />
   	<div class="echo" id="hidden_div" style="display:none; border:1px solid #F00; padding:7px;">
    	<?php dynamic_sidebar( 'preview-instructions' ); ?>
    </div>

    <?php }?>
    <br />
<iframe id="preview" name="preview" frameborder="0" marginheight="0" marginwidth="0"></iframe>

<!--<a class="button" target="_blank" href="<?php bloginfo('template_url'); ?>/dompdf/dompdf.php?base_path=www/&options[Attachment]=1&input_file=form.php#toolbar=0&amp;view=FitH&amp;statusbar=0&amp;messages=0&amp;navpanes=0\">DOWNLOAD</a>--> 
      </div><!-- .main_content_sub -->
    </div><!-- #main_content -->


            
</div><!-- #container -->

<?php get_footer(); ?>

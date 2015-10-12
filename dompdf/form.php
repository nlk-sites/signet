<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/signetarmorlite/site/wp-load.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/signetarmorlite/site/wp-includes/plugin.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/signetarmorlite/site/wp-includes/pluggable.php');

?>
<html>
<head>
<style type="text/css">
.cf:before,
.cf:after {
    content: " "; /* 1 */
    display: table; /* 2 */
}
.cf:after {
    clear: both;
}
.cf {
    *zoom: 1;
}
@page { margin: 0px; }
#pdf-wrapper{ margin:0 auto; padding:0;}	
#pdf-wrapper h2{ margin:0px 0 4px 0; padding:0px; font-size:16pt; color: #000; font-weight:normal;}
#pdf-wrapper h3{ margin:0px 0 4px 0; padding:0px; font-size:14pt; color:#000; font-weight:normal;}
p{ margin:0px 0 0px 0; padding:0px; font-size:7pt; font-family:Arial, Helvetica, sans-serif; line-height:32px;}
#pdf-wrapper .name, #pdf-wrapper .company_name, #pdf-wrapper .address1, #pdf-wrapper .address2, #pdf-wrapper .phone, #pdf-wrapper .coupon_text, #pdf-wrapper .expire, #pdf-wrapper .content-area {}
#pdf-wrapper .content-area{ margin-top:0px; height:875px;}
#pdf-wrapper .content-area p{ margin-top:25px;}
#pdf-wrapper .name{ font-weight:bold;}
#pdf-wrapper .name{ margin-top:20px !important;}
#pdf-wrapper .company_name{ margin-top:10px !important;}
#pdf-wrapper .address1{ margin-top:20px !important;}
#pdf-wrapper .address2{ margin-top:10px !important;}
#pdf-wrapper .phone{ margin-top:10px !important;}
#pdf-wrapper .coupon_text{margin-left: 23px !important;top: 0px !important; font-weight:bold; position:absolute;}
#pdf-wrapper .expire{ margin-top:308px !important; margin-left:220px !important; position:absolute;}
#pageContainer2{ display:none;}
.alignleft{ float:left; margin-right:15px;}
</style>
</head>

<body>
<?php 
 if (isset($_POST['cmdSubmit'])) { 
	 $_SESSION['DocName'] = $_POST['DocName'];
	 $_SESSION['custId'] = $_POST['custId'];
	 $_SESSION['BusName'] = $_POST['BusName'];
	 $_SESSION['Address1'] = $_POST['Address1'];
	 $_SESSION['Address2'] = $_POST['Address2'];
	 $_SESSION['Area'] = $_POST['Area'];
	 $_SESSION['Prefix'] = $_POST['Prefix'];
	 $_SESSION['Number'] = $_POST['Number'];
	 $_SESSION['Ext'] = $_POST['Ext'];
	 $_SESSION['CouponText'] = $_POST['CouponText'];
	 $_SESSION['ExpireMonth'] = $_POST['ExpireMonth'];
	 $_SESSION['ExpireDay'] = $_POST['ExpireDay'];
	 $_SESSION['ExpireYear'] = $_POST['ExpireYear']; 
	 $_SESSION['txtFile'] = $_FILES['txtFile']['name'];
 } 
?> 

<?php
$sPathPS = $_SERVER[DOCUMENT_ROOT];
$target = $sPathPS . "/signetarmorlite/site/wp-content/themes/signet/upload_bin/";
$target = $target . basename( $_SESSION['txtFile'] ) ;
$ok=1;

//This is our size condition
if ($uploaded_size > 2097152){
echo "<p>Your file is too large. We have a 2MB limit. <a href='javascript:history.back();'>[Go Back]</a></p><br>";
$ok=0;
}

$types = array('image/jpeg', 'image/gif', 'image/tif');
if( isset( $_FILES['txtFile'] ) ){
	if (in_array($_FILES['txtFile']['type'], $types)) {
		// file is okay continue
	} else {
		$ok = 0;
	} 

	//Here we check that $ok was not set to 0 by an error
	if ( $ok == 0 ){
		echo "<p>Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and TIF filetypes.</p>";
	}else{
		if(move_uploaded_file($_FILES['txtFile']['tmp_name'], $target)){
			echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded";
		}else{
			echo "<p>Sorry, there was a problem uploading your file. <a href='javascript:history.back();'>[Go Back]</a></p>";
		}
	}
}



$DIR = $sPathPS . "/signetarmorlite/site/wp-content/themes/signet/upload_bin/";
if ($handle = opendir($DIR)) {

// This is the correct way to loop over the directory.
	while (false !== ($file = readdir($handle))) {
		if ( filemtime($DIR.$file) <= time()-60) {
			if( $file != '..' && $file != '.' )
			if(  file_exists($DIR.$file) ){
				//echo $DIR.$file;
				unlink($DIR.$file);
			}
		   
		}
	}

	closedir($handle);
}
else
{
echo "cannot open dir";
}

?>	
<?php 
$my_postid = $_SESSION["custId"];//This is page id or post id
$args = array( 'post_type' => 'postcards', 'posts_per_page' => 1, 'p' => $my_postid );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
?>
 
<div <?php if (has_post_thumbnail( $post->ID ) ): $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?> style=" background:url(<?php echo $image[0]; ?>) no-repeat center top;width:960px; height:1400px;  padding:100px 100px 0 65px;page-break-inside:avoid;"<?php endif; /*1390*/?>>

    <div id="pdf-wrapper">
            
            <?php /*if(has_term('ads-horizontal', 'product_category')) { ?>
                <img src="<?php bloginfo('template_url'); ?>/upload_bin/<?php echo $_SESSION['txtFile'] ;?>" alt=""/>
            <?php }*/?>
            <div class="content-area">
                <?php 
                $content_post = get_post($my_postid);
                $content = $content_post->post_content;
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]&gt;', $content);
                echo $content;?>
            </div>
            <br style="clear:both">
            <div style="float:left;width: 425px;">
            	<p class="coupon_text"><strong><?php echo $_SESSION["CouponText"]; ?></strong></p>
                <p class="expire"><?php echo $_SESSION["ExpireMonth"]; ?>/<?php echo $_SESSION["ExpireDay"]; ?>/<?php echo $_SESSION["ExpireYear"];?> </p>
                
            </div>
            <div style="float:left; margin-top:0px; width:auto; margin-left:500px;">
                <p class="name"><strong><?php echo $_SESSION['DocName']; ?></strong></p>
                <p class="company_name"><strong><?php echo $_SESSION["BusName"]; ?></strong></p>
                <p class="address1"><?php echo $_SESSION["Address1"]; ?></p>
                <p class="address2"><?php echo $_SESSION["Address2"]; ?></p>
                <p class="phone">
                    <?php echo $_SESSION["Area"]; ?>-
                    <?php echo $_SESSION["Prefix"]; ?>-
                    <?php echo $_SESSION["Number"]; ?> 
                    <?php if(isset($_SESSION['Ext'])){?> 
                        ext. 
                        <?php echo $_SESSION["Ext"]; ?>
                    <?php }?>
                </p>
            </div>
            <?php /*echo $_SESSION["custId"]; ?> */?>
                        
    </div>
</div>
<?php endwhile; ?>
</body>
</html>

       

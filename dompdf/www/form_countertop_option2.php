<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/plugin.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/pluggable.php');
require_once ('../dompdf_config.inc.php');

if ( isset( $_POST["CouponTitle"] )) {
  $_SESSION['custId'] = $_POST['custId']; 
  $_SESSION['CouponTitle'] = $_POST['CouponTitle']; 
  $_SESSION['CouponText'] = $_POST['CouponText'];
  $_SESSION['ExpireMonth'] = $_POST['ExpireMonth'];
  $_SESSION['ExpireDay'] = $_POST['ExpireDay'];
  $_SESSION['ExpireYear'] = $_POST['ExpireYear']; 
  $_SESSION['txtFile'] = $_FILES['txtFile']['name'];
  
  	$sPathPS = $_SERVER[DOCUMENT_ROOT];
	$target = $sPathPS . "/wp-content/themes/signet/upload_bin/";
	$target = $target . basename( $_SESSION['txtFile'] ) ;
	$ok=1;
	
	//This is our size condition
	if ($uploaded_size > 2097152){
	echo "Your file is too large. We have a 2MB limit. . Please upload smaller file on the form above.";die();
	$ok=0;
	}
	
	$types = array('image/jpeg', 'image/gif', 'image/tif');
	if( isset( $_FILES['txtFile'] )){
		if (in_array($_FILES['txtFile']['type'], $types)) {
			// file is okay continue
		} else {
			$ok = 0;
		} 
	
		//Here we check that $ok was not set to 0 by an error
		if ( $ok == 0 ){
			echo "Please Upload a Logo.";die();
		}else{
			if(move_uploaded_file($_FILES['txtFile']['tmp_name'], $target)){
				//echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded";
			}else{
				echo "Sorry, there was a problem uploading your file. Please re-upload file on the form above.";die();
			}
		}
	}

	$DIR = $sPathPS . "/wp-content/themes/signet/upload_bin/";
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
	echo "cannot open dir";die();
	}

  $worknow = "<html>\n";
  $worknow .= "<head>";
  $worknow .= "<style type='text/css'>
				@page { margin: 0px; }
				#pdf-wrapper{ margin:0 auto; padding:0;}	
				h2{ margin:0px; padding:0px;font-size:115px; font-family:Arial, Helvetica, sans-serif; color:#000; font-weight:bold;}
				h3{ margin:0px 0 73px 0; padding:0px; font-size:105px; font-family:Arial, Helvetica, sans-serif; color:#707579; font-weight:normal;}
				ul{ margin:0px 0 0 0;padding:0px 0 0 0px;}
				ul li{ margin:0px 0 50px 0;padding:0px 0 0 70px; font-family: Arial; font-size:75px; }
				p{ margin:0px;padding:0px; font-size:60px !important; font-family:Arial, Helvetica, sans-serif; color:#000;}
				table{ margin:0px 0 135px 0; padding:0px;}
				tr{ margin:0px; padding:0px;}
				tr td{ margin:0px; padding:0px; font-size:43px; font-family:arial; text-align:center;}
				.alignleft{ float:left; margin-right:15px;}
				.alignright{ float:right; margin-left:15px;}
				.content-area{height:1945px;}
				.area{ width:2150px; height:936px; marin:0px; auto;}
				.wrapper{height:765px;}
				.coupon_text{font-size:95px; font-family:Arial, Helvetica, sans-serif; text-align:center; display:block;}
				.coupon_title{ font-size:130px; font-family:Arial, Helvetica, sans-serif; text-align:center; display:block;}
				.expire{ display:block; float:left; margin:13px 0 0 455px;}
			</style>";	 
  $worknow .= "</head>";
  $worknow .= "<body>";
  
$my_postid = $_SESSION["custId"];//This is page id or post id
$args = array( 'post_type' => 'postcards', 'posts_per_page' => 1, 'p' => $my_postid );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();

	  //HTML Starts Here
	  if(has_post_thumbnail( $post->ID )){
		  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail');
		  $bgstyles = " style=' background:url(" . $image[0] . ") no-repeat center top; width: 2254px; height: 3029px; padding:270px 100px 0 202px; page-break-inside: avoid;'";
	  } else {
		  $bgstyles = "";
	  }
	  
	  	$worknow .= "<div". $bgstyles .">";
	 		$worknow .= "<div id='pdf-wrapper'>";
			
				$worknow .= "<div class='content-area'>";	
					$content_post = get_post($my_postid);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$worknow .= $content;				
				$worknow .= "</div>";					
				$worknow .= "<br style='clear:both'>";	
				$worknow .= "<div class='area'>";
					$worknow .= "<div class='wrapper'>";				
						$worknow .="<span class='coupon_title'><strong> " . $_SESSION["CouponTitle"] . "</strong></span>";
						$worknow .="<span class='coupon_text'><strong> " . $_SESSION["CouponText"] . "</strong></span>";
					$worknow .= "</div>";
					$worknow .="<span class='expire'>" .$_SESSION["ExpireMonth"] . "/ " . $_SESSION["ExpireDay"] . "/ " . $_SESSION["ExpireYear"] . "</span>";									
				$worknow .= "</div>";		
			$worknow .= "</div>";
		$worknow .= "</div>";//HTML Ends Here
	  endwhile;//IF statement should End here 
	  
  $worknow .= "</body></html>\n";
  $dompdf = new DOMPDF();
  $dompdf->load_html($worknow);
  $dompdf->set_paper("counteroption2", "portrait");
  $dompdf->render();
  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
  exit(0);
}
?>      

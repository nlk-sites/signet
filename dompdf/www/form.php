<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/signetarmorlite/site/wp-load.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/signetarmorlite/site/wp-includes/plugin.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/signetarmorlite/site/wp-includes/pluggable.php');
require_once ('../dompdf_config.inc.php');

if ( isset( $_POST["DocName"] )) {
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
  
  	$sPathPS = $_SERVER[DOCUMENT_ROOT];
	$target = $sPathPS . "/signetarmorlite/site/wp-content/themes/signet/upload_bin/";
	$target = $target . basename( $_SESSION['txtFile'] ) ;
	$ok=1;
	
	//This is our size condition
	if ($uploaded_size > 2097152){
	echo "Your file is too large. We have a 2MB limit.";
	$ok=0;die();
	}
	
	$types = array('image/jpeg', 'image/gif', 'image/tif');
	if( isset( $_FILES['txtFile'] )  &&  ($_FILES['txtFile'] > 0)){
		if (in_array($_FILES['txtFile']['type'], $types)) {
			// file is okay continue
		} else {
			$ok = 0;
		} 
	
		//Here we check that $ok was not set to 0 by an error
		if ( $ok == 0 ){
			echo "Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and TIF filetypes.";die();
		}else{
			if(move_uploaded_file($_FILES['txtFile']['tmp_name'], $target)){
				echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded"; die();
			}else{
				echo "Sorry, there was a problem uploading your file.";die();
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
	echo "cannot open dir";die();
	}

  $worknow = "<html>\n";
  $worknow .= "<head>";
  $worknow .= "<style type='text/css'>
				@page { margin: 0px; }
				#pdf-wrapper{ margin:0 auto; padding:0;}	
				#pdf-wrapper h2{ margin:0px 0 4px 0; padding:0px; font-size:15pt; color: #000; font-weight:normal;}
				#pdf-wrapper h3{ margin:0px 0 4px 0; padding:0px; font-size:14pt; color:#000; font-weight:normal;}
				p{ margin:0px 0 0px 0; padding:0px; font-size:7pt; font-family:Arial, Helvetica, sans-serif; line-height:32px;}
				#pdf-wrapper .content-area{ margin-top:0px; height:875px;}
				#pdf-wrapper .content-area p{ margin-top:23px;}
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
				.alignright{ float:right; margin-left:15px;}
			</style>";	 
  $worknow .= "</head>";
  $worknow .= "<body>";
  if ($_SESSION["Ext"] !=''){
	$ext = 'ext.';
	}
$my_postid = $_SESSION["custId"];//This is page id or post id
$args = array( 'post_type' => 'postcards', 'posts_per_page' => 1, 'p' => $my_postid );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();

	  //HTML Starts Here
	  if(has_post_thumbnail( $post->ID )){
		  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail');
		  $bgstyles = " style=' background:url(" . $image[0] . ") no-repeat center top; width: 960px; height: 1400px; padding: 100px 100px 0 65px; page-break-inside: avoid;'";
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
				$worknow .= "<div style='float:left;width: 425px;'>";
					$worknow .="<p class='coupon_text'><strong> " . $_SESSION["CouponText"] . "</strong></p>";
					$worknow .="<p class='expire'>" .$_SESSION["ExpireMonth"] . "/ " . $_SESSION["ExpireDay"] . "/ " . $_SESSION["ExpireYear"] . "</p>";
				$worknow .= "</div>";					
				$worknow .="<div style='float:left; margin-top:0px; width:auto; margin-left:500px;'>";
					$worknow .= " <p class='name'><strong>" . $_SESSION['DocName'] . "</strong></p>";
					$worknow .= "<p class='company_name'><strong>" .  $_SESSION["BusName"] . "</strong></p>";
                	$worknow .= "<p class='address1'>" .  $_SESSION["Address1"] . "</p>";
                	$worknow .= "<p class='address2'>" . $_SESSION["Address2"] . "</p>";
					$worknow .= "<p class='phone'>"  . "(". $_SESSION["Area"] . ") ". $_SESSION["Prefix"] . "-" . $_SESSION["Number"] ." ". $ext .$_SESSION["Ext"] ."</p>";
				$worknow .= "</div>";					
			$worknow .= "</div>";
		$worknow .= "</div>";//HTML Ends Here
	  endwhile;//IF statement should End here 
	  
  $worknow .= "</body></html>\n";
  $dompdf = new DOMPDF();
  $dompdf->load_html($worknow);
  $dompdf->set_paper("vertical", "portrait");
  $dompdf->render();
  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
  exit(0);
}
?>      

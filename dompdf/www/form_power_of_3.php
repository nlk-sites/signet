<?php

  	$sPathPS = $_SERVER[DOCUMENT_ROOT];
		if ( strpos( $sPathPS, 'ninthlin' ) ) {
			$sPathPS .= '/signetarmorlite/site';
		}
require_once( $sPathPS . '/wp-load.php');
require_once( $sPathPS . '/wp-includes/plugin.php');
require_once( $sPathPS . '/wp-includes/pluggable.php');
require_once ('../dompdf_config.inc.php');

if ( isset( $_POST["BusName"] )) {
  $_SESSION['custId'] = $_POST['custId'];
  $_SESSION['BusName'] = $_POST['BusName'];
  $_SESSION['Address1'] = $_POST['Address1'];
  $_SESSION['Address2'] = $_POST['Address2'];
  $_SESSION['Area'] = $_POST['Area'];
  $_SESSION['Prefix'] = $_POST['Prefix'];
  $_SESSION['Number'] = $_POST['Number'];
  $_SESSION['Ext'] = $_POST['Ext'];
  $_SESSION['website'] = $_POST['website'];
  $_SESSION['txtFile'] = $_FILES['txtFile']['name'];
  
	$target = $sPathPS . "/wp-content/themes/signet/upload_bin/";
	$target = $target . basename( $_SESSION['txtFile'] ) ;
	$ok=1;
	
	//This is our size condition
	if ($uploaded_size > 2097152){
	echo "Your file is too large. We have a 2MB limit. . Please upload smaller file on the form above.";die();
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
			//echo "Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and TIF filetypes. Please upload proper file on the form above.";die();
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
				p.status1, p.status2{ font-size:41px !important; font-family:Arial, Helvetica, sans-serif !important; color:#666 !important;}	
				.content-area { display: block; margin: 0 0 0 65px }
				.content-area p { font-size:29px !important; font-family:Arial, Helvetica, sans-serif !important; color:#666 !important;  margin:0px !important;}	
				.content-area{padding-top:0px;}
				.content-area h3{ color:#DD2A26; font-size:74px; margin:0px!important;padding:0px!important; line-height:1; font-weight:bold;}
				.content-area h4{ color:#DD2A26; font-size:59px; margin:0px!important; padding:0px!important; line-height:1;}
				.content-area h5{ color:#DD2A26; font-size:31px; margin:0px!important; padding:0px!important; font-weight:normal; line-height:1;}
				p, table tr td{ margin:0px; padding:0px;font-size:41px !important; font-family:Arial, Helvetica, sans-serif !important; line-height:1;}
				p.phone{ margin-bottom:0px !important;}
				p.status1{ padding-top:35px;}
				.spacer{height:60px;}
				.info-wrapper{ display: block; width:835px;height:440px; margin: 65px 0 0 65px}
				.status-wrapper{ height:100px; margin-top:-20px;}
				.company_name{font-weight:bold;}
				.alignleft{ float:left; margin-right:15px;}
				.alignright{ float:right; margin-left:15px;}
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
		  $bgstyles = " style='background:url(" . $image[0] . ") no-repeat center top; padding:0; width: 1800px; height: 1200px;'";
		  $bgstyles2 = " style='background:url(" . $image[0] . ") no-repeat center bottom; padding:0; width: 1800px; height: 1200px;'";
	  } else {
		  $bgstyles = "";
		  $bgstyles2 = "";
	  }
	if ($_SESSION["Ext"] !=''){
	$ext = 'ext.';
	}  
if ($_SESSION['CardType'] == 'call') {
	$card_status1 = 'Please call for an appointment';
}
elseif ($_SESSION['CardType'] == 'dated') {
	$card_status2 = '<p>Your appointment is scheduled for</p>
	<table>
	<tr>
	<td>Day:</td>
	<td width="30">&nbsp;</td>
	<td>Date:</td>
	<td width="30">&nbsp;</td>
	<td>Time</td>
	<td width="30">&nbsp;</td>
	</tr>
	</table>
	';
}
	  
	  	$worknow .= "<div". $bgstyles ."></div>";
	 		$worknow .= "<div". $bgstyles2 .">";
				$worknow .= "<div class='spacer'></div>";						
				$worknow .= "<div class='info-wrapper'>";
					$worknow .= "<p class='company_name'><strong>" .  $_SESSION["BusName"] . "</strong></p>";
					$worknow .= "<p class='address1'>" .  $_SESSION["Address1"] . "</p>";
                	$worknow .= "<p class='address2'>" . $_SESSION["Address2"] . "</p>";
					$worknow .= "<p class='phone'>" . "(". $_SESSION["Area"] . ") ". $_SESSION["Prefix"] . " -" . $_SESSION["Number"] ." ". $ext .$_SESSION["Ext"] ."</p>";
					$worknow .= "<p class='website'>" . $_SESSION["website"] . "</p>";
					$worknow .=" <img src='../../upload_bin/" .$_SESSION['txtFile']. "' alt='' width='290' height='230' />";		
				$worknow .= "</div>";
				
				$worknow .= "<div style='height:12px;clear:both;'></div>";
				
				$worknow .= "<div class='content-area'>";	
					$content_post = get_post($my_postid);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$worknow .= $content;				
				$worknow .= "</div>";
				
			$worknow .= "</div>";//HTML Ends Here
	  endwhile;//IF statement should End here 
	  
  $worknow .= "</body></html>\n";
  $dompdf = new DOMPDF();
  $dompdf->load_html($worknow);
  $dompdf->set_paper("postcardoption3", "landscape");
  $dompdf->render();
  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
  exit(0);
}
?>      

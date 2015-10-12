<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/plugin.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/pluggable.php');
require_once ('../dompdf_config.inc.php');

if ( isset( $_POST["BusName"] )) {
  $_SESSION['BusName'] = $_POST['BusName'];
  $_SESSION['custId'] = $_POST['custId']; 
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
	if( isset( $_FILES['txtFile'])){
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
				h2,h3{ text-align:right;}
				h2{ margin:0px; padding:0px; font-style:italic;font-size:230px; font-family:'Times New Roman', Times, serif; color:#FF3818; font-weight:normal;}
				h3{ margin:0px 0 73px 0; padding:0px; font-size:54px; font-family:Arial, Helvetica, sans-serif; color:#FFB83F; font-weight:bold;}
				h5{ color:#FF3818; font-family:Arial; font-size:58px;margin:35px 0 0 0; padding:0px;}
				ul{ margin:73px 0 0 0;padding:0px;}
				ul li{ margin:0px 0 30px 0;padding:0px; font-family: Arial; font-size:45px; list-style:inside;}
				p{ margin:0px;padding:0px; font-size:60px; color:#000;}
				tr td{ width:870px; padding-left:60px; padding-right:64px; border-left:8px solid #000;}
				tr td:first-child{border-left:none;}
				.alignleft{ float:left; margin-right:15px;}
				.alignright{ float:right; margin-left:15px;}
				.moveme{ float:left; margin-left:1080px; margin-top:-50px;}
				.company_name{float:left; margin-left:200px;}
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
		  $bgstyles = " style=' background:url(" . $image[0] . ") no-repeat center top; width: 2984px; height: 2390px; padding: 160px 158px 0 158px; page-break-inside: avoid;'";
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
					$worknow .=" <img src=" .$sPathPS. "/wp-content/themes/signet/upload_bin/" .$_SESSION['txtFile']. " alt='' class='moveme' width='310' height='240'/>";
					$worknow .= "<p class='company_name'><strong>" .  $_SESSION["BusName"] . "</strong></p>";
									
					
			$worknow .= "</div>";
		$worknow .= "</div>";//HTML Ends Here
	  endwhile;//IF statement should End here 
	  
  $worknow .= "</body></html>\n";
  $dompdf = new DOMPDF();
  $dompdf->load_html($worknow);
  $dompdf->set_paper("counteroption1", "landscape");
  $dompdf->render();
  $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
  exit(0);
}
?>      

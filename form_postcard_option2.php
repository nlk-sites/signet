<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/signetarmorlite/site/wp-load.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/signetarmorlite/site/wp-includes/plugin.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/signetarmorlite/site/wp-includes/pluggable.php');
require_once ('../dompdf_config.inc.php'); 
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="dompdf_out.pdf"');
if ( isset( $_POST["BusName"] )) {
  $_SESSION['custId'] = $_POST['custId']; //(( isset( $_POST["custId"] )&& is_numeric($_POST["custId"]) && $_POST["custId"] != "") ? $_POST['custId'] : "");
  $_SESSION['BusName'] = (( isset( $_POST["BusName"] ) && $_POST["BusName"] != "") ? $_POST['BusName'] : "");
  $_SESSION['Address1'] = (( isset( $_POST["Address1"] ) && $_POST["Address1"] != "") ? $_POST['Address1'] : "");
  $_SESSION['Address2'] = (( isset( $_POST["Address2"] ) && $_POST["Address2"] != "") ? $_POST['Address2'] : "");
  $_SESSION['ExpireMonth'] = (( isset( $_POST["ExpireMonth"] ) && $_POST["ExpireMonth"] != "") ? $_POST['ExpireMonth'] : "");
  $_SESSION['ExpireDay'] = (( isset( $_POST["ExpireDay"] ) && $_POST["ExpireDay"] != "") ? $_POST['ExpireDay'] : "");
  $_SESSION['ExpireYear'] = (( isset( $_POST["ExpireYear"] ) && $_POST["ExpireYear"] != "") ? $_POST['ExpireYear'] : ""); 
  $_SESSION['Area'] = (( isset( $_POST["Area"] ) && $_POST["Area"] != "") ? $_POST['Area'] : "");
  $_SESSION['Prefix'] = (( isset( $_POST["Prefix"] ) && $_POST["Prefix"] != "") ? $_POST['Prefix'] : "");
  $_SESSION['Number'] = (( isset( $_POST["Number"] ) && $_POST["Number"] != "") ? $_POST['Number'] : "");
  $_SESSION['Ext'] = (( isset( $_POST["Ext"] ) && $_POST["Ext"] != "") ? $_POST['Ext'] : "");
  	 
  $worknow = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://
www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">";
  $worknow .= "<head>";
  $worknow .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /> ";
  $worknow .= "<style type='text/css'>
				@page { margin: 0px; }
				#pdf-wrapper{ margin:0 auto; padding:0;}
				h2{ font-size:165px !important; font-family:Arial, Helvetica, sans-serif !important; color:#000 !important; tect-align:center; margin:30px 0 0 0 !important; padding:0px !important;}
				h3{ font-size:74px !important; font-family:Arial, Helvetica, sans-serif !important; color:#000 !important; tect-align:center; font-weight:normal; margin:0px 0 72px 0 !important; padding:0px !important;}
				.content-area p { font-size:48px; font-family:Arial, Helvetica, sans-serif !important; color:#000 !important;}	
				p{ margin:0px; padding:0px;}
				.content-area{}
				.info-wrapper{}
				.spacer{height:90px;}
				p.company_name{font-weight:bold; margin-top:90px; margin-bottom:20px;}
				p.address1{}
				p.address2{}
				p.phone{font-size:35px;font-family:Arial, Helvetica, sans-serif !important; }
				.offer{font-size:35px;font-family:Arial, Helvetica, sans-serif !important; }
				.expire{ font-size:35px;font-family:Arial, Helvetica, sans-serif !important; }
				.alignleft{ float:left; margin-right:35px;margin-bottom:55px;}
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
		  $bgstyles = " style=' background:url(" . $image[0] . ") no-repeat center top;  padding:0px 0px 0 0px;width: 1800px; height: 1275px;'";
		  $bgstyles2 = " style=' background:url(" . $image[0] . ") no-repeat center bottom;  padding:60px 0px 0 75px;width: 1725px; height: 1275px;'";
	  } else {
		  $bgstyles = "";
		  $bgstyles2 = "";
	  }
	  
	  	$worknow .= "<div". $bgstyles ."></div>";
	 		$worknow .= "<div". $bgstyles2 .">";	
			
				$worknow .= "<div class='content-area'>";	
					$content_post = get_post($my_postid);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					$worknow .= $content;				
				$worknow .= "</div>";
																
				$worknow .= "<div class='info-wrapper'>";
				$worknow .= "<div class='spacer'></div>";	
					$worknow .="<span class='offer'>Offer expires</span> <span class='expire'>" .$_SESSION["ExpireMonth"] . " " . $_SESSION["ExpireDay"] . " 20" . $_SESSION["ExpireYear"] . "</span> <span class='offer'>Not good with any other offer.</span>";						
					$worknow .= "<p class='company_name'><strong>" .  $_SESSION["BusName"] . "</strong></p>";
					$worknow .= "<p class='address1'>" .  $_SESSION["Address1"] . "</p>";
                	$worknow .= "<p class='address2'>" . $_SESSION["Address2"] . "</p>";
					$worknow .= "<p class='phone'>" . "(". $_SESSION["Area"] . ") ". $_SESSION["Prefix"] . " - " . $_SESSION["Number"] . " ext." .$_SESSION["Ext"] ."</p>";		
				$worknow .= "</div>";
			$worknow .= "</div>";//HTML Ends Here
	  endwhile;//IF statement should End here 
	  
  $worknow .= "</body></html>\n";
  $dompdf = new DOMPDF();
  $dompdf->load_html($worknow);
  $dompdf->set_paper("postcardoption1", "landscape");
  $dompdf->render();
  $dompdf->stream("dompdf_out.pdf", array("Attachment" => 0));
  exit();
}
?>      

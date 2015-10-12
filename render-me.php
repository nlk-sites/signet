<div id="container">
        
  <?php if ( have_posts() ) while ( have_posts() ) : the_post();?>
            
    <div id="main_content" role="main">
      <div id="main_content_sub"><!-- .main_content_sub -->
        <div class="ecps_title"><!-- .ecps_title -->
          <?php the_title(); ?>
        </div><!-- .ecps_title -->
		 <?php
$sPathPS = $_SERVER[DOCUMENT_ROOT];
$target = $sPathPS . "/signetarmorlite/site/wp-content/themes/signet/upload_bin/";
$target = $target . basename( $_FILES['txtFile']['name']) ;
$ok=1;

//This is our size condition
if ($uploaded_size > 2097152){
echo "<p>Your file is too large. We have a 2MB limit. <a href='javascript:history.back();'>[Go Back]</a></p><br>";
$ok=0;
}

$types = array('image/jpeg', 'image/gif', 'image/tif');

if (in_array($_FILES['txtFile']['type'], $types)) {
// file is okay continue
} else {
$ok=0;
} 

//Here we check that $ok was not set to 0 by an error
if ($ok==0){
echo "<p>Sorry your file was not uploaded. It may be the wrong filetype. We only allow JPG, GIF, and TIF filetypes. <a href='javascript:history.back();'>[Go Back]</a></p>";
}

//If everything is ok we try to upload it
else{
if(move_uploaded_file($_FILES['txtFile']['tmp_name'], $target)){
echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded";
}
else{
echo "<p>Sorry, there was a problem uploading your file. <a href='javascript:history.back();'>[Go Back]</a></p>";
}
}

$DIR = $sPathPS . "/signetarmorlite/site/wp-content/themes/signet/upload_bin/";
if ($handle = opendir($DIR)) {

// This is the correct way to loop over the directory.
    while (false !== ($file = readdir($handle))) {
        if ( filemtime($DIR.$file) <= time()-3600) {
           unlink($DIR.$file);
        }
    }

    closedir($handle);
}
else
{
echo "cannot open dir";
}
?> <br />
<?php echo $dir;?>
<?php echo $file;?>
<?php $my_postid = $_POST["custId"];//This is page id or post id
$content_post = get_post($my_postid);
$content = $content_post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
echo $content;?>

			<img src="<?php bloginfo('template_url'); ?>/upload_bin/<?php echo basename( $_FILES['txtFile']['name']) ;?>" alt=""/>
          <p><?php echo $_POST["DocName"]; ?></p>
          <p><?php echo $_POST["custId"]; ?></p>
          <p><?php echo $_POST["BusName"]; ?></p>
          <p><?php echo $_POST["Address1"]; ?></p>
          <p><?php echo $_POST["Address2"]; ?></p>
          <p><?php echo $_POST["Area"]; ?>-<?php echo $_POST["Prefix"]; ?>-<?php echo $_POST["Number"]; ?>-<?php echo $_POST["Ext"]; ?></p>
          <p><?php echo $_POST["CouponText"]; ?></p>
          <p><?php echo $_POST["ExpireMonth"]; ?>/<?php echo $_POST["ExpireDay"]; ?>/<?php echo $_POST["ExpireYear"]; ?></p>		
      </div><!-- .main_content_sub -->
    </div><!-- #main_content -->

  <?php endwhile; ?>
            
</div><!-- #container -->


<?php 
/*
Template Name: Info Template
*/
?>
<style>
a		{ text-decoration: underline; color:#FE000C;}
a:hover     	{ text-decoration: underline; color:#FE000C;}
a:visited     	{ text-decoration: underline; color:#404040;}
p      		{ font-family: Georgia,serif; color: #000000; font-size: 12px;}
.title 		{ font-family: Georgia,serif; font-weight: bold; color: #000000; font-size: 12px; }
ul		{font-family: Georgia, serif; color: #000000;  font-size: 12px; list-style-type: round}
li		{font-family: Georgia, serif; color: #000000; font-size: 12px; }
.footer	{ font-family: Georgia,serif; color: #666666; font-size: 9px;}
.address	{ font-family: Georgia,serif; color: #000000; font-size: 10px; line-height: 17px;}
.error		{ font-family: Georgia,serif; color: #FFFFFF; font-size: 12px;}
.redtitle 	{ font-family: Georgia,serif; font-weight: bold; color: #FE000C; font-size: 12px; }
.caption	{ font-family: Georgia,serif; color: #000000; font-size: 10px;}
ol	{ margin-left: -25px; font-family: Georgia,serif; color: #000000; font-size: 12px; }
*html ol { margin-left: 30px; font-family: Georgia,serif; color: #000000; font-size: 12px; }
.underline    { font-family: Georgia,serif; color: #000000; font-size: 12px; text-decoration: underline;}
</style>

  <?php if ( have_posts() ) while ( have_posts() ) : the_post();?>
        <?php the_content(); ?>
  <?php endwhile; ?>

<?php
/**
 * Template Name: International Page
 *
 * The template for displaying Labtech pros page.
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
 
$sapikey = 'AIzaSyCL3LsIRVnstE_RXqjW9_kaEpVZ6_L0cnQ';
if ( defined('SIGNETDEV') ) {
	if ( SIGNETDEV ) {
		$sapikey = 'AIzaSyBVyV35ldP6QESiFjC18v3J0qQ9ATPaDb8'; //ninthlink.net?
	}
}
wp_enqueue_script('gmap', 'https://maps.googleapis.com/maps/api/js?key='. $sapikey .'&sensor=false');

get_header();
global $wp_query;
$page_id = $wp_query->post->ID;
?>
<!-- page-international -->
<div id="container">

  <div class="top_box_labtech">
    <div class="top_img_txt_lab">
      <h1 style="color:#CCC">
        <?php echo get_post_meta(get_the_ID(), 'Image-text', true); ?>
      </h1>
    </div>
    <img src="<?php bloginfo('template_directory') ?>/images/labtech_back.jpg" />
  </div>

  <div id="labtech" class="page_sidebar resources_bar">
    <?php dynamic_sidebar( 'resources-widget-area' ); ?>
  </div>

  <div id="main_content" role="main">
    <div id="main_content_sub">
      <div class="labtech_title">
        <?php the_title() ?>
      </div><!-- .labtech_title -->
      <!--h6>Rollover and click the map to view locations</h6-->
      <div class="international_map">
		<div id="gmaphere"></div>
		<script type="text/javascript">
		var sa_pin = '<?php bloginfo('template_url'); ?>/images/marker.png';
		var sa_locs = [
		<?php
		$pages = get_pages( array( 'child_of' => $page_id, 'sort_column' => 'menu_order', 'sort_order' => 'asc' ) );
		foreach ( $pages as $p ) {
			$mk = get_post_meta($p->ID, 'latlng', true);
			if ( $mk != '' ) {
				echo '[ new google.maps.LatLng('. $mk .') , "'. get_permalink($p->ID) .'"],'. "\n";
			}
		}
		?>
		];
		var map;
		var markers = [];
		//var iterator = 0;
		function sa_drop() {
		  for (var i = 0; i < sa_locs.length; i++) {
			addMarker(i);
		  }
		}

		function addMarker(i) {
		  var newmarker = new google.maps.Marker({
			position: sa_locs[i][0],
			map: map,
			icon: sa_pin,
			url: sa_locs[i][1],
			draggable: false,
		  });
		  google.maps.event.addListener(newmarker, 'click', function() {
			window.location = this.url;
		  });
		  markers.push(newmarker);
		}
		function sa_map_init() {
			var mapOptions = {
				zoom: 1,
				center: new google.maps.LatLng(20,10),
				streetViewControl: false,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById('gmaphere'), mapOptions);
			
			var styles = [
			  {
				"featureType": "water",
				"stylers": [
				  { "color": "#ffffff" }
				]
			  },{
				"featureType": "landscape",
				"stylers": [
				  { "color": "#ffb700" }
				]
			  }
			];

			map.setOptions({styles: styles});
			
			sa_drop();
		}
		
		google.maps.event.addDomListener(window, 'load', sa_map_init);
		</script>
		<style type="text/css">#gmaphere { margin: 0; width:526px; height: 280px }</style>
      </div><!-- .international_map -->

    </div><!-- #main_content_sub -->
    <div class="clear"></div>
  </div><!-- #main_content -->

</div><!-- #container -->
<?php get_footer(); ?>

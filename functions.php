<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, signet_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'signet_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package Signet Armorlite
 * @subpackage signet
 * @since signet 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) ) {
  $content_width = 640;
}

/** Tell WordPress to run signet_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'signet_setup' );

if ( ! function_exists( 'signet_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override signet_setup() in a child theme, add your own signet_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since signet 1.0
 */
function signet_setup() {

  // This theme styles the visual editor with editor-style.css to match the theme style.
  add_editor_style();

  //add_filter( 'show_admin_bar' , '__return_false');

  // This theme uses post thumbnails
  add_theme_support( 'post-thumbnails' );

  // Add default posts and comments RSS feed links to head
  add_theme_support( 'automatic-feed-links' );

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus( array(
    'primary' => __( 'Primary Navigation', 'signet' ),
    'kodak' => __( 'Kodak Lens', 'signet' ),
    'eyecare' => __( 'EyeCare Professional', 'signet' ),
    'labtech' => __( 'LabTech Pros', 'signet' ),
    'resources' => __( 'Resources', 'signet' ),
    'footer' => __( 'Footer', 'signet' )
  ) );

  // hooks to actions & filters...
  add_action('wp_print_scripts', 'signet_add_scripts');
  add_filter('wp_nav_menu_objects','signet_menu_hook', 1, 2);
}
endif;

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since signet 1.0
 * @return int
 */
function signet_excerpt_length( $length ) {
  return 40;
}
add_filter( 'excerpt_length', 'signet_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since signet 1.0
 * @return string "Continue Reading" link
 */
function signet_continue_reading_link() {
  return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'signet' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and signet_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since signet 1.0
 * @return string An ellipsis
 */
function signet_auto_excerpt_more( $more ) {
  return ' &hellip;' . signet_continue_reading_link();
}
add_filter( 'excerpt_more', 'signet_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since signet 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function signet_custom_excerpt_more( $output ) {
  if ( has_excerpt() && ! is_attachment() ) {
    $output .= signet_continue_reading_link();
  }
  return $output;
}
add_filter( 'get_the_excerpt', 'signet_custom_excerpt_more' );

if ( ! function_exists( 'signet_comment' ) ) :
  /**
   * Template for comments and pingbacks.
   *
   * To override this walker in a child theme without modifying the comments template
   * simply create your own signet_comment(), and that function will be used instead.
   *
   * Used as a callback by wp_list_comments() for displaying the comments.
   *
   * @since signet 1.0
   */
  function signet_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
      case '' :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
          <div id="comment-<?php comment_ID(); ?>">
            <div class="comment-author vcard">
              <?php echo get_avatar( $comment, 40 ); ?>
              <?php printf( __( '%s <span class="says">says:</span>', 'signet' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
            </div><!-- .comment-author .vcard -->
            <?php if ( $comment->comment_approved == '0' ) : ?>
              <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'signet' ); ?></em><br />
            <?php endif; ?>

            <div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
              <?php
              /* translators: 1: date, 2: time */
              printf( __( '%1$s at %2$s', 'signet' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'signet' ), ' ' );
              ?>
            </div><!-- .comment-meta .commentmetadata -->

            <div class="comment-body"><?php comment_text(); ?></div>

            <div class="reply">
              <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
          </div><!-- #comment-##  -->
        </li>
        <?php
        break;
      case 'pingback'  :
      case 'trackback' :
        ?>
        <li class="post pingback">
          <p><?php _e( 'Pingback:', 'signet' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'signet' ), ' ' ); ?></p>
        </li>
        <?php
        break;
    endswitch;
  }
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override signet_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since signet 1.0
 * @uses register_sidebar
 */
function signet_widgets_init() {

  register_sidebar( array(
    'name' => __( 'ECPS Page Widget Area', 'signet' ),
    'id' => 'ecps-widget-area',
    'description' => __( 'The ECPS page widget area', 'signet' ),
    'before_widget' => '<div class="widget-ecps">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );

  register_sidebar( array(
    'name' => __( 'Labtech Page Widget Area', 'signet' ),
    'id' => 'labtech-widget-area',
    'description' => __( 'The Labtech page widget area', 'signet' ),
    'before_widget' => '<div class="widget-ecps">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );

  register_sidebar( array(
    'name' => __( 'Resources Page Widget Area', 'signet' ),
    'id' => 'resources-widget-area',
    'description' => __( 'The Resources page widget area', 'signet' ),
    'before_widget' => '<div class="widget-ecps">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );

  register_sidebar( array(
    'name' => __( 'Blog Widget Area', 'signet' ),
    'id' => 'blog-widget-area',
    'description' => __( 'The Blog widget area', 'signet' ),
    'before_widget' => '<div class="widget-ecps blog_widget">',
    'after_widget' => '</div>',
    'before_title' => '<div class="blog_widget_title">',
    'after_title' => '</div>',
  ) );

  register_sidebar( array(
    'name' => __( 'Language Selection', 'signet' ),
    'id' => 'lang-widget-area',
    'description' => __( 'The Language widget area', 'signet' ),
    'before_widget' => '<div class="widget-language">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );
    register_sidebar( array(
    'name' => __( 'Form Instruction Above', 'signet' ),
    'id' => 'ins-above',
    'description' => __( 'The Language widget area', 'signet' ),
    'before_widget' => '<div class="widget-ins">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );
    register_sidebar( array(
    'name' => __( 'Form Instruction Below', 'signet' ),
    'id' => 'ins-below',
    'description' => __( 'The Language widget area', 'signet' ),
    'before_widget' => '<div class="widget-ins">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );  
    register_sidebar( array(
    'name' => __( 'Counter Top Info', 'signet' ),
    'id' => 'countertop-info',
    'description' => __( 'The Language widget area', 'signet' ),
    'before_widget' => '<div class="widget-ins">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );    
    register_sidebar( array(
    'name' => __( 'Counter Top Info Option 2', 'signet' ),
    'id' => 'countertop-info2',
    'description' => __( 'The Language widget area', 'signet' ),
    'before_widget' => '<div class="widget-ins">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) ); 
    register_sidebar( array(
    'name' => __( 'Recall Cards Info Above', 'signet' ),
    'id' => 'recall-info-above',
    'description' => __( 'The Language widget area', 'signet' ),
    'before_widget' => '<div class="widget-ins">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );  
     register_sidebar( array(
    'name' => __( 'Recall Cards Info Below', 'signet' ),
    'id' => 'recall-info-below',
    'description' => __( 'The Language widget area', 'signet' ),
    'before_widget' => '<div class="widget-ins">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );  
     register_sidebar( array(
    'name' => __( 'Preview Instructions', 'signet' ),
    'id' => 'preview-instructions',
    'description' => __( 'The Language widget area', 'signet' ),
    'before_widget' => '<div class="widget-ins">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
  ) );      
}
/** Register sidebars by running signet_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'signet_widgets_init' );

if ( ! function_exists( 'signet_posted_on' ) ) :
  /**
   * Prints HTML with meta information for the current post-date/time and author.
   *
   * @since signet 1.0
   */
  function signet_posted_on() {
    printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'signet' ),
      'meta-prep meta-prep-author',
      sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
        get_permalink(),
        esc_attr( get_the_time() ),
        get_the_date()
      ),
      sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
        get_author_posts_url( get_the_author_meta( 'ID' ) ),
        sprintf( esc_attr__( 'View all posts by %s', 'signet' ), get_the_author() ),
        get_the_author()
      )
    );
  }
endif;

if ( ! function_exists( 'signet_posted_in' ) ) :
  /**
   * Prints HTML with meta information for the current post (category, tags and permalink).
   *
   * @since signet 1.0
   */
  function signet_posted_in() {
    // Retrieves tag list of current post, separated by commas.
    $tag_list = get_the_tag_list( '', ', ' );
    if ( $tag_list ) {
      $posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'signet' );
    } elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
      $posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'signet' );
    } else {
      $posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'signet' );
    }
    // Prints the string, replacing the placeholders.
    printf(
      $posted_in,
      get_the_category_list( ', ' ),
      $tag_list,
      get_permalink(),
      the_title_attribute( 'echo=0' )
    );
  }
endif;

if ( ! function_exists( 'signet_add_scripts' ) ):
  /**
   * hooked to 'wp_print_scripts' by add_action in progo_setup()
   * adds front-end js
   * @since Direct 1.0
   */
  function signet_add_scripts() {
    if ( !is_admin() ) {
      wp_enqueue_script( 'jquery-cookie', get_bloginfo('template_url') .'/js/jquery.cookies.js', array('jquery'), '2.2.0' );
      wp_enqueue_script( 'signet', get_bloginfo('template_url') .'/js/signet.js', array('jquery-cookie', 'swfobject'), '1.0' );
	  
	  /* site does not use COMMENTS, so no script
	  if ( is_singular('post') && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	   */
    }
  }
endif;

if ( ! function_exists( 'signet_menu_hook' ) ):
  function signet_menu_hook($sorted_menu_items, $args) {
    if ( in_array( $args->theme_location, array( 'primary', 'kodak', 'footer' ) ) ) {
      foreach ( $sorted_menu_items as $k => $v ) {
        $sorted_menu_items[$k]->title = str_replace('Kodak', '<strong>Kodak</strong>', $v->title);
      }
    }
    return $sorted_menu_items;
  }
endif;

function box_shortcode( $atts, $content = null ) {
   return '<div class="entry_box"><div class="entry_box_content">' . $content . '</div></div>';
}
add_shortcode( 'box', 'box_shortcode' );

function imgfloat_shortcode( $atts, $content = null ) {
   return '<div class="float_img">' . $content . '</div>';
}
add_shortcode( 'float', 'imgfloat_shortcode' );

function imgfloat_last_shortcode( $atts, $content = null ) {
   return '<div class="float_img">' . $content . '</div><div style="clear:both"></div>';
}
add_shortcode( 'float_last', 'imgfloat_last_shortcode' );

function media_library( $atts ) {
	extract( shortcode_atts( array(
	'category' => 0,
	), $atts ) );
	
	global $post;
	$args = array( 'numberposts' => -1, 'offset'=> 1, 'category' => $category, 'order' => 'ASC' );
	$media = get_posts( $args );
	$html = '';
	$firstone = true;
	foreach( $media as $post ) {
		$yt = get_post_meta(get_the_ID(), 'Youtube-code', true);
		if ( $firstone == true ) {
			$html .= '<iframe width="605" height="440" src="http://www.youtube.com/embed/'. $yt .'?rel=0" frameborder="0" allowfullscreen name="youtubeplayer" id="youtubeplayer"></iframe>';
			$html .= '<ul class="playerthms">';
		}
		setup_postdata($post);
		$html .= '<li'. ($firstone ? ' class="on"' : '') .'><a href="#'. $yt .'" onclick="jQuery(\'#youtubeplayer\').attr(\'src\', \'http://www.youtube.com/embed/'. $yt .'?rel=0&autoplay=1\'); jQuery(this).parent().addClass(\'on\').siblings(\'.on\').removeClass(); return false;"><img src="http://i3.ytimg.com/vi/'. $yt .'/default.jpg" width="120" height="90" alt="'. get_the_title() .'" />'. get_the_title() .'</a></li>';
		
		$firstone = false;
	}
	$html .= '</ul>';
	
	return $html;
}
add_shortcode( 'media_library', 'media_library' );

add_action('template_redirect','signet_template_redirect');
function signet_template_redirect() {
	$red = false;
	
	$ruri = $_SERVER['REQUEST_URI'];
	switch ( $ruri ) { // switch for individual redirects
		case '/index.asp':
			$red = '/';
			break;
		case '/professional/index.asp':
			$red = '/eye-care-professionals/';
			break;
		case '/optometry/index.asp?page_id=125':
		case '/lab/index.asp?page_id=125':
		case '/lab/index.asp?page_id=127':
			$red = '/eye-care-professionals/education-offerings/';
			break;
		case '/optometry/index.asp?page_id=131':
			$red = '/eye-care-professionals/marketing-tools/';
			break;
		case '/optometry/index.asp?page_id=132':
			$red = '/eye-care-professionals/marketing-tools/ads/';
			break;
		case '/lab/index.asp?page_id=134':
			$red = '/eye-care-professionals/marketing-tools/on-hold-messages/';
			break;
		case '/optometry/index.asp?page_id=133':
			$red = '/eye-care-professionals/marketing-tools/recall-cards/';
			break;
		case '/professional/index.asp?page_id=12':
		case '/lab/index.asp?page_id=12':
			$red = '/eye-care-professionals/practice-plus/';
			break;
		case '/lab/index.asp':
			$red = '/lab-tech-pro/';
			break;
		case '/catalog':
		case '/lab/index.asp?page_id=238':
		case '/lab/index.asp?page_id=7':
			$red = '/lab-tech-pro/lens-catalog/';
			break;
		case '/lab/index.asp?page_id=10':
			$red = '/lab-tech-pro/material-processing/';
			break;
		case '/lab/index.asp?page_id=31':
		case '/lab/index.asp?page_id=141':
		case '/lab/index.asp?page_id=30':
		case '/lab/index.asp?page_id=42':
			$red = '/lab-tech-pro/obsolete/';
			break;
		case '/lab/index.asp?page_id=32':
		case '/lab/index.asp?page_id=9':
			$red = '/lab-tech-pro/software-support/';
			break;
		case '/wearer/index.asp':
		case '/lab/index.asp?page_id=13':
		case '/wearer/index.asp?page_id=2':
		case '/lab/index.asp?page_id=20':
		case '/professional/index.asp?page_id=13':
		case '/professional/index.asp?page_id=141':
		case '/wearer/index.asp?page_id=5':
			$red = '/kodak-lens/';
			break;
		case '/lab/index.asp?page_id=211':
		case '/professional/index.asp?page_id=211':
			$red = '/kodak-lens/anti-fatigue/';
			break;
		case '/wearer/index.asp?page_id=210':
		case '/lab/index.asp?page_id=143':
		case '/professional/index.asp?page_id=143':
			$red = '/kodak-lens/kodak-anti-reflectives/';
			break;
		case '/wearer/index.asp?page_id=4':
			$red = '/kodak-lens/kodak-concise/';
			break;
		case '/wearer/index.asp?page_id=235':
			$red = '/kodak-lens/kodak-monitor-view/';
			break;
		case '/wearer/index.asp?page_id=3':
		case '/lab/index.asp?page_id=16':
		case '/professional/index.asp?page_id=16':
			$red = '/kodak-lens/kodak-precise/';
			break;
		case '/lab/index.asp?page_id=196':
			$red = '/kodak-lens/kodak-precise-short/';
			break;
		case '/lab/index.asp?page_id=171':
		case '/wearer/index.asp?page_id=173':
		case '/lab/index.asp?page_id=172':
		case '/professional/index.asp?page_id=171':
		case '/professional/index.asp?page_id=172':
			$red = '/kodak-lens/kodak-unique/';
			break;
		case '/about/index.asp':
			$red = '/resources/';
			break;
		case '/about/index.asp?page_id=24':
			$red = '/resources/company-profile/';
			break;
		case '/about/index.asp?page_id=25':
			$red = '/resources/employment/';
			break;
		case '/about/index.asp?page_id=28':
			$red = '/resources/employment/human-resources/';
			break;
		case '/about/index.asp?page_id=27':
			$red = '/resources/employment/job-opportunities/';
			break;
		case '/about/index.asp?page_id=35&loc_id=5':
			$red = '/resources/international/canada/';
			break;
		case '/about/index.asp?page_id=35&loc_id=7':
			$red = '/resources/international/colombia/';
			break;
		case '/about/index.asp?page_id=35&loc_id=10':
			$red = '/resources/international/europe/';
			break;
		case '/lab/index.asp?page_id=70&baseCategory_id=2&navSource=8':
			$red = '/category/news/';
			break;
		case '/about/index.asp?page_id=35&loc_id=2':
			$red = '/resources/international/asiansingapore/';
			break;
		default:
			if ( ( ( strpos(strtolower($ruri), '/lab/tips') !== false ) && ( strpos($ruri, '.html') > 0 ) ) 
				|| ( ( strpos($ruri, '/barcodes/') !== false ) && ( strpos($ruri, '.pdf') > 0 ) ) ) {
				$red = 'http://66.185.169.3'. $ruri;
			}
			break;
	}
	if ($red) {
		wp_safe_redirect($red,301);
		exit();
	}
}

add_filter( 'allowed_redirect_hosts' , 'signet_allowed_redirect_hosts' , 10 );
function signet_allowed_redirect_hosts($hosts){
	$hosts[] = 'portal.signetarmorlite.com';
	$hosts[] = '66.185.169.3';
	return $hosts;
}

/* ODIM Custom Post Type */
function odim_custom_product() {
	$labels = array(
		'name'               => _x( 'Post Cards', 'post type general name' ),
		'singular_name'      => _x( 'Post Cards', 'post type singular name' ),
		'add_new'            => _x( 'Add New', ' ' ),
		'add_new_item'       => __( 'Add New Post Card' ),
		'edit_item'          => __( 'Edit Post Card' ),
		'new_item'           => __( 'New Post Card' ),
		'all_items'          => __( 'All Post Cards' ),
		'view_item'          => __( 'View Post Card' ),
		'search_items'       => __( 'Search Post Cards' ),
		'not_found'          => __( 'No Post Card found' ),
		'not_found_in_trash' => __( 'No Post Card found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Post Cards'
	);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our products and product specific data',
		'public'        => true,
		'menu_position' => 16,
		'rewrite' => array( 'slug' => 'product','with_front' => FALSE),
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
		'has_archive'   => true,
		
	);
	register_post_type( 'postcards', $args );	
}
add_action( 'init', 'odim_custom_product' );

function odim_taxonomies_product() {
	$labels = array(
		'name'              => _x( 'Post Cards Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Post Cards Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Post Card Categories' ),
		'all_items'         => __( 'All Post Cards Categories' ),
		'parent_item'       => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Category:' ),
		'edit_item'         => __( 'Edit Category' ), 
		'update_item'       => __( 'Update Category' ),
		'add_new_item'      => __( 'Add New Category' ),
		'new_item_name'     => __( 'New Category' ),
		'menu_name'         => __( 'Post Cards Categories' ),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'product_category', 'postcards', $args );
}
add_action( 'init', 'odim_taxonomies_product', 0 );

function post_template_meta_box($post) {
  if ( 'post' == $post->post_type && 0 != count( get_post_templates() ) ) {
    $template = get_post_meta($post->ID,'_post_template',true);
    ?>
<label class="screen-reader-text" for="post_template"><?php _e('Post Template') ?></label><select name="post_template" id="post_template">
<option value='default'><?php _e('Default Template'); ?></option>
<?php post_template_dropdown($template); ?>
</select>
<?php
  }
}
//add_action('add_meta_boxes','add_post_template_metabox');
function add_post_template_metabox() {
    add_meta_box('postparentdiv', __('Post Template'), 'post_template_meta_box', 'post', 'side', 'core');
}
// Added to extend allowed files types in Media upload 
add_filter('upload_mimes', 'signet_custom_upload_mimes');
function signet_custom_upload_mimes ( $existing_mimes=array() ) { 
	// Add *.EPS files to Media upload 
	$existing_mimes['eps'] = 'application/postscript'; 
	// Add *.AI files to Media upload 
	$existing_mimes['ai'] = 'application/postscript';
	
	return $existing_mimes;
}

function signet_social() {
	?>
<ul class="social">
<li class="fb"><a href="https://www.facebook.com/SignetArmorlite" target="_blank" title="Like us on Facebook">Facebook</a></li>
<li class="tw"><a href="https://twitter.com/SignetArmorlite" target="_blank" title="Follow us on Twitter">Twitter</a></li>
<li class="yt"><a href="https://www.youtube.com/channel/UCHxS5g9ED9Z1IWB_2mbAy2g" target="_blank" title="Watch us on YouTube">YouTube</a></li>
</ul>
	<?php
}


/**
 * Add video meta_box
 */
function video_add_meta_box() {

  $screens = array( 'post', 'page' );

  foreach ( $screens as $screen ) {

    add_meta_box(
      'video_metabox_sectionid',
      __( 'Add Post Video', 'video_metabox_textdomain' ),
      'video_meta_box_callback',
      $screen,
      'side'
    );
  }
}
add_action( 'add_meta_boxes', 'video_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function video_meta_box_callback( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'video_meta_box', 'video_meta_box_nonce' );

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   */
  $value = get_post_meta( $post->ID, '_video_meta_value_key', true );

  echo '<label for="video_id_field">';
  _e( 'Video ID', 'video_metabox_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="video_id_field" name="video_id_field" value="' . esc_attr( $value ) . '" size="25" />';
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function video_save_meta_box_data( $post_id ) {

  /*
   * We need to verify this came from our screen and with proper authorization,
   * because the save_post action can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['video_meta_box_nonce'] ) ) {
    return;
  }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['video_meta_box_nonce'], 'video_meta_box' ) ) {
    return;
  }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }

  // Check the user's permissions.
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return;
    }

  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  }

  /* OK, it's safe for us to save the data now. */
  
  // Make sure that it is set.
  if ( ! isset( $_POST['video_id_field'] ) ) {
    return;
  }

  // Sanitize user input.
  $my_data = sanitize_text_field( $_POST['video_id_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, '_video_meta_value_key', $my_data );
}
add_action( 'save_post', 'video_save_meta_box_data' );

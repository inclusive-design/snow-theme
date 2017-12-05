<?php
function snow_theme_enqueue_styles() {
    $parent_style = 'a11y-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'snow_theme_enqueue_styles' );

/* Add SNOW introduction to front page */
register_sidebar( array(
	'name' => __( 'Snow Home', 'snow' ),
	'id' => 'snow-home',
	'before_widget' => '<div id="snow-home" class="snow-home">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="snow-title">',
	'after_title' => '</h3>'
));

/* Add 'Accessing the Site' to front page */
register_sidebar( array(
	'name' => __( 'Accessing the Site', 'access' ),
	'id' => 'access-site',
	'before_widget' => '<div id="snow-access" class="snow-access">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="snow-access-title">',
	'after_title' => '</h3>'
));

/* Add 'Share your experiences on SNOW' to front page.' */
register_sidebar( array(
	'name' => __( 'Experiences', 'experiences' ),
	'id' => 'snow-experiences',
	'before_widget' => '<div id="snow-experiences" class="snow-experiences">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="snow-experiences-title">',
	'after_title' => '</h3>'
));

/* Add footer widgets */
register_sidebar( array(
	'name' => __( 'License Information', 'license-info' ),
	'id' => 'license-info',
	'before_widget' => '<div id="snow-license" class="snow-license">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="snow-license-title">',
	'after_title' => '</h3>'
));

register_sidebar( array(
	'name' => __( 'Contact Information', 'contact' ),
	'id' => 'contact',
	'before_widget' => '<div id="snow-contact" class="snow-contact">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="snow-contact-title">',
	'after_title' => '</h3>'
));

register_sidebar( array(
	'name' => __( 'Partners', 'partners' ),
	'id' => 'partners',
	'before_widget' => '<div id="snow-partners" class="snow-partners">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="snow-partners-title">',
	'after_title' => '</h3>'
));
/* End footer widgets */


/* Begin extending widget for Upcoming Workshops front panel */
function snow_upcoming_workshops_sticky() { 
 
	/* Get all sticky posts */
	$sticky = array(
	  'category__and' => array( '7' ),
	  'posts_per_page' => 1,
	  'post__in' => get_option( 'sticky_posts' ),
	  'ignore_sticky_posts' => 1
	);
	 
	/* Query sticky posts */
	$the_query = new WP_Query($sticky);
	if ( $the_query->have_posts() ) {
	    while ( $the_query->have_posts() ) {
	        $the_query->the_post();
	        $return .= '<p><a href="' .get_permalink(). '" title="'  . get_the_title() . '">' . get_the_title() . '</a></p>' . '<p>' . get_the_excerpt() . '</p>';
	    }
     
	} else {
	    // no posts found
	}

	/* Restore original Post Data */
	wp_reset_postdata();
	 
	return $return; 
} 
add_shortcode('snow_upcoming_workshops_sticky', 'snow_upcoming_workshops_sticky');

class snow_upcoming_workshops extends WP_Widget {

  /* Set up the widget name and description */
  public function __construct() {
    $widget_options = array( 'classname' => 'snow_upcoming_workshops', 'description' => 'Display the sticky Upcoming Workshop.' );
    parent::__construct( 'snow_upcoming_workshops', 'Upcoming Workshops', $widget_options );
  }

  /* Create the widget output */
  public function widget( $args ) {
    $title = 'Upcoming Workshops';
    $content = do_shortcode('[snow_upcoming_workshops_sticky]');

    echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; ?>
   	<div class="snow-widget">
 		<?php echo $content; ?>
    </div>
    <?php echo $args['after_widget'];
  }
}

/* Register the widget */
function snow_upcoming_workshops() { 
  register_widget( 'snow_upcoming_workshops' );
}
add_action( 'widgets_init', 'snow_upcoming_workshops' );
/* End extending widget for Upcoming Workshops front panel */

add_filter('widget_text', 'do_shortcode');

?>


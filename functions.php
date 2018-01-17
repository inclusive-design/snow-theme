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

/**
* a11y widgets for front page
*/

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'Front Panel 1',
		'id'   => 'a11y-front-panel1',
		'before_widget' => '<div id="%1$s" class="small-12 medium-4 columns a11y-front-panel">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="a11y-panel-header">',
		'after_title'   => '</h1>'
	));
	register_sidebar(array(
		'name' => 'Front Panel 2',
		'id'   => 'a11y-front-panel2',
		'before_widget' => '<div id="%1$s" class="small-12 medium-4 columns a11y-front-panel">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="a11y-panel-header">',
		'after_title'   => '</h1>'
	));
	register_sidebar(array(
		'name' => 'Front Panel 3',
		'id'   => 'a11y-front-panel3',
		'before_widget' => '<div id="%1$s" class="small-12 medium-4 columns a11y-front-panel">',
		'after_widget'  => '</div>',
		'before_title'  => '<h1 class="a11y-panel-header">',
		'after_title'   => '</h1>'
	));
}

/* Add custom menu for sidebar */
function snow_sidebar_menu() {
  register_nav_menu('snow_sidebar_menu',__( 'Sidebar Menu' ));
}
add_action( 'init', 'snow_sidebar_menu' );

/* Add SNOW introduction to front page */
register_sidebar( array(
	'name' => __( 'Snow Home', 'snow' ),
	'id' => 'snow-home',
	'before_widget' => '<div id="snow-home" class="snow-home">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="snow-title">',
	'after_title' => '</h1>'
));

/* Add 'Accessing the Site' to front page */
register_sidebar( array(
	'name' => __( 'Accessing the Site', 'access' ),
	'id' => 'access-site',
	'before_widget' => '<div id="snow-access" class="snow-access">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="snow-access-title">',
	'after_title' => '</h1>'
));

/* Add 'Share your experiences on SNOW' to front page.' */
register_sidebar( array(
	'name' => __( 'Experiences', 'experiences' ),
	'id' => 'snow-experiences',
	'before_widget' => '<div id="snow-experiences" class="snow-experiences">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="snow-experiences-title">',
	'after_title' => '</h1>'
));

/* Add footer widgets */
register_sidebar( array(
	'name' => __( 'License Information', 'license-info' ),
	'id' => 'license-info',
	'before_widget' => '<div id="snow-license" class="small-12 medium-4 snow-license">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="snow-license-title">',
	'after_title' => '</h1>'
));

register_sidebar( array(
	'name' => __( 'Contact Information', 'contact' ),
	'id' => 'contact',
	'before_widget' => '<div id="snow-contact" class="small-12 medium-4 snow-contact">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="snow-contact-title">',
	'after_title' => '</h1>'
));

register_sidebar( array(
	'name' => __( 'Partners', 'partners' ),
	'id' => 'partners',
	'before_widget' => '<div id="snow-partners" class="small-12 medium-4 snow-partners">',
	'after_widget' => '</div>',
	'before_title' => '<h1 class="snow-partners-title">',
	'after_title' => '</h1>'
));
/* End footer widgets */


/* Begin extending widget for Upcoming Workshops front panel */
function snow_front_panel_sticky( $atts = array() ) { 
 
 	/* Default Parameters */
	extract(shortcode_atts(array(
	  'category__and' => 7,
	  'posts_per_page' => 1,
	  'post__in' => get_option( 'sticky_posts' ),
	  'ignore_sticky_posts' => 1
	), $atts));
	 
	/* Query the posts */
	$the_query = new WP_Query($atts);
	if ( $the_query->have_posts() ) {
	    while ( $the_query->have_posts() ) {
	        $the_query->the_post();
	        $return .= '<p><a href="' .get_permalink(). '" title="'  . get_the_title() . '">' . get_the_title() . '</a></p>' . '<p>' . get_the_excerpt() . '</p>';
	    }
     
	} else {
	    // No posts found
	}

	/* Restore original Post Data */
	wp_reset_postdata();
	 
	return $return; 
} 
add_shortcode('snow_front_panel_sticky', 'snow_front_panel_sticky');


class snow_panel_widget extends WP_Widget {

	public $title;
	public $category;

	/* Set up the widget name and description */
	public function __construct( $id, $title, $category ) {
		$widget_options = array();
		$this->title = $title;
		$this->category = $category;
		parent::__construct( $id, $title, $widget_options );
	}    

	/* Create the widget output */
	public function widget( $args ) {

	    echo $args['before_widget'] . $args['before_title'] . $this->title . $args['after_title']; ?>
	   	<div class="snow-widget">
	 		<?php echo do_shortcode('[snow_front_panel_sticky category__and=' . $this->category . ']'); ?>
	    </div>
	    <?php echo $args['after_widget'];
	}

}

function snow_upcoming_workshops() { 
  register_widget( new snow_panel_widget('snow_upcoming_workshops','Upcoming Workshops','7'));
}
add_action('widgets_init', 'snow_upcoming_workshops');


function snow_feature_article() { 
	register_widget( new snow_panel_widget('snow_feature_article','Feature Article','9'));
}
add_action('widgets_init', 'snow_feature_article');


function snow_featured_content() { 
	register_widget( new snow_panel_widget('snow_featured_content','Featured Content','10'));
}
add_action('widgets_init', 'snow_featured_content');

/* Enable shortcodes */
add_filter('widget_text', 'do_shortcode');

?>


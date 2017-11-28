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

register_sidebar( array(
	'name' => __( 'Snow Home', 'snow' ),
	'id' => 'snow-home',
	'before_widget' => '<div id="snow-home" class="snow-home">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="snow-title">',
	'after_title' => '</h3>'
));

register_sidebar( array(
	'name' => __( 'Accessing the Site', 'access' ),
	'id' => 'access-site',
	'before_widget' => '<div id="snow-access" class="snow-access">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="snow-access-title">',
	'after_title' => '</h3>'
));

register_sidebar( array(
	'name' => __( 'Experiences', 'experiences' ),
	'id' => 'snow-experiences',
	'before_widget' => '<div id="snow-experiences" class="snow-experiences">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="snow-experiences-title">',
	'after_title' => '</h3>'
));

?>

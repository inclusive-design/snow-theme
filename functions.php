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


/* Centralised array for registering widgets and sidebars (post and page) on the SNOW webpage */
$snow_widgets = array(
    'snow-home' => array(
        'name' => __( 'Snow Home', 'snow' ),
        'id' => 'snow-home',
        'before_widget' => '<div id="snow-home" class="snow-home">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="snow-title">',
        'after_title' => '</h2>'
    ),
    'access-site' => array(
        'name' => __( 'Accessing the Site', 'access' ),
        'id' => 'access-site',
        'before_widget' => '<div id="snow-access" class="snow-access">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="snow-access-title">',
        'after_title' => '</h2>'
    ),
    'snow-prefooter' => array(
        'name' => __( 'Prefooter', 'snow-prefooter' ),
        'id' => 'snow-prefooter',
        'before_widget' => '<div id="snow-prefooter" class="snow-prefooter">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="snow-prefooter-title">',
        'after_title' => '</h2>'
    ),
    'social-feeds' => array(
        'name' => __( 'Social Feeds', 'social-feeds' ),
        'id' => 'social-feeds',
        'before_widget' => '<div id="social-feeds" class="snow-prefooter">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="snow-prefooter-title">',
        'after_title' => '</h2>'
    ),
    'license-info' => array(
        'name' => __( 'License Information', 'license-info' ),
        'id' => 'license-info',
        'before_widget' => '<div id="snow-license" class="small-12 medium-4 snow-license">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ),
    'contact' => array(
        'name' => __( 'Contact Information', 'contact' ),
        'id' => 'contact',
        'before_widget' => '<div id="snow-contact" class="small-12 medium-4 snow-contact">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ),
    'partners' => array(
        'name' => __( 'Partners', 'partners' ),
        'id' => 'partners',
        'before_widget' => '<div id="snow-partners" class="small-12 medium-4 snow-partners">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ),
    'menu' => array(
        'name' => __( 'Second Menu', 'second-menu' ),
        'id' => 'second-menu',
        'before_widget' => '<div class="a11y-main-nav-items second-menu">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => ''
    ),
    'post',
    'page'
);

/* Register post/page sidebars */
foreach ($snow_widgets as $value) {
    register_sidebar($value);
}


/* Begin extending widget for front panels */
function snow_front_panel_sticky( $atts = array() ) {
    /* Default Parameters */
    $myatts = array(
        'post__in'  => get_option( 'sticky_posts' ),
        'posts_per_page' => 1
    );
    /* Merge category__and with the above parameters */
    $allatts = array_merge($atts, $myatts);

    /* Query the posts */
    $the_query = new WP_Query($allatts);
    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $return .= '<p><a href="' .get_permalink(). '" title="' . get_the_title() . '">' . get_the_title() . '</a></p>' . '<p>' . get_the_excerpt() . '</p>';
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
            <?php echo do_shortcode('[snow_front_panel_sticky cat=' . $this->category . ']'); ?>
        </div>
        <?php echo $args['after_widget'];
    }
}

/* Centralised array for the SNOW panel information */
$snow_panels = array(
    'snow_upcoming_workshops' => array(
        'id' => 'snow_upcoming_workshops',
        'title' => 'Upcoming Workshops',
        'category' => '8'
    ),
    'snow_feature_article' => array(
        'id' => 'snow_feature_article',
        'title' => 'Feature Article',
        'category' => '22'
    ),
    'snow_featured_content' => array(
        'id' => 'snow_featured_content',
        'title' => 'Featured Content',
        'category' => '23'
    )
);

/* Register and initialise all panels in $snow_panels */
foreach ($snow_panels as $panel) {
    $new_widget = new snow_panel_widget($panel['id'], $panel['title'], $panel['category']);
    $register_panel = function() use ($new_widget) {
        register_widget( $new_widget );
    };
    add_action('widgets_init', $register_panel);
}

/* Enable shortcodes */
add_filter('widget_text', 'do_shortcode');

/* Create sidebar menus for posts or pages */
function create_sidebar($post_type) {
    $output = '';
    $current_displayed_id = get_the_ID ();

    // Get all immediate child pages.
    $pages = get_pages (array (
        'parent'=> $current_displayed_id,
        'sort_column' => 'menu_order'
    ));

    // Get the immediate parent
    $parent_id = wp_get_post_parent_id($current_displayed_id);

    if ($pages && $parent_id) {
        // If somewhere in the middle of a Pages branch (there are parent and children Pages)
        // then show a link back to the immediate parent, and links to immediate children.
        $output .= '<ul>';
        $output .= '<li><a href="'. get_permalink($parent_id).'">Back to: '.get_post ($parent_id)->post_title.'</a></li>';
        $output .= '<li><ul>';
        $output .= '<li>'.get_the_ID ().'<a href="'. get_page_link() .'" class="a11y-sidebar-current" aria-current="page">'. get_the_title() .'</a></li>';
        $output .= '<li><ul>';
        foreach ( $pages as $page ) {
            $output.= '<li><a href="'.get_page_link ($page->ID).'">'.$page->post_title.'</a></li>';
        }
        $output .= '</ul></li></ul></li></ul>';
    } else if ($pages) {
        // If at the top of the Pages tree (there is no parent), then list all the immediate children.
        $output .= '<ul>';
        $output .= '<li>'.get_the_ID ().'<a href="'. get_page_link() .'" class="a11y-sidebar-current" aria-current="page">'. get_the_title() .'</a></li>';
        $output .= '<li><ul>';
        foreach ( $pages as $page ) {
            $output.= '<li><a href="'.get_page_link ($page->ID).'">'.$page->post_title.'</a></li>';
        }
        $output .= '</ul></li></ul>';
    } else if ($parent_id) {
        // If at the end of a Pages branch (there is parent but no more children),
        // then show a link back to immediate parent, and the current page.
        $output .= '<ul>';
        $output .= '<li><a href="'. get_permalink($parent_id).'">Back to: '.get_post ($parent_id)->post_title.'</a></li>';
        $output .= '<li><ul>';
        $output .= '<li>'.get_the_ID ().'<a href="'. get_page_link() .'" class="a11y-sidebar-current" aria-current="page">'. get_the_title() .'</a></li>';
        $output .= '</ul></li></ul>';
    }
    echo $output;
}

// Find out what is the post/page's main category and turn on menu indicator for that category
function make_current_menu_item( $classes, $item ) {

    if (in_array('current-post-ancestor', $classes) || in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes) ) {
        $classes[] = 'current-menu-item';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'make_current_menu_item', 10, 2 );


// Add tag and category support to pages
function allow_pages_tags_categories() {
    $taxonomy = array(
        "post_tag",
        "category"
    );
    foreach ($taxonomy as $value) {
        register_taxonomy_for_object_type($value, 'page');
    }
}
add_action('init', 'allow_pages_tags_categories');

// Ensure all tags and categories are included in queries
function add_queries_tags_categories($wp_query) {
    $query_parameters = array(
        "tag",
        "category_name"
    );
    foreach ($query_parameters as $value) {
        if ($wp_query->get($value))
            $wp_query->set('post_type', 'any');
    }
}
add_action('pre_get_posts', 'add_queries_tags_categories');

// Breadcrumbs
// Modified from https://www.thewebtaylor.com/articles/wordpress-creating-breadcrumbs-without-a-plugin
function custom_breadcrumbs() {

    wp_reset_query();

    // Settings
    $breadcrumbs_class   = 'breadcrumbs';
    $output = '';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrums
        $output .= '<nav aria-label="breadcrumb">';
        $output .= '<ul class="' . $breadcrumbs_class . '">';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            $output .= '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                $output .= '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
            }

        } else if ( is_single() ) {

            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                $output .= '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // If there is a parent category, get all possible parents.
                if ($last_category->category_parent > 0){
                    $output .= '<li>';

                    // Get a string of parents as links, each separated by </li><li>.
                    $parent_cats = get_category_parents($last_category->term_id, true, '</li><li>');

                    // Trim off the last '<li>' from the output so last list item closes properly.
                    $output .= substr ($parent_cats, 0, -(strlen('<li>')));
                }

                // The current item in the breadcrumb.
                $output .= '<li class="item-current" aria-current="page"><strong>' . get_the_title() . '</strong></li>';
            }
        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $output .= '<li><a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                }

                // Current page
                $output .= '<li class="item-current"><strong>' . get_the_title() . '</strong></li>';

            } 
        }

        $output .= '</ul></nav>';

        echo $output;
    }

}

?>

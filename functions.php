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
    'snow-experiences' => array(
        'name' => __( 'Experiences', 'experiences' ),
        'id' => 'snow-experiences',
        'before_widget' => '<div id="snow-experiences" class="snow-experiences">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="snow-experiences-title">',
        'after_title' => '</h2>'
    ),
    'license-info' => array(
        'name' => __( 'License Information', 'license-info' ),
        'id' => 'license-info',
        'before_widget' => '<div id="snow-license" class="small-12 medium-4 snow-license">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="a11y-site-footer">',
        'after_title' => '</h2>'
    ),
    'contact' => array(
        'name' => __( 'Contact Information', 'contact' ),
        'id' => 'contact',
        'before_widget' => '<div id="snow-contact" class="small-12 medium-4 snow-contact">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="a11y-site-footer">',
        'after_title' => '</h2>'
    ),
    'partners' => array(
        'name' => __( 'Partners', 'partners' ),
        'id' => 'partners',
        'before_widget' => '<div id="snow-partners" class="small-12 medium-4 snow-partners">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="a11y-site-footer">',
        'after_title' => '</h2>'
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
    $category_current = get_the_category();
    $category_link = get_term_link ($category_current[0]->slug, "category");
    $current_displayed_id = get_the_ID (); // the ID of the post currently displayed in the main content panel.

    if ( ! empty( $category_current ) ) {
        $args = array(
        // get posts belonging to the current category.
            'post_type' => $post_type,
            'category_name' => $category_current[0]->slug,
        );
        $sidebar_query = new WP_Query($args);

        if ($sidebar_query->have_posts()) :
            /*
            If there is more than 1 post in the current category,
            then the first item should be a link to the category.

            Otherwise if there's just 1 post, then it can be ignored as it
            will be the landing page already being shown.
            */
            if ($sidebar_query->found_posts > 1) :?>
                <ul>
                    <li><a href="<?php echo $category_link; ?>" class="a11y-sidebar-category-link
                <?php
                    if (! empty ($category_landing_id)) : ?>a11y-sidebar-current<?php endif;?>">
                    <?php
                    /*
                    if category_landing_id is not empty, then we are showing a
                    landing page. Therefore give it active styling.
                    */
                    echo $category_current[0]->name; ?></a></li>

                    <li>
                        <ul>
                        <?php
                        while ( $sidebar_query->have_posts() ) : $sidebar_query->the_post();
                        /*
                        Display all pages in the category as a list of links.
                        But if one of the pages is the landing page, we skip it
                        since it's already the first item in the list.
                        */

                        $is_landing_page = get_post_meta (get_the_ID(), 'is_landing_page', true);
                        if ( empty($is_landing_page) && (get_the_ID() != $category_landing_id)) :
                        // If the post isn't the landing page, show a link. Otherwise ignore it.
                        ?>
                        <li>
                            <a href="<?php the_permalink() ?>"
                            <?php if ($current_displayed_id == get_the_ID() && empty ($category_landing_id)) :
                            /*
                            Check the category_landing_id if it is set, then we're displaying the
                            landing page. So don't show the active styling for this item.
                            */
                            ?>
                                class="a11y-sidebar-current"
                                aria-current="page"
                            <?php endif;?>>
                            <?php the_title(); ?>
                                </a>
                            </li>
                            <?php
                            endif;
                        endwhile;?>
                        </ul>
                    </li>
                </ul>
                <?php
            endif;
        endif;
    }
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


?>

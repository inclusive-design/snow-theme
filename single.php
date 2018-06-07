<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package a11y
 */

get_header();
get_sidebar('post');
?>
    <main id="content" class="a11y-site-main columns">
    <div class="flc-toc-tocContainer"></div>

    <span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to %title%." href="%link%" class="%type%"><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>

    <?php
    while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/content', get_post_format() );

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>
    </main>
<?php
get_footer();

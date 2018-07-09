<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package big-idea
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.0/css/foundation-flex.min.css" />
    <?php wp_head(); ?>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.0/js/foundation.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>

</head>

<body <?php body_class(); ?>>
    <div class="row a11y-theme">
        <nav id="skip" class="small-12 columns">
            <a  href="#content"><?php esc_html_e( 'Skip to content', 'a11y' ); ?></a>
        </nav>

        <header class="small-12 a11y-site-header" role="banner">
            <?php
                $nav_menu = wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu', 'container' => '','echo' => false, 'items_wrap' => '%3$s' ) );
            ?>

            <div class="a11y-site-header small-12 columns">
                <div class="row snow-header">
                    <div class="small-12 large-8 a11y-site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"></a>
                    </div>
                    <div class="small-12 large-4 snow-search">
                        <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                            <input type="text" value="" name="s" id="search" /><button type="submit" id="searchsubmit">Search</button>
                        </form>
                    </div>
                </div>

                <nav class="a11y-main-nav">
                    <div class="title-bar float-right" data-responsive-toggle="site-menu" data-hide-for="medium">
                        <button class="menu-icon" type="button" data-toggle="site-menu"></button>
                    </div>
                    <div id="site-menu">
                        <div class="top-bar-left a11y-main-nav-items">
                            <ul class="dropdown menu" data-dropdown-menu>
                                <?php echo $nav_menu;
                                /*
                                Check that the Feedback Post plugin is installed.
                                If it is, then display a link to the Feedback Post
                                archive if the user has privledges to view it.
                                */
                                if (function_exists ('is_feedback_post_role')) {
                                    if (is_feedback_post_role(wp_get_current_user())) {
                                        echo '<li>'.get_feedback_post_archive_link().'</li>';
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php
                        $sections = array(
                            'second-menu' => array(
                                'section_class' => '',
                                'widgets' => array(
                                    'second-menu' => 'second-menu'
                                )
                            )
                        );
                        add_widgets($sections, 'section');
                    ?>
                </nav>
            </div>

        </header>

        <div class="a11y-site-main-container row small-12 columns">

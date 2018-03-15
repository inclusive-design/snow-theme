<?php
/**
 * @package big-idea
 */

$settings = (array) get_option ('a11y-theme-settings');
get_header(); ?>

    <main id="content" class="a11y-site-main small-12 columns">
        <div class="a11y-site-tagline">
            <h1><span>Welcome to</span><br /> <span class="a11y-tagline-emphasis">SNOW</span></h1>
        </div>

        <div class="snow-container">
            <div class="flc-toc-tocContainer"></div>
        </div>
        
        <?php

            $sections = array(
                'introduction' => array(
                    'section_class' => 'snow-intro',
                    'widgets' => array(
                        'home' => 'snow-home',
                        'access' => 'access-site'
                    )
                ),
                'panels' => array(
                    'section_class' => 'row a11y-panel-container',
                    'widgets' => array(
                        'panel1' => 'a11y-front-panel1',
                        'panel2' => 'a11y-front-panel2',
                        'panel3' => 'a11y-front-panel3',
                    )
                ),
                'experiences' => array(
                    'section_class' => '',
                    'widgets' => array(
                        'snow-experiences' => 'snow-experiences'
                    )
                )
            );
            add_widgets($sections, 'section');
        ?>

        <div class="row a11y-panel-container bi-social-feeds">
            <div class="small-12 medium-4 columns a11y-front-panel">
                <h2>Twitter</h2>
                <section>
                    <?php
                    // Shortcode for Custom Twitter Feeds plugin
                    // https://wordpress.org/plugins/custom-twitter-feeds/
                    echo do_shortcode("[custom-twitter-feeds]");
                    ?>
                </section>
            </div>
            <div class="small-12 medium-4 columns a11y-front-panel">
                <h2>Facebook</h2>
                <section>
                    <?php
                    // Shortcode for Custom Facebook Feed plugin
                    // https://wordpress.org/plugins/custom-facebook-feed/
                    echo do_shortcode("[custom-facebook-feed]");
                    ?>
                </section>
            </div>
            <div class="small-12 medium-4 columns a11y-front-panel">
                <h2>Instagram</h2>
                <section>
                    <?php
                    // Shortcode for Instagram Feed plugin
                    // https://wordpress.org/plugins/instagram-feed/
                    echo do_shortcode("[instagram-feed]");
                    ?>
                </section>
            </div>
        </section>

    </main>

<?php
get_footer();

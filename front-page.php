<?php
/**
 * @package big-idea
 */

$settings = (array) get_option ('a11y-theme-settings');
get_header(); ?>

    <main id="content" class="a11y-site-main small-12 columns">
        <div class="a11y-site-tagline">
            <p><span>Welcome to</span><br /> <span class="snow">SNOW</span></p>
            </span>
        </div>
        <section class="row a11y-panel-container">
            <?php
                $panels = array (
                    esc_attr($settings['panel_1_id']) => esc_url($settings['panel_1_link']),
                    esc_attr($settings['panel_2_id']) => esc_url($settings['panel_2_link']),
                    esc_attr($settings['panel_3_id']) => esc_url($settings['panel_3_link'])
                );
                foreach ($panels as $key => $panel_link) {
            ?>

                <a href="<?php echo $panel_link; ?>" class="small-12 medium-4 columns a11y-front-panel">
                <article >

                        <?php
                            $post_content = get_post($key);
                            $thumbnail = get_the_post_thumbnail($key,'',array( 'role' => 'presentation'));
                            $title = $post_content->post_title;
                            $content = $post_content->post_content;
                        ?>

                        <header class="a11y-entry-header">
                            <?php echo $thumbnail ?>
                            <h1><?php echo $title ?></h1>
                        </header>
                        <section>
                            <?php
                                echo apply_filters('the_content',$content);
                            ?>
                        </section>

                </article>
            </a>
            <?php
        }//foreach
            ?>
        </section>

        <section class="row a11y-panel-container bi-social-feeds">
            <article class="small-12 medium-4 columns a11y-front-panel">
                <header class="a11y-entry-header">
                    <h1>Twitter</h1>
                </header>
                <section>
                    <?php
                    // Shortcode for Custom Twitter Feeds plugin
                    // https://wordpress.org/plugins/custom-twitter-feeds/
                    echo do_shortcode("[custom-twitter-feeds]");
                    ?>
                </section>
            </article>
            <article class="small-12 medium-4 columns a11y-front-panel">
                <header class="a11y-entry-header">
                    <h1>Facebook</h1>
                </header>
                <section>
                    <?php
                    // Shortcode for Facebook Feed WD plugin
                    // https://wordpress.org/plugins/wd-facebook-feed/
                    echo do_shortcode("[WD_FB id='1']");
                    ?>
                </section>

            </article>
            <article class="small-12 medium-4 columns a11y-front-panel">
                <header class="a11y-entry-header">
                    <h1>Instagram</h1>
                </header>
                <section>
                    <?php
                    // Shortcode for Instagram Feed plugin
                    // https://wordpress.org/plugins/instagram-feed/
                    echo do_shortcode("[instagram-feed]");
                    ?>
                </section>

            </article>
        </section>
    </main>

<?php
get_footer();

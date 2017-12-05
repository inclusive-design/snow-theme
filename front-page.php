<?php
/**
 * @package big-idea
 */

$settings = (array) get_option ('a11y-theme-settings');
get_header(); ?>

    <main id="content" class="a11y-site-main small-12 columns">
        <div class="a11y-site-tagline">
            <p><span>Welcome to</span><br /> <span class="a11y-tagline-emphasis">SNOW</span></p>
            </span>
        </div>
        
        <div class="snow-intro">
            <?php
                if (is_active_sidebar('snow-home')) {
                    dynamic_sidebar('snow-home');
                }
            ?>

            <?php
                if (is_active_sidebar('access-site')) {
                    dynamic_sidebar('access-site');
                }
            ?>
        </div>
        
       <section class="row a11y-panel-container">
            
            <?php
                if (is_active_sidebar('a11y-front-panel1')) {
                    dynamic_sidebar('a11y-front-panel1');
                }
            ?>

            <?php
                if (is_active_sidebar('a11y-front-panel2')) {
                    dynamic_sidebar('a11y-front-panel2');
                }
            ?>

            <?php
                if (is_active_sidebar('a11y-front-panel3')) {
                    dynamic_sidebar('a11y-front-panel3');
                }
            ?>
        </section>
        <section>
            <?php
                if (is_active_sidebar('snow-experiences')) {
                    dynamic_sidebar('snow-experiences');
                }
            ?>
        </section>

    </main>

<?php
get_footer();

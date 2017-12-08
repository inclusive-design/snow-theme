<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package a11y
 */

?>

    </div>

    <footer class="row a11y-site-footer" role="contentinfo">
        <?php
            if (is_active_sidebar('license-info')) {
                dynamic_sidebar('license-info');
            }
        ?>

        <?php
            if (is_active_sidebar('contact')) {
                dynamic_sidebar('contact');
            }
        ?>

        <?php
            if (is_active_sidebar('partners')) {
                dynamic_sidebar('partners');
            }
        ?>
    </footer>
</div>

<?php wp_footer(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).foundation();
    });
</script>
</body>
</html>

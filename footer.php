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

    <?php
        $sections = array(
            'experiences' => array(
                'section_class' => '',
                'widgets' => array(
                    'snow-experiences' => 'snow-experiences',
                    'social-feeds' => 'social-feeds'
                )
            ),
            'footer' => array(
                'section_class' => 'row a11y-site-footer',
                'widgets' => array(
                    'license-info' => 'license-info',
                    'contact' => 'contact',
                    'partners' => 'partners'
                )
            )
        );

        add_widgets($sections, 'footer');
    ?>

    <footer class="a11y-site-footer">
        Snow is a project of the Inclusive Design Research Centre, OCAD University, funded by Provincial Schools Branch, Ontario Ministry of Education.
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

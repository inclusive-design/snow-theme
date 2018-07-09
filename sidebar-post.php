<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package a11y
 */

global $category_landing_id;
?>

<aside class="a11y-site-aside small-12 medium-4 columns" role="complementary">
    <?php
        create_sidebar('post');
    ?>
</aside>

<nav class="content-left-side">
    <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) :
		query_posts('');
		if (have_posts()) :
		?>
        <h2 class="block-title">Videos</h2>
		<ul>
		<?php
		   while (have_posts()) :
		      the_post(); ?>
		<li>
		      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
		</li>
		<?php
			endwhile;
		endif;
		wp_reset_query();
		?>
		</ul>

    <?php endif; // end sidebar widget area ?>
</nav>

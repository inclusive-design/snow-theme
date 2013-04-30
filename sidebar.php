<nav class="content-left-side">
    <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
        <h2 class="block-title">Videos</h2>
		<ul>
		<?php
		global $post;
		$args = array( 'orderby'  => 'post_date' );
		$myposts = get_posts( $args );
		foreach( $myposts as $post ) :	setup_postdata($post);
		?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
		<?php endforeach; ?>
		</ul>

    <?php endif; // end sidebar widget area ?>
</nav>

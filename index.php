<?php get_header(); ?>

<div class="fl-centered fl-col-mixed fl-site-wrapper">
	<div class="fl-col-fixed fl-force-left">
		<?php get_sidebar(); ?>
	</div>

    <div class="video-content fl-col-flex">
        <?php if(have_posts()) : ?>
        	<?php while(have_posts()) : the_post(); ?>
		        <article class="post">
		    	    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
		            <div class="entry">
		                <?php the_content("<div class='fl-site-read-more'>read more</div>"); ?>                
		            </div>
		        </article>
			<?php endwhile; ?> 
        <?php endif; ?>
    </div>

</div>
<?php get_footer(); ?>
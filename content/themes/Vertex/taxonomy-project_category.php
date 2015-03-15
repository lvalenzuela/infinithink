<?php get_header(); ?>

<div id="content-area">
	<section class="home-block">
		<div class="container">
		<?php if ( have_posts() ) : ?>
			<ul id="et-projects" class="clearfix">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'includes/entry_project' ); ?>
				<?php endwhile; ?>
			</ul>
	<?php
			if ( function_exists( 'wp_pagenavi' ) ) wp_pagenavi();
			else get_template_part( 'includes/navigation', 'archive_project' );
		else:
			get_template_part( 'includes/no-results','archive_project' );
		endif;
	?>
		</div>
	</section>
</div>

<?php get_footer(); ?>
<?php get_header(); ?>

<div id="content-area">
	<div class="container clearfix">
		<div id="main-area">

<?php while ( have_posts() ) : the_post(); ?>
	<?php if (et_get_option('vertex_integration_single_top') <> '' && et_get_option('vertex_integrate_singletop_enable') == 'on') echo(et_get_option('vertex_integration_single_top')); ?>

	<article class="entry clearfix">
	<?php
		the_content();

		wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Vertex' ), 'after' => '</div>' ) );
	?>
	<?php
		if ( et_get_option('vertex_468_enable') == 'on' ){
			if ( et_get_option('vertex_468_adsense') <> '' ) echo( et_get_option('vertex_468_adsense') );
			else { ?>
				<a href="<?php echo esc_url(et_get_option('vertex_468_url')); ?>"><img src="<?php echo esc_attr(et_get_option('vertex_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
	<?php 	}
		}
	?>
	</article> <!-- .entry -->

	<?php if (et_get_option('vertex_integration_single_bottom') <> '' && et_get_option('vertex_integrate_singlebottom_enable') == 'on') echo(et_get_option('vertex_integration_single_bottom')); ?>

	<?php
		if ( comments_open() && 'on' == et_get_option( 'vertex_show_postcomments', 'on' ) )
			comments_template( '', true );
	?>
<?php endwhile; ?>

		</div> <!-- #main-area -->

		<?php get_sidebar(); ?>
	</div> <!-- .container -->
</div> <!-- #content-area -->

<?php get_footer(); ?>
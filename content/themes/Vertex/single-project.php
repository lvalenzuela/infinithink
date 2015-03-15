<?php get_header(); ?>

<div id="content-area">
	<div class="container clearfix fullwidth">
		<div id="main-area">

<?php while ( have_posts() ) : the_post(); ?>
	<article class="entry clearfix">
	<?php
		$thumb = '';
		$width = (int) apply_filters( 'et_single_project_image_width', 9999 );
		$height = (int) apply_filters( 'et_single_project_image_height', 9999 );
		$classtext = 'et-main-project-thumb';
		$titletext = get_the_title();
		$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'SingleProject' );
		$thumb = $thumbnail["thumb"];

		print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext );

		the_content();

		et_gallery_images();

		wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Vertex' ), 'after' => '</div>' ) );
	?>
	</article> <!-- .entry -->

	<?php
		if ( comments_open() && 'on' == et_get_option( 'vertex_show_postcomments', 'on' ) )
			comments_template( '', true );
	?>
<?php endwhile; ?>

		</div> <!-- #main-area -->

	</div> <!-- .container -->
</div> <!-- #content-area -->

<?php get_footer(); ?>
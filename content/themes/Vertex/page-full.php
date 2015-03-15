<?php
/*
Template Name: Full Width Page
*/
?>
<?php get_header(); ?>

<div id="content-area">
	<div class="container clearfix fullwidth">
		<div id="main-area">
<?php while ( have_posts() ) : the_post(); ?>

	<article class="entry clearfix">
	<?php
		the_content();

		wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Vertex' ), 'after' => '</div>' ) );
	?>
	</article> <!-- .entry -->

<?php
	if ( comments_open() && 'on' == et_get_option( 'vertex_show_pagescomments', 'false' ) )
		comments_template( '', true );
?>

<?php endwhile; ?>

		</div> <!-- #main-area -->
	</div> <!-- .container -->
</div> <!-- #content-area -->

<?php get_footer(); ?>
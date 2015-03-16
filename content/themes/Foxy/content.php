<?php
/**
 * The template for displaying posts on single pages
 *
 */
?>

<?php
	$postinfo = et_get_option( 'foxy_postinfo2' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>
	<div class="entry-content">
		<div class="post-heading">
			<h1><?php the_title(); ?></h1>
		<?php
			if ( $postinfo && ! is_page() ) {
				echo '<p class="meta-info">';
				et_postinfo_meta( $postinfo, et_get_option( 'foxy_date_format', 'M j, Y' ), esc_html__( '0 comments', 'Foxy' ), esc_html__( '1 comment', 'Foxy' ), '% ' . esc_html__( 'comments', 'Foxy' ) );
				echo '</p>';
			}
		?>
		</div> <!-- .post-heading -->
	<?php
		the_content();
		wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Foxy' ), 'after' => '</div>' ) );
	?>
	</div> <!-- .entry-content -->
</article> <!-- end .entry-post-->
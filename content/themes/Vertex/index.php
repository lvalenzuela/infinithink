<?php get_header(); ?>

<div id="content-area">
	<div class="container clearfix">
		<div id="main-area">
<?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		$thumb = '';
		$width = (int) apply_filters( 'et_index_image_width', 640 );
		$height = (int) apply_filters( 'et_index_image_height', 280 );
		$classtext = '';
		$titletext = get_the_title();
		$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
		$thumb = $thumbnail["thumb"];
?>
			<article class="entry clearfix<?php if ( '' === $thumb ) echo ' et-no-image'; ?>">
			<?php if ( '' !== $thumb ) : ?>
				<div class="thumbnail">
					<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext ); ?>

					<div class="description">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<br />
						<?php et_vertex_post_meta(); ?>
					</div>

				<?php if ( ( $author_avatar = get_avatar( get_the_author_meta( 'ID' ), 60 ) ) && 'on' == et_get_option( 'vertex_show_avatar_on_posts', 'on' ) && '' != $author_avatar ) : ?>
					<div class="member-image small">
						<?php echo $author_avatar; ?>
					</div>
				<?php endif; ?>
				</div>
			<?php else : ?>
				<div class="alt-description">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<br />
					<?php et_vertex_post_meta(); ?>
				</div>
			<?php endif; ?>

			<?php
				if ( 'on' === et_get_option( 'vertex_blog_style', 'false' ) )
					the_content('');
				else
					echo '<p>' . truncate_post( 440, false ) . '</p>';
			?>
				<a class="read-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'Vertex' ); ?></a>
			</article> <!-- .entry -->
<?php
	endwhile;

	if ( function_exists( 'wp_pagenavi' ) )
		wp_pagenavi();
	else
		get_template_part( 'includes/navigation', 'index' );
else :
	get_template_part( 'includes/no-results', 'index' );
endif;
?>
		</div> <!-- #main-area -->

		<?php get_sidebar(); ?>
	</div> <!-- .container -->
</div> <!-- #content-area -->

<?php get_footer(); ?>
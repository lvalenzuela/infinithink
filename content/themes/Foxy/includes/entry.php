<?php
	$index_postinfo = et_get_option( 'foxy_postinfo1' );

	$thumb = '';
	$width = (int) apply_filters( 'et_blog_image_width', 720 );
	$height = (int) apply_filters( 'et_blog_image_height', 320 );
	$classtext = '';
	$titletext = get_the_title();
	$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Indeximage' );
	$thumb = $thumbnail["thumb"];
?>
<article class="entry-post clearfix">

<?php if ( 'on' == et_get_option( 'foxy_thumbnails_index', 'on' ) && '' != $thumb ) { ?>
	<div class="post-thumbnail">
		<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext ); ?>

		<div class="post-description">
		<?php if ( ( $author_avatar = get_avatar( get_the_author_meta( 'ID' ), 62 ) ) && 'on' == et_get_option( 'foxy_show_avatar_on_posts', 'on' ) && '' != $author_avatar ) : ?>
			<div class="testimonial-author">
				<span class="et-avatar"><?php echo $author_avatar; ?></span>
			</div> <!-- .testimonial-author -->
		<?php endif; ?>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		</div> <!-- .post-description -->
	</div> <!-- .post-thumbnail -->
<?php } else { ?>
	<div class="post-description">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</div> <!-- .post-description -->
<?php } ?>

<?php
	if ( $index_postinfo ) {
		echo '<p class="meta-info">';
		et_postinfo_meta( $index_postinfo, et_get_option( 'foxy_date_format', 'M j, Y' ), esc_html__( '0 comments', 'Foxy' ), esc_html__( '1 comment', 'Foxy' ), '% ' . esc_html__( 'comments', 'Foxy' ) );
		echo '</p>';
	}
?>
<?php if ( 'false' == et_get_option( 'foxy_blog_style', 'false' ) ) { ?>
	<p><?php truncate_post( 370 ); ?></p>
<?php } else { ?>
	<?php the_content( '' ); ?>
<?php } ?>

	<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e( 'Read More', 'Foxy' ); ?></a>

</article> <!-- .entry-post -->
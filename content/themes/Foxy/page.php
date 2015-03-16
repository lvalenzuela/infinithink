<?php get_header(); ?>

<?php get_template_part( 'includes/breadcrumbs', 'page' ); ?>

<?php
	$thumb = '';

	$width = (int) apply_filters( 'et_blog_image_width', 1280 );
	$height = (int) apply_filters( 'et_blog_image_height', 420 );

	$classtext = '';
	$titletext = get_the_title();
	$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Singleimage' );
	$thumb = $thumbnail["thumb"];

	$show_thumb = et_get_option( 'foxy_page_thumbnails', 'false' );
?>
<?php if ( 'on' == $show_thumb && '' != $thumb ) : ?>
	<div class="post-thumbnail">
		<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext ); ?>
	</div> <!-- .post-thumbnail -->
<?php endif; ?>

<div id="content" class="clearfix">
	<div id="left-area"<?php if ( 'on' == $show_thumb && '' != $thumb ) echo ' class="et_full_width_image"'; ?>>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

		<?php
			if ( comments_open() && 'on' == et_get_option( 'foxy_show_pagescomments', 'false' ) )
				comments_template( '', true );
		?>

		<?php endwhile; ?>

	</div> <!-- #left-area -->

	<?php get_sidebar(); ?>
</div> <!-- #content -->

<?php get_footer(); ?>
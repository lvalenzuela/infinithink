<?php get_header(); ?>

<?php $et_full_post = 'on' == get_post_meta( get_the_ID(), '_et_full_post', true ) ? true : false; ?>

<?php get_template_part( 'includes/breadcrumbs', 'single' ); ?>

<?php
	$thumb = '';

	$width = (int) apply_filters( 'et_blog_image_width', 1280 );
	$height = (int) apply_filters( 'et_blog_image_height', 420 );

	$classtext = '';
	$titletext = get_the_title();
	$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Singleimage' );
	$thumb = $thumbnail["thumb"];

	$show_thumb = et_get_option( 'foxy_thumbnails', 'on' );
?>
<?php if ( 'on' == $show_thumb && '' != $thumb ) : ?>
	<div class="post-thumbnail">
		<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext ); ?>
	</div> <!-- .post-thumbnail -->
<?php endif; ?>

	<div id="content" class="clearfix<?php if ( $et_full_post ) echo ' fullwidth'; ?>">
		<div id="left-area"<?php if ( 'on' == $show_thumb && '' != $thumb ) echo ' class="et_full_width_image"'; ?>>
			<?php if (et_get_option('foxy_integration_single_top') <> '' && et_get_option('foxy_integrate_singletop_enable') == 'on') echo (et_get_option('foxy_integration_single_top')); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<?php
					if ( comments_open() && 'on' == et_get_option( 'foxy_show_postcomments', 'on' ) )
						comments_template( '', true );
				?>

			<?php endwhile; ?>

			<?php if (et_get_option('foxy_integration_single_bottom') <> '' && et_get_option('foxy_integrate_singlebottom_enable') == 'on') echo(et_get_option('foxy_integration_single_bottom')); ?>

			<?php
				if ( et_get_option('foxy_468_enable') == 'on' ){
					if ( et_get_option('foxy_468_adsense') <> '' ) echo( et_get_option('foxy_468_adsense') );
					else { ?>
					   <a href="<?php echo esc_url(et_get_option('foxy_468_url')); ?>"><img src="<?php echo esc_attr(et_get_option('foxy_468_image')); ?>" alt="468 ad" class="foursixeight" /></a>
			<?php 	}
				}
			?>
		</div> <!-- #left-area -->

		<?php if ( ! $et_full_post ) get_sidebar(); ?>
	</div> <!-- #content -->

<?php get_footer(); ?>
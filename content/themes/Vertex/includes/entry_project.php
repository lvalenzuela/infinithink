<li>
<?php
	$thumb = '';
	$width = (int) apply_filters( 'et_project_image_width', 240 );
	$height = (int) apply_filters( 'et_project_image_height', 240 );
	$classtext = '';
	$titletext = get_the_title();
	$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Indeximage' );
	$thumb = $thumbnail["thumb"];

	print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext );
?>
	<div class="project-description">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<p class="meta-info"><?php echo get_the_time( et_get_option( 'vertex_date_format', 'M j, Y' ) ); ?></p>
		<a href="<?php the_permalink(); ?>" class="et-zoom"><?php esc_html_e( 'Read more', 'Vertex' ); ?></a>
	</div>
</li>
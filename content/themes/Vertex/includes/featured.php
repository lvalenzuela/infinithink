<?php
	$featured_slider_class = '';
	if ( 'on' === et_get_option( 'vertex_slider_auto', 'false' ) ) $featured_slider_class = ' et_slider_auto et_slider_speed_' . et_get_option( 'vertex_slider_autospeed', '7000' );
?>
<div id="slider"<?php if ( '' != $featured_slider_class ) printf( ' class="%s"', esc_attr( $featured_slider_class ) ); ?>>
	<div id="et-slides" class="clearfix">
<?php
	$featured_cat = et_get_option( 'vertex_feat_cat' );
	$featured_num = (int) et_get_option( 'vertex_featured_num' );

	if ( 'false' === et_get_option( 'vertex_use_pages', 'false' ) ) {
		$featured_query = new WP_Query( apply_filters( 'et_featured_post_args', array(
			'posts_per_page' => intval( $featured_num ),
			'cat'            => (int) get_catId( et_get_option('vertex_feat_posts_cat') ),
		) ) );
	} else {
		global $pages_number;

		$featured_num = '' !== et_get_option( 'vertex_feat_pages' )
			? count( et_get_option( 'vertex_feat_pages' ) )
			: $pages_number;

		$et_featured_pages_args = array(
			'post_type'      => 'page',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'posts_per_page' => (int) $featured_num,
		);

		if ( is_array( et_get_option( 'vertex_feat_pages', '', 'page' ) ) )
			$et_featured_pages_args['post__in'] = (array) array_map( 'intval', et_get_option( 'vertex_feat_pages', '', 'page' ) );

		$featured_query = new WP_Query( apply_filters( 'et_featured_page_args', $et_featured_pages_args ) );
	}

	while ( $featured_query->have_posts() ) : $featured_query->the_post();
		$post_id = get_the_ID();

		$slide_more_link = get_post_meta( $post_id, '_et_slide_more_link', true );
		$more_link = '' != $slide_more_link ? $slide_more_link : get_permalink();

		$width = (int) apply_filters( 'et_slider_image_width', 539 );
		$height = (int) apply_filters( 'et_slider_image_height', 480 );
		$title = get_the_title();
		$thumbnail = get_thumbnail( $width, $height, '', $title, $title, false, 'Featured' );
		$thumb = $thumbnail["thumb"];
?>
		<div class="et-slide">
			<a href="<?php echo esc_url( $more_link ); ?>">
				<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $title, $width, $height, 'et-main-image' ); ?>
			</a>

			<div class="et-description">
				<h2><a href="<?php echo esc_url( $more_link ); ?>"><?php the_title(); ?></a></h2>
				<p><?php truncate_post( 170 ); ?></p>
				<a class="more" href="<?php echo esc_url( $more_link ); ?>"><?php esc_html_e( 'More Information', 'Vertex' ); ?></a>
			</div>
		</div>
<?php
	endwhile;
	wp_reset_postdata();
?>
	</div> <!-- #et-slides -->
</div> <!-- #slider -->
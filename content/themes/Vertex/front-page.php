<?php
if ( is_front_page() && is_page() ) {
	include( get_page_template() );
	return;
}

if ( 'on' === et_get_option( 'vertex_blog_style', 'false' ) ) {
	get_template_part( 'index' );
	return;
}
?>

<?php get_header(); ?>

<?php
if ( 'on' == et_get_option( 'vertex_show_projects', 'on' ) ) {
	$args = array(
		'post_type'      => 'project',
		'posts_per_page' => (int) et_get_option( 'vertex_home_projects_num', 8 ),
	);
	$et_projects_query = new WP_Query( apply_filters( 'et_home_projects_query_args', $args ) );

	if ( $et_projects_query->have_posts() ) : ?>
<section class="home-block et-odd">
	<div class="container">
		<header>
			<h1><?php echo esc_html( et_get_option( 'vertex_home_projects_title', __( 'Our Recent Client Projects', 'Vertex' ) ) ); ?></h1>
			<h2><?php echo esc_html( et_get_option( 'vertex_home_projects_description', __( 'Take a look at some of the most recent work that our team has created.', 'Vertex' ) ) ); ?></h2>
		</header>

		<ul id="et-projects" class="clearfix">
		<?php while ( $et_projects_query->have_posts() ) : $et_projects_query->the_post(); ?>
			<?php get_template_part( 'includes/entry_project' ); ?>
		<?php endwhile; ?>
		</ul>
	</div> <!-- .container -->
</section>
<?php
	endif;
	wp_reset_postdata();
}
?>

<?php if ( 'on' === et_get_option( 'vertex_featured', 'on' ) ) { ?>
<section class="home-block et-even et-slider-area">
	<div class="container">
		<header>
			<h1><?php echo esc_html( et_get_option( 'vertex_home_featured_title', __( 'Advanced Online Solutions', 'Vertex' ) ) ); ?></h1>
			<h2><?php echo esc_html( et_get_option( 'vertex_home_featured_description', __( 'Our service comes packed to the brim with tons of amazing features.', 'Vertex' ) ) ); ?></h2>
		</header>

		<?php get_template_part( 'includes/featured' ); ?>
	</div> <!-- .container -->
</section>
<?php } ?>

<?php
if ( 'on' === et_get_option( 'vertex_show_testimonials', 'on' ) ) {
	$args = array(
		'post_type'      => 'testimonial',
		'posts_per_page' => -1,
	);
	$et_testimonials_query = new WP_Query( apply_filters( 'et_home_testimonials_query_args', $args ) );
	$i = 1;
	$testimonials_images = '';

	if ( $et_testimonials_query->have_posts() ) : ?>
<section class="home-block et-odd">
	<div class="container">
		<header>
			<h1><?php echo esc_html( et_get_option( 'vertex_home_testimonials_title', __( 'What Our Customers Are Saying', 'Vertex' ) ) ); ?></h1>
			<h2><?php echo esc_html( et_get_option( 'vertex_home_testimonials_description', __( 'Don\'t just take our word for it, take a look at what our customers have to say.', 'Vertex' ) ) ); ?></h2>
		</header>

		<div id="et-testimonials">
			<div id="all-testimonials">
			<?php while ( $et_testimonials_query->have_posts() ) : $et_testimonials_query->the_post(); ?>
				<div class="et-home-testimonial">
					<blockquote>
						<?php the_content(); ?>
					</blockquote>
				</div>

			<?php
				$thumb = '';
				$width = (int) apply_filters( 'et_testimonial_image_width', 96 );
				$height = (int) apply_filters( 'et_testimonial_image_height', 96 );
				$classtext = '';
				$titletext = get_the_title();
				$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Testimonialimage' );
				$thumb = $thumbnail["thumb"];

				ob_start();

				echo '<li' . ( 1 === $i ? ' class="active-testimonial"' : '' ) . '>';
				print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext );
				echo '</li>';

				$testimonials_images .= ob_get_clean();
				$i++;
			?>
			<?php endwhile; ?>
			</div> <!-- #all-testimonials -->

			<ul id="testimonials-authors" class="clearfix">
				<?php echo $testimonials_images; ?>
			</ul>
		</div> <!-- #et-testimonials -->
	</div> <!-- .container -->
</section>
<?php
	endif;
	wp_reset_postdata();
}
?>

<?php
if ( 'on' === et_get_option( 'vertex_show_team', 'on' ) ) {
	$args = array(
		'post_type'      => 'team-member',
		'posts_per_page' => -1,
	);
	$et_team_members_query = new WP_Query( apply_filters( 'et_home_team_members_query_args', $args ) );
	$i = 1;

	if ( $et_team_members_query->have_posts() ) : ?>
<section class="home-block et-even">
	<div class="container">
		<header>
			<h1><?php echo esc_html( et_get_option( 'vertex_home_team_title', __( 'Meet Our Amazing Team', 'Vertex' ) ) ); ?></h1>
			<h2><?php echo esc_html( et_get_option( 'vertex_home_team_description', __( 'Our products are built with the hard work of our amazing team.', 'Vertex' ) ) ); ?></h2>
		</header>

		<div id="team-members" class="clearfix">
		<?php
			$i = 0;

			while ( $et_team_members_query->have_posts() ) : $et_team_members_query->the_post();
				$i++;
				$thumb = '';
				$width = (int) apply_filters( 'et_team_member_image_width', 121 );
				$height = (int) apply_filters( 'et_team_member_image_height', 121 );
				$classtext = 'avatar';
				$titletext = get_the_title();
				$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false );
				$thumb = $thumbnail["thumb"];

				$position = get_post_meta( get_the_ID(), '_et_position', true );
				$skill_names  = get_post_meta( get_the_ID(), '_et_skill_name', true );
				$skill_values = get_post_meta( get_the_ID(), '_et_skill_value', true );
		?>
			<div class="team-member <?php if ($thumb=='') echo 'no-image'; ?>">
				<?php if (! empty( $thumb ) ) : ?>
					<div class="member-image">
						<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext ); ?>
					</div>
				<?php endif; ?>

				<div class="title">
					<h3><?php the_title(); ?></h3>
				<?php
					if ( '' !== $position )
						printf( '<p>%s</p>', esc_html( $position ) );
				?>
				</div>

			<?php if ( ! empty( $skill_names ) ) : ?>
				<ul class="skills">
				<?php foreach( $skill_names as $skill_key => $skill_name ) : ?>
					<li>
						<span class="skill-amount" data-skill="<?php echo esc_attr( $skill_values[$skill_key] ); ?>"></span>
						<span class="skill-title"><?php echo esc_html( $skill_name ); ?></span>
						<span class="skill-number"><?php echo esc_html( $skill_values[$skill_key] ); ?>%</span>
					</li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			</div> <!-- .team-member -->
			<?php endwhile; ?>
		</div> <!-- #team-members -->
	</div> <!-- .container -->
</section>
<?php
	endif;
	wp_reset_postdata();
}
?>

<?php get_footer(); ?>
<?php
/*
Template Name: Team Members Page
*/
?>
<?php get_header(); ?>

<div id="content-area">
	<div class="container clearfix fullwidth">
		<div id="main-area">

			<div id="team-members" class="clearfix">
		<?php
			$i = 0;

			$args = array(
				'post_type'      => 'team-member',
				'posts_per_page' => -1,
			);
			$et_team_members_query = new WP_Query( apply_filters( 'et_home_team_members_query_args', $args ) );
			$i = 1;

			if ( $et_team_members_query->have_posts() ) :

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
				<div class="team-member<?php if ( 0 === $i % 3 ) echo ' last'; ?>">
					<div class="team-member-inner clearfix">
						<div class="member-skills">
							<?php if (! empty( $thumb ) ) : ?>
								<div class="member-image">
									<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext ); ?>
								</div>
							<?php endif; ?>

						<?php if ( ! empty( $skill_names ) ) : ?>
							<ul class="skills<?php if ( empty( $thumb ) ) echo ' no-image'; ?>">
							<?php foreach( $skill_names as $skill_key => $skill_name ) : ?>
								<li>
									<span class="skill-amount" data-skill="<?php echo esc_attr( $skill_values[$skill_key] ); ?>"></span>
									<span class="skill-title"><?php echo esc_html( $skill_name ); ?></span>
									<span class="skill-number"><?php echo esc_html( $skill_values[$skill_key] ); ?>%</span>
								</li>
							<?php endforeach; ?>
							</ul>
						<?php endif; ?>
						</div>

						<div class="member-info">
							<div class="title">
								<h3><?php the_title(); ?></h3>
							<?php
								if ( '' !== $position )
									printf( '<span>%s</span>', esc_html( $position ) );
							?>
							</div>

							<div class="entry">
								<?php the_content(); ?>
							</div>
						</div>

					</div> <!-- .team-member -->
				</div> <!-- .team-member -->
				<?php endwhile; ?>
		<?php
			endif;
			wp_reset_postdata();
		?>

			</div> <!-- #team-members -->

		</div> <!-- #main-area -->

	</div> <!-- .container -->
</div> <!-- #content-area -->

<?php get_footer(); ?>
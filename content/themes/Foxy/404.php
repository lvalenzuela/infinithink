<?php get_header(); ?>

	<?php get_template_part( 'includes/breadcrumbs', 'index' ); ?>

	<?php get_template_part( 'includes/top_info', 'index' );  ?>

	<div id="content" class="clearfix">
		<div id="left-area">
				<?php get_template_part( 'includes/no-results', '404' ); ?>
			</div> <!-- end #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #left-area -->

		<?php get_sidebar(); ?>
	</div> <!-- #content -->

<?php get_footer(); ?>
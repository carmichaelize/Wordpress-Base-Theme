<?php get_header(); ?>

<h1>Reviews Page</h1>

	<div id="content">
		<?php if(have_posts()) : ?>

		<?php while(have_posts()): the_post();  ?>

			<div class="post">
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				<div class="entry">

					<?php the_post_thumbnail(); ?>


					<?php the_content('Read On...'); ?>

				</div>
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<?php posts_nav_link(); ?>
		</div>

		<?php endif; ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
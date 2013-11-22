<?php get_header(); ?>

	<div id="content">

		<h2 class='bodytext_one center-text'><i class="icon-search"></i> Search Results for "<?php echo get_search_query(); ?>"</h2>

		<?php if(have_posts()) : ?>

			<?php while(have_posts()) : the_post(); ?>

			<div class="post">

				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				<?php Str::limit( get_the_content(), 300); ?>

				<br /><br />

				<a href="<?php the_permalink(); ?>">Read More</a>

			</div>

			<?php endwhile; ?>

			<div class="navigation">
				<?php previous_posts_link( 'Newer posts &raquo;' ); ?>
        		<?php next_posts_link('Older &raquo;') ?>
			</div>

		<?php else : ?>

			Sorry, No Results Found For "<?php echo get_search_query(); ?>"

		<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
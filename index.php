<?php get_header(); ?>

<div id="content">
	<?php if(have_posts()) : ?> 

		<?php while(have_posts()) : the_post(); ?>

			<div class="post">
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			
				<div class="entry">

					<div class="postmetadata">
					
						Posted in <?php the_category(', ') ?> by  <?php the_author_posts_link(); ?> 

						<br />

						<?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> <?php edit_post_link('Edit', ' &#124; ', ''); ?>

						<br />

						<?php the_time('jS M Y') ?>

						<br />

						<?php the_tags('Tags:', ', ', ''); ?> 

					</div>

					<?php the_post_thumbnail(); ?>
					

					<?php the_content('Read On...'); ?>

				</div>
			</div>

		<?php endwhile; ?>
		
		<div class="navigation">
			<?php posts_nav_link(); ?>
		</div>

	<?php else: ?>

		Sorry, No Entries Found
	
	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
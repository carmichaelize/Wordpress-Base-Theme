<?php get_header(); ?>

<div id="content">

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
		<h2><i class="icon-folder-open"></i> Archive for the "<?php single_cat_title(); ?>" Category:</h2>
	<?php /* If this is a tag archive */ } elseif(is_tag() || is_tax() ) { ?>
		<h2><i class="icon-tags"></i> Posts Tagged "<?php single_tag_title(); ?>":</h2>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2><i class="icon-time"></i> Archive for <?php the_time('F jS, Y'); ?>:</h2>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2><i class="icon-time"></i> Archive for <?php the_time('F, Y'); ?>:</h2>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2><i class="icon-time"></i> Archive for <?php the_time('Y'); ?>:</h2>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2><i class="icon-user"></i> Author Archive <?php wp_title(''); ?>:</h2>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2>Archive</h2>
	<?php } ?>

	<?php if(have_posts()) : ?>

		<?php while(have_posts()) : the_post(); ?>
		
			<div class="post">
				
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				<div class="entry">
				<?php the_content('Read On...'); ?>

					<p class="postmetadata">
					<?php _e('Filed under&#58;'); ?> <?php the_category(', ') ?> <?php _e('by'); ?> <?php  the_author(); ?><br />
					<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <?php edit_post_link('Edit', ' &#124; ', ''); ?>
					</p>

				</div>

			</div>
		
		<?php endwhile; ?>

		<div class="navigation">
			<?php posts_nav_link(); ?>
		</div>

	<?php else : ?>

		Sorry, No Entries Found

	<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
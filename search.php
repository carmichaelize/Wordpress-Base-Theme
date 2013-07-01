<?php get_header(); ?>

<?php 
	//Search Query
	$args = array(
			's'=> $_GET['s'],
			'post_type' => array('post', 'page'),
			'order' => 'ASC',
			'orderby' => 'title',
			'posts_per_page'=> 10
		);
	$search_query = new WP_Query( $args );
?>

	<div id="content">

		<h2 class='bodytext_one center-text'><i class="icon-search"></i> Search Results for "<?php echo get_search_query(); ?>"</h2>

		<?php if($search_query->have_posts()) : ?>

			<?php while($search_query->have_posts()) : $search_query->the_post(); ?>

			<div class="post">

				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					
				<?php Str::limit( get_the_content(), 300); ?>

				<br /><br />

				<a href="<?php the_permalink(); ?>">Read More</a>

			</div>
			
			<?php endwhile; ?>

			<div class="navigation">
				<?php posts_nav_link(); ?>
			</div>

		<?php else : ?>

			Sorry, No Results Found For "<?php echo get_search_query(); ?>"

		<?php endif; ?>

		</div>

<?php get_sidebar(); ?>	

<?php get_footer(); ?>
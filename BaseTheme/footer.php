
	<div class="clear"></div>

	</div>

	<div id="footer">

		<?php if ( is_active_sidebar( 'footer-widget-area' ) ) : ?>
						<div class="footerBucket">
							<ul>
								<?php dynamic_sidebar( 'footer-widget-area' ); ?>
							</ul>
						</div><!-- #first .widget-area -->
		<?php endif; ?>

		<div class="clear"></div>

		<strong>Copyright 2012 <?php bloginfo('name'); ?> | All Rights Reserved.</strong> 
		Designed by <a href="http://www.scottcarmichael.co.uk">Scott Carmichael</a>

	</div>
	
</div>

<?php wp_footer(); ?>

</body>
</html>
				<div class="clear"></div>

			</section><!-- /.inner-wrapper -->

			<footer id="footer">

				<?php if ( is_active_sidebar( 'footer-widget-area' ) ) : ?>
					<div class="footer-bucket">
						<ul>
							<?php dynamic_sidebar( 'footer-widget-area' ); ?>
						</ul>
					</div><!-- #first .widget-area -->
				<?php endif; ?>

				<div class="clear"></div>

				<strong>Copyright 2012 <?php bloginfo('name'); ?> | All Rights Reserved.</strong> 
				Designed by <a href="http://www.scottcarmichael.co.uk">Scott Carmichael</a>

			</footer><!-- /#footer -->
			
		</div><!-- /.wrapper -->

		<?php wp_footer(); ?>

		<!--[if lt IE 8]>
    		<script src="<?php echo TEMPLATE_PATH; ?>/js/json2.js"></script>
  		<![endif]-->

		<!-- jQuery -->
		<script src="<?php echo TEMPLATE_PATH; ?>/js/jquery-1.9.1.min.js"></script>
		<!-- Utilities -->
		<script src="<?php echo TEMPLATE_PATH; ?>/js/utilities.js"></script>
		<!-- Bootstrap -->
		<!--<script src="<?php echo TEMPLATE_PATH; ?>/js/bootstrap.min.js"></script>-->
		<!-- Custom JS-->
		<script src="<?php echo TEMPLATE_PATH; ?>/js/script.js"></script>

	</body>
</html>
				<div class="clear"></div>

			</section><!-- /.inner-wrapper -->

			<footer id="footer">

				<?php global $global_options; ?>
				<!-- Social -->
				<?php if( $global_options->twitter ) : ?>
					<a href="<?php echo $global_options->twitter; ?>"><img src="<?php echo IMG_PATH.'' ?>" alt="Twitter" title="Twitter" /></a>
				<?php endif; ?>
				<?php if( $global_options->facebook ) : ?>
					<a href="<?php echo $global_options->facebook; ?>"><img src="<?php echo IMG_PATH.'' ?>" alt="Facebook" title="Facebook" /></a>
				<?php endif; ?>
				<?php if( $global_options->linkedIn ) : ?>
					<a href="<?php echo $global_options->linkedIn; ?>"><img src="<?php echo IMG_PATH.'' ?>" alt="LinkedIn" title="LinkedIn" /></a>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-widget-area' ) ) : ?>
					<div class="footer-bucket">
						<ul>
							<?php dynamic_sidebar( 'footer-widget-area' ); ?>
						</ul>
					</div>
				<?php endif; ?>

				<div class="clear"></div>

				<strong>Copyright 2012 <?php bloginfo('name'); ?> | All Rights Reserved.</strong> 
				Designed by <a href="http://www.scottcarmichael.co.uk">Scott Carmichael</a>

			</footer><!-- /#footer -->
			
		</div><!-- /.wrapper -->

		<!--[if lt IE 8]>
    		<script src="<?php echo TEMPLATE_PATH; ?>/js/json2.js"></script>
  		<![endif]-->

		<?php wp_footer(); ?>

	</body>
</html>
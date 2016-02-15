<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BSWP
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<div class="container">
			<div class="row">
			<div class="col-md-6 col-lg-6">
				<?php if (has_nav_menu('footer-menu', 'bswp')) { ?>
		            <nav role="navigation">
		            <?php wp_nav_menu(array(
		              'container'       => '',
		              'menu_class'      => 'footer-menu',
		              'theme_location'  => 'footer-menu')
		            ); 
		            ?>
		          </nav>
            	<?php } ?>
			</div>
			<div class="col-md-6 col-lg-6">
			<div class="social-icons">
	               <?php $social_options = bswp_option( 'social_icons' ); ?>
	                   <?php foreach ( $social_options as $key => $value ) {
	                       if ( $value ) { ?>
	                           <a href="<?php echo $value; ?>" title="<?php echo $key; ?>" target="_blank">
	                                <i class="fa fa-<?php echo $key; ?>"></i>
	                            </a>
	                        <?php }
	                    } ?>
            </div><!-- .social-icons -->	
			</div>
		</div><!-- .row -->
		<div class="row">
			<div class="col-md-6 col-lg-6">
				<?php if (bswp_option('custom_copyright') != '') { ?>
				<div class="copyright">
					<?php echo bswp_option('custom_copyright'); ?>
				</div>
				<?php } ?>
				
			</div>
			<div class="col-md-6 col-lg-6">
				<?php if (bswp_option('custom_power') != '') { ?>
				<div class="poweredby">
					<?php echo bswp_option('custom_power'); ?>
				</div>
				<?php } ?>	
			</div>

		</div><!-- .row -->
	</div><!-- .containr -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

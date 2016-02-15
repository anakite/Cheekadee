<?php
/**
 * The sidebar containing the contact sidebar widget area.
 *
 * @package bswp
 */

if ( ! is_active_sidebar( 'contact' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area col-md-3 col-lg-3" role="complementary">
	<div class="well">
		<?php dynamic_sidebar( 'contact' ); ?>
	</div>
</div><!-- #secondary -->

</div> <!-- .row -->
</div> <!-- .container -->
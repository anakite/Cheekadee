<?php
/**
 * File used for homepage widget module
 *
 * @package WordPress
 */
?>

<div class="home-widgets">
	<div class="row">
		<div class="col-lg-4 col-md-4">
			<?php dynamic_sidebar( 'home-1' ); ?>
		</div>

		<div class="col-lg-4 col-md-4">
			<?php dynamic_sidebar( 'home-2' ); ?>
		</div>

		<div class="col-lg-4 col-md-4">
			<?php dynamic_sidebar( 'home-3' ); ?>
		</div>

	</div><!--row-->
</div>
<?php
/**
 * The template for displaying all single portfolio.
 * now on github
 * @package bswp
 */

get_header(); ?>

<div class="container">
	<div class="row">

	<div id="primary" class="col-lg-12">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content','portfolio' ); ?>

			<?php // remove comment section from portfolio post
				// If comments are open or we have at least one comment, load up the comment template
				//if ( comments_open() || '0' != get_comments_number() ) :
					//comments_template();
				//endif;
			?>


		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

</div>
</div>
<?php get_footer();

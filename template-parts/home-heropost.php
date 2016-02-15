<?php
/**
 * File used for homepage hero post module
 *
 * @package WordPress
 */
?>


<div class="jumbotron homehero">

	<?php 
			// the query
			$homepost = new WP_Query('posts_per_page=1&ignore_sticky_posts=1'); ?>


			<?php while ( $homepost->have_posts() ) : $homepost->the_post(); ?>

			<?php global $more; $more = 0; ?>

			<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; ?>

</div>
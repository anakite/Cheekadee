<?php
/**
 * @package WordPress
 * @subpackage bswp
 * Template Name: Homepage
 */
?>

<?php get_header(); ?>

<div class="container">
	<?php
	// Loop through homepage modules and get their corresponding files
	// See your theme's template-parts folder for editing these modules
    global $bswp_options;
    $homepage_modules = $bswp_options['homepage-layout']['enabled'];
    if ($homepage_modules):
		// Loop through each module
    	foreach ($homepage_modules as $key=>$value) :

			$value = preg_replace('/\s*/', '', $value); // remove white spaces
			$value = strtolower($value); // lowercase
    		get_template_part('template-parts/home', $value); // get correct file for each module
   		endforeach;
	endif; ?>
</div>

<?php get_footer(); ?>
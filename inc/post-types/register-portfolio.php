<?php

$portfolio = new CPT(array(
    'post_type_name' => 'portfolio',
    'singular' => __('Portfolio', 'bswp'),
    'plural' => __('Portfolio', 'bswp'),
    'slug' => 'portfolio'
),
	array(
    'supports' => array('title', 'editor', 'thumbnail', 'comments'),
    'menu_icon' => 'dashicons-portfolio'
));

$portfolio->register_taxonomy(array(
    'taxonomy_name' => 'portfolio_tags',
    'singular' => __('Portfolio Tag', 'bswp'),
    'plural' => __('Portfolio Tags', 'bswp'),
    'slug' => 'portfolio-tag'
));
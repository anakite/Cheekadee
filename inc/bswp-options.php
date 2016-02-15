<?php
/**
 * @package bootstrapwp
 */
 
if ( ! function_exists('bswp_option') ) {
	function bswp_option($id, $fallback = false, $param = false ) {
		global $bswp_options;
		if ( $fallback == false ) $fallback = '';
		$output = ( isset($bswp_options[$id]) && $bswp_options[$id] !== '' ) ? $bswp_options[$id] : $fallback;
		if ( !empty($bswp_options[$id]) && $param ) {
			$output = $bswp_options[$id][$param];
		}
		return $output;
	}
}
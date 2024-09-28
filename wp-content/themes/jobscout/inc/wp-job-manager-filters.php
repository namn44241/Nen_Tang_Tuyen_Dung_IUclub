<?php
/**
 * Filter to modify functionality of WP Job Manager plugin.
 *
 * @package JobScout 
 */

if( ! function_exists( 'job_board_taxonomy_publicview_modified_filter' ) ){
	/**
	 * Filter to modify job listing
	 */    
	function job_board_taxonomy_publicview_modified_filter( $public ) {
		$public['public'] = true;
		 return $public;
	}
}
add_filter( 'register_taxonomy_job_listing_type_args', 'job_board_taxonomy_publicview_modified_filter' );
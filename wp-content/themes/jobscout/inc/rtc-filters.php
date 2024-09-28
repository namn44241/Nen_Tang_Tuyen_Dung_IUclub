<?php
/**
 * Filter to modify functionality of RTC plugin.
 *
 * @package JobScout
 */

if( ! function_exists( 'jobscout_cta_section_bgcolor_filter' ) ){
	/**
	 * Filter to add bg color of cta section widget
	 */    
	function jobscout_cta_section_bgcolor_filter(){
		return '#2ace5e';
	}
}
add_filter( 'rrtc_cta_bg_color', 'jobscout_cta_section_bgcolor_filter' );

if( ! function_exists( 'jobscout_cta_btn_alignment_filter' ) ){
	/**
	 * Filter to add btn alignment of cta section widget
	 */    
	function jobscout_cta_btn_alignment_filter(){
		return 'centered';
	}
}
add_filter( 'rrtc_cta_btn_alignment', 'jobscout_cta_btn_alignment_filter' );

if( ! function_exists( 'jobscout_theme_slug' ) ){
	/**
	 * Filter to add theme slug
	 */    
	function jobscout_theme_slug(){
		return 'jobscout';
	}
}
add_filter( 'theme_slug', 'jobscout_theme_slug' );

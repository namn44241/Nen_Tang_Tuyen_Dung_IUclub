<?php
/**
 * Front Page Settings
 *
 * @package jobscout
 */
if ( ! function_exists( 'jobscout_customize_register_frontpage' ) ) :

function jobscout_customize_register_frontpage( $wp_customize ) {
	
    /** Front Page Settings */
    $wp_customize->add_panel( 
        'frontpage_settings',
         array(
            'priority'    => 40,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Front Page Settings', 'jobscout' ),
            'description' => __( 'Static Home Page settings.', 'jobscout' ),
        ) 
    );     
}
endif;
add_action( 'customize_register', 'jobscout_customize_register_frontpage' );
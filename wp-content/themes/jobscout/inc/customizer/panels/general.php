<?php
/**
 * General Settings
 *
 * @package jobscout
 */

if ( ! function_exists( 'jobscout_customize_register_general' ) ) :

function jobscout_customize_register_general( $wp_customize ){
    
    /** General Settings */
    $wp_customize->add_panel( 
        'general_settings',
         array(
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'General Settings', 'jobscout' ),
            'description' => __( 'Customize Header, Social, Sharing, SEO, Post/Page, Newsletter, Performance and Miscellaneous settings.', 'jobscout' ),
        ) 
    );
}
endif;
add_action( 'customize_register', 'jobscout_customize_register_general' );
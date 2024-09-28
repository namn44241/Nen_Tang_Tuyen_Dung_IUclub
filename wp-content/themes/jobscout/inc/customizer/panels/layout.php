<?php
/**
 * Layout Settings
 *
 * @package jobscout
 */
if ( ! function_exists( 'jobscout_customize_register_layout' ) ) :

function jobscout_customize_register_layout( $wp_customize ) {
    
    /** Layout Settings */
    $wp_customize->add_panel( 
        'layout_settings',
         array(
            'priority'    => 30,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Layout Settings', 'jobscout' ),
            'description' => __( 'Change different page layout from here.', 'jobscout' ),
        ) 
    );
}
endif;
add_action( 'customize_register', 'jobscout_customize_register_layout' );
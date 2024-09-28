<?php
/**
 * Contact Page Settings
 *
 * @package jobscout
 */

if ( ! function_exists( 'jobscout_customize_register_contact' ) ) :

function jobscout_customize_register_contact( $wp_customize ) {
    
    $wp_customize->add_panel( 
        'contact_page_setting', 
        array(
            'title'       => __( 'Contact Page Settings', 'jobscout' ),
            'priority'    => 45,
            'capability'  => 'edit_theme_options',
            'description' => __( 'Contact Form, Google Map and Contact Details settings.', 'jobscout' ),
        ) 
    );
}
endif;
add_action( 'customize_register', 'jobscout_customize_register_contact' );
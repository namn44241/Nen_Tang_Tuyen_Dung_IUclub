<?php
/**
 * Appearance Settings
 *
 * @package jobscout
 */

if ( ! function_exists( 'jobscout_customize_register_appearance' ) ) :

function jobscout_customize_register_appearance( $wp_customize ) {
    
    $wp_customize->add_panel( 
        'appearance_settings', 
        array(
            'title'       => __( 'Appearance Settings', 'jobscout' ),
            'priority'    => 25,
            'capability'  => 'edit_theme_options',
            'description' => __( 'Change color and body background.', 'jobscout' ),
        ) 
    );

    /** Typography */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography', 'jobscout' ),
            'priority' => 70,
            'panel'    => 'appearance_settings',
        )
    );

    $wp_customize->add_setting(
        'ed_localgoogle_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'jobscout_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'ed_localgoogle_fonts',
        array(
            'label'   => __( 'Load Google Fonts Locally', 'jobscout' ),
            'section' => 'typography_settings',
            'type'    => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'ed_preload_local_fonts',
        array(
            'default'           => false,
            'sanitize_callback' => 'jobscout_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'ed_preload_local_fonts',
        array(
            'label'           => __( 'Preload Local Fonts', 'jobscout' ),
            'section'         => 'typography_settings',
            'type'            => 'checkbox',
            'active_callback' => 'jobscout_flush_fonts_callback'
        )
    );
    

    $wp_customize->add_setting(
        'flush_google_fonts',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses',
        )
    );

    $wp_customize->add_control(
        'flush_google_fonts',
        array(
            'label'       => __( 'Flush Local Fonts Cache', 'jobscout' ),
            'description' => __( 'Click the button to reset the local fonts cache.', 'jobscout' ),
            'type'        => 'button',
            'settings'    => array(),
            'section'     => 'typography_settings',
            'input_attrs' => array(
                'value' => __( 'Flush Local Fonts Cache', 'jobscout' ),
                'class' => 'button button-primary flush-it',
            ),
            'active_callback' => 'jobscout_flush_fonts_callback'
        )
    );
    
    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'colors' )->panel                 = 'appearance_settings';
    $wp_customize->get_section( 'colors' )->priority              = 30;
    $wp_customize->get_section( 'background_image' )->panel       = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority    = 35;
    $wp_customize->get_section( 'background_image' )->title       = __( 'Background', 'jobscout' );
    $wp_customize->get_control( 'background_color' )->description = __( 'Background color of the theme.', 'jobscout' );
    $wp_customize->get_section( 'typography_settings' )->panel    = 'appearance_settings';
}
endif;
add_action( 'customize_register', 'jobscout_customize_register_appearance' );

function jobscout_flush_fonts_callback( $control ){
    $ed_localgoogle_fonts   = $control->manager->get_setting( 'ed_localgoogle_fonts' )->value();
    $control_id   = $control->id;
    
    if ( $control_id == 'flush_google_fonts' && $ed_localgoogle_fonts ) return true;
    if ( $control_id == 'ed_preload_local_fonts' && $ed_localgoogle_fonts ) return true;
    return false;
}
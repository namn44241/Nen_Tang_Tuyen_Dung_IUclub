<?php
/**
 * Breadcrumbs Settings
 *
 * @package jobscout
 */

if ( ! function_exists( 'jobscout_customize_register_breadcrumbs' ) ) :

function jobscout_customize_register_breadcrumbs( $wp_customize ){
    
    /** Breadcrumbs Settings */
    $wp_customize->add_section(
        'breadcrumbs_settings',
        array(
            'title'    => __( 'Breadcrumbs Settings', 'jobscout' ),
            'priority' => 65,
        )
    );

    /** Enable Breadcrumbs */
    $wp_customize->add_setting( 
        'ed_breadcrumbs', 
        array(
            'default'           => false,
            'sanitize_callback' => 'jobscout_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new JobScout_Toggle_Control( 
            $wp_customize,
            'ed_breadcrumbs',
            array(
                'section'     => 'breadcrumbs_settings',
                'label'       => __( 'Enable Breadcrumbs', 'jobscout' ),
                'description' => __( 'Enable to show breadcrumbs.', 'jobscout' ),
            )
        )
    );

    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'breadcrumb_home_text',
        array(
            'default'           => __( 'Home', 'jobscout' ),
            'sanitize_callback' => 'sanitize_text_field', 
        )
    );
    
    $wp_customize->add_control(
        'breadcrumb_home_text',
        array(
            'type'    => 'text',
            'section' => 'breadcrumbs_settings',
            'label'   => __( 'Breadcrumb Home Text', 'jobscout' ),
        )
    );

    /** Breadcrumb Separator */
    $wp_customize->add_setting(
        'breadcrumb_separator',
        array(
            'default'           => __( '>', 'jobscout' ),
            'sanitize_callback' => 'sanitize_text_field', 
        )
    );
    
    $wp_customize->add_control(
        'breadcrumb_separator',
        array(
            'type'    => 'text',
            'section' => 'breadcrumbs_settings',
            'label'   => __( 'Breadcrumb Separator', 'jobscout' ),
        )
    );

}
endif;
add_action( 'customize_register', 'jobscout_customize_register_breadcrumbs' );
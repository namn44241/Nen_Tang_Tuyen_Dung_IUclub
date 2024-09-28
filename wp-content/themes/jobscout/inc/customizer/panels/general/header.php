<?php
/**
 * Header Settings
 *
 * @package jobscout
 */
if ( ! function_exists( 'jobscout_customize_register_general_header' ) ) :

function jobscout_customize_register_general_header( $wp_customize ) {
    
    /** Header Settings */
    $wp_customize->add_section(
        'header_settings',
        array(
            'title'    => __( 'Header Settings', 'jobscout' ),
            'priority' => 15,
            'panel'    => 'general_settings',
        )
    );
    
    /** Post Job Label */
    $wp_customize->add_setting(
        'post_job_label',
        array(
            'default'           => __( 'Post Jobs', 'jobscout' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'post_job_label',
        array(
            'type'    => 'text',
            'section' => 'header_settings',
            'label'   => __( 'Post Job Label', 'jobscout' ),
        )
    );

    $wp_customize->selective_refresh->add_partial( 'post_job_label', array(
        'selector' => '.site-header .header-main .btn-wrap a.btn',
        'render_callback' => 'jobscout_get_header_post_job_label',
    ) );
    
    /** Post Job Url */
    $wp_customize->add_setting(
        'post_job_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw' 
        )
    );
    
    $wp_customize->add_control(
        'post_job_url',
        array(
            'type'    => 'url',
            'section' => 'header_settings',
            'label'   => __( 'Post Job Url', 'jobscout' ),
        )
    );
    /** Header Settings Ends */
}
endif;
add_action( 'customize_register', 'jobscout_customize_register_general_header' );
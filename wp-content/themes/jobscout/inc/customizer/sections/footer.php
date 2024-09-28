<?php
/**
 * Footer Setting
 *
 * @package jobscout
 */
if ( ! function_exists( 'jobscout_customize_register_footer' ) ) :

function jobscout_customize_register_footer( $wp_customize ) {
    
    $wp_customize->add_section(
        'footer_settings',
        array(
            'title'      => __( 'Footer Settings', 'jobscout' ),
            'priority'   => 199,
            'capability' => 'edit_theme_options',
        )
    );
    
    /** Footer Copyright */
    $wp_customize->add_setting(
        'footer_copyright',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'footer_copyright',
        array(
            'label'       => __( 'Footer Copyright Text', 'jobscout' ),
            'section'     => 'footer_settings',
            'type'        => 'textarea',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'footer_copyright', array(
        'selector'        => '.copyright .copyright-text',
        'render_callback' => 'jobscout_get_footer_copyright',
    ) );

}
endif;
add_action( 'customize_register', 'jobscout_customize_register_footer' );
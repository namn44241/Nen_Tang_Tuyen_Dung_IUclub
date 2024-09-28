<?php
/**
 * Blog Section
 *
 * @package jobscout
 */
if ( ! function_exists( 'jobscout_customize_register_frontpage_blog' ) ) :

function jobscout_customize_register_frontpage_blog( $wp_customize ){

    /** Blog Section */
    $wp_customize->add_section(
        'blog_section',
        array(
            'title'    => __( 'Blog Section', 'jobscout' ),
            'priority' => 35,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable/Disable Section */
    $wp_customize->add_setting( 
        'ed_blog_section', 
        array(
            'default'           => true,
            'sanitize_callback' => 'jobscout_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new JobScout_Toggle_Control( 
            $wp_customize,
            'ed_blog_section',
            array(
                'section'     => 'blog_section',
                'label'       => __( 'Enable/Disable Blog Section', 'jobscout' ),
                'description' => __( 'Enable Blog Section to display latest posts in the Front Page', 'jobscout' ),
            )
        )
    );

    /** Blog title */
    $wp_customize->add_setting(
        'blog_section_title',
        array(
            'default'           => __( 'Latest Articles', 'jobscout' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_title',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Blog Title', 'jobscout' ),
            'type'    => 'text',
        )
    );

    /** Selective refresh for blog title. */
    $wp_customize->selective_refresh->add_partial( 'blog_section_title', array(
        'selector'            => '.article-section .container h2.section-title',
        'render_callback'     => 'jobscout_get_blog_section_title',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    /** Blog description */
    $wp_customize->add_setting(
        'blog_section_subtitle',
        array(
            'default'           => __( 'We will help you find it. We are your first step to becoming everything you want to be.', 'jobscout' ),
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_section_subtitle',
        array(
            'section' => 'blog_section',
            'label'   => __( 'Blog Description', 'jobscout' ),
            'type'    => 'text',
        )
    ); 

    /** Selective refresh for blog description. */
    $wp_customize->selective_refresh->add_partial( 'blog_section_subtitle', array(
        'selector'            => '.article-section .container .section-desc',
        'render_callback'     => 'jobscout_get_blog_section_description',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );
    
    
    /** View All Label */
    $wp_customize->add_setting(
        'blog_view_all',
        array(
            'default'           => __( 'Browse All', 'jobscout' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'blog_view_all',
        array(
            'label'           => __( 'View All Label', 'jobscout' ),
            'section'         => 'blog_section',
            'type'            => 'text',
            'active_callback' => 'jobscout_blog_view_all_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'blog_view_all', array(
        'selector'            => '.article-section .btn-wrap .btn',
        'render_callback'     => 'jobscout_get_blog_view_all_btn',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) ); 
    /** Blog Section Ends */  

}
endif;
add_action( 'customize_register', 'jobscout_customize_register_frontpage_blog' );
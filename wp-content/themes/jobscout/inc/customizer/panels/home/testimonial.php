<?php
/**
 * Testimonial Section
 *
 * @package jobscout
 */
if ( ! function_exists( 'jobscout_customize_register_frontpage_testimonial' ) ) :

function jobscout_customize_register_frontpage_testimonial( $wp_customize ){

    $raratheme_companion_activated = jobscout_is_rara_theme_companion_activated();

    /** Testimonial Section */
    $wp_customize->add_section(
        'testimonial_section',
        array(
            'title'    => __( 'Testimonial Section', 'jobscout' ),
            'priority' => 45,
            'panel'    => 'frontpage_settings',
        )
    );

     /** Enable/Disable Section */
    $wp_customize->add_setting( 
        'ed_hometestimonial', 
        array(
            'default'           => true,
            'sanitize_callback' => 'jobscout_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new JobScout_Toggle_Control( 
            $wp_customize,
            'ed_hometestimonial',
            array(
                'section'     => 'testimonial_section',
                'label'       => __( 'Enable/Disable Testimonial Section', 'jobscout' ),
                'description' => __( 'Enable Testimonial to display the testimonials in the Front Page', 'jobscout' ),
            )
        )
    );

    /** Testimonial title */
    $wp_customize->add_setting(
        'testimonial_section_title',
        array(
            'default'           => __( 'Clients Testimonials', 'jobscout' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'testimonial_section_title',
        array(
            'section' => 'testimonial_section',
            'label'   => __( 'Testimonial Title', 'jobscout' ),
            'type'    => 'text',
        )
    );

    /** Selective refresh for testimonial section title. */
    $wp_customize->selective_refresh->add_partial( 'testimonial_section_title', array(
        'selector'            => '.testimonial-section .container h2.section-title',
        'render_callback'     => 'jobscout_get_testimonial_section_title',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    /** Testimonial description */
    $wp_customize->add_setting(
        'testimonial_section_subtitle',
        array(
            'default'           => __( 'We will help you find it. We are your first step to becoming everything you want to be.', 'jobscout' ),
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'testimonial_section_subtitle',
        array(
            'section' => 'testimonial_section',
            'label'   => __( 'Testimonial Description', 'jobscout' ),
            'type'    => 'text',
        )
    ); 

    /** Selective refresh for blog description. */
    $wp_customize->selective_refresh->add_partial( 'testimonial_section_subtitle', array(
        'selector'            => '.testimonial-section .container .section-desc',
        'render_callback'     => 'jobscout_get_testimonial_section_description',
        'container_inclusive' => false,
        'fallback_refresh'    => true,
    ) );

    if( ! $raratheme_companion_activated ){
        $wp_customize->add_setting(
            'homepage_testimonial_section_note',
            array(
                'sanitize_callback' => 'wp_kses_post'
            )
        );
    
        $wp_customize->add_control(
            new JobScout_Note_Control( 
                $wp_customize,
                'homepage_testimonial_section_note',
                array(
                    'section'      => 'testimonial_section', 
                    'description' => sprintf( __( 'Please install/activate the %1$sRaraTheme Companion%2$s to add "Rara: Testimonial" Widget.', 'jobscout' ), '<a href="' . admin_url( 'themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">', '</a>' ),
                )
            )
        );
    }

    $wp_customize->add_setting(
        'homepage_testimonial_sectiondisplay_note',
        array(
            'sanitize_callback' => 'wp_kses_post'
        )
    );

    $wp_customize->add_control(
        new JobScout_Note_Control( 
            $wp_customize,
            'homepage_testimonial_sectiondisplay_note',
            array(
                'section'      => 'testimonial_section', 
                'description' => sprintf( '<hr><b>%1$s</b>', __( 'Add "Rara: Testimonial" widget for testimonial section.', 'jobscout' ) ),
            )
        )
    );

    $home_testimonial_settings = $wp_customize->get_section( 'sidebar-widgets-testimonial' );

    if ( ! empty( $home_testimonial_settings ) ) {
        $home_testimonial_settings->panel = 'frontpage_settings';
        $home_testimonial_settings->priority = 40;
        $wp_customize->get_section( 'sidebar-widgets-testimonial' )->title       = __( 'Testimonial Section','jobscout' );
        $wp_customize->get_control( 'ed_hometestimonial' )->section       = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'ed_hometestimonial' )->priority      = -1;
        $wp_customize->get_control( 'testimonial_section_title' )->section       = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_section_title' )->priority      = -1;
        $wp_customize->get_control( 'testimonial_section_subtitle' )->section    = 'sidebar-widgets-testimonial';
        $wp_customize->get_control( 'testimonial_section_subtitle' )->priority   = -1;
        if( ! $raratheme_companion_activated  ) {
            $wp_customize->get_control( 'homepage_testimonial_section_note' )->section  = 'sidebar-widgets-testimonial';
            $wp_customize->get_control( 'homepage_testimonial_section_note' )->priority  = -7;
        }
        $wp_customize->get_control( 'homepage_testimonial_sectiondisplay_note' )->section ='sidebar-widgets-testimonial';
        $wp_customize->get_control( 'homepage_testimonial_sectiondisplay_note' )->priority  = -1;
    }
    /** Testimonial Section Ends */  

}
endif;
add_action( 'customize_register', 'jobscout_customize_register_frontpage_testimonial' );
<?php
/**
 * Job Posting Section
 *
 * @package jobscout
 */
if ( ! function_exists( 'jobscout_customize_register_frontpage_job_posting' ) ) :

function jobscout_customize_register_frontpage_job_posting( $wp_customize ){

    $wpjob_manager_activated = jobscout_is_wp_job_manager_activated();

    /** Job Posting Section */
    $wp_customize->add_section(
        'job_posting_section',
        array(
            'title'    => __( 'Job Posting Section', 'jobscout' ),
            'priority' => 20,
            'panel'    => 'frontpage_settings',
        )
    );

    /** Enable/Disable Section */
    $wp_customize->add_setting( 
        'ed_jobposting_section', 
        array(
            'default'           => true,
            'sanitize_callback' => 'jobscout_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new JobScout_Toggle_Control( 
            $wp_customize,
            'ed_jobposting_section',
            array(
                'section'     => 'job_posting_section',
                'label'       => __( 'Enable/Disable Job Posting Section', 'jobscout' ),
                'description' => __( 'Enable Job Section to display the jobs listed in the Front Page', 'jobscout' ),
            )
        )
    );

    /** Job Posting title */
    $wp_customize->add_setting(
        'job_posting_section_title',
        array(
            'default'           => __( 'Job Posting', 'jobscout' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'job_posting_section_title',
        array(
            'section' => 'job_posting_section',
            'label'   => __( 'Job Posting Title', 'jobscout' ),
            'type'    => 'text',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'job_posting_section_title', array(
        'selector' => '.top-job-section .container h2.section-title',
        'render_callback' => 'jobscout_get_job_posting_section_title',
    ) );

    if( ! $wpjob_manager_activated ){
        $wp_customize->add_setting(
            'job_posting_section_note', array(
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control(
            new JobScout_Plugin_Recommend_Control(
                $wp_customize, 'job_posting_section_note', array(
                    'label'       => __( 'Instructions', 'jobscout' ),
                    'section'     => 'job_posting_section',
                    'capability'  => 'install_plugins',
                    'plugin_slug' => 'wp-job-manager',
                    'description' => __( 'Please install the recommended plugin "WP Job Manager" for setting of this section.', 'jobscout' )
                )
            )
        );
    }
    /** Job Posting Section Ends */  

}
endif;
add_action( 'customize_register', 'jobscout_customize_register_frontpage_job_posting' );